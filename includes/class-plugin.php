<?php
declare(strict_types=1);

namespace Bank_Statistics;

if (!defined('ABSPATH')) { exit; }

final class Plugin
{
    private static ?Plugin $instance = null;

    /** @var array<string,string> base => SQL template ({{prefix}} placeholder allowed) */
    private array $sqlMap = [];

    /** @var string[] registered shortcode tags */
    private array $shortcodes = [];

    /** cache TTL in seconds */
    private int $cacheTtl = 300;

    /** @var array<string,array> debug info keyed by base (with window if any) */
    private array $debug = [];

    /** Windows (in days) for auto-generated variants, e.g. base_7_* */
    private array $autoWindows = [7];

    public static function instance(): Plugin
    {
        if (self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    private function __construct()
    {
        // Load SQL map
        $this->sqlMap = require BANK_STATISTICS_PATH . 'includes/sql-map.php';

        // Optional explicit list; if empty, build automatically from bases + windows
        $maybeList = require BANK_STATISTICS_PATH . 'includes/shortcodes-list.php';
        if (is_array($maybeList) && !empty($maybeList)) {
            $this->shortcodes = array_values(array_unique(array_map('strval', $maybeList)));
        } else {
            $this->shortcodes = $this->build_shortcodes_list(array_keys($this->sqlMap), $this->autoWindows);
        }

        $this->cacheTtl = (int) apply_filters('bank_statistics_cache_ttl', $this->cacheTtl);

        add_action('init', [$this, 'ensure_utf8_connection'], 0);
        add_action('init', [$this, 'register_shortcodes'], 1);
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
        add_action('admin_post_bank_statistics_clear_cache', [$this, 'handle_clear_cache']);
    }

    /* ========= DB connection charset (safety) ========= */

    public function ensure_utf8_connection(): void
    {
        global $wpdb;
        // Harmless if already set – prevents collation errors with Cyrillic strings.
        $wpdb->query("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");
        $wpdb->query("SET collation_connection = utf8mb4_general_ci");
    }

    /* ========= Shortcodes ========= */

    private function build_shortcodes_list(array $bases, array $windows): array
    {
        $suffixes = [
            '_amount_total',
            '_count_total',
            '_status_success_total',
            '_status_failed_total',
        ];

        $tags = [];

        // Plain bases
        foreach ($bases as $b) {
            foreach ($suffixes as $s) $tags[] = $b . $s;
        }

        // Windowed bases (e.g., base_7)
        foreach ($windows as $d) {
            foreach ($bases as $b) {
                $bw = "{$b}_{$d}";
                foreach ($suffixes as $s) $tags[] = $bw . $s;
            }
        }

        $tags = array_values(array_unique($tags));

        return apply_filters('bank_statistics_shortcodes_list', $tags, $bases, $windows);
    }

    public function register_shortcodes(): void
    {
        foreach ($this->shortcodes as $sc) {
            add_shortcode($sc, function () use ($sc) {
                return $this->handle_shortcode($sc);
            });
        }
    }

    private function handle_shortcode(string $tag): string
    {
        [$baseWithWindow, $isAmount] = $this->parse_tag($tag);
        if ($baseWithWindow === null) return '0';

        $row = $this->get_base_row($baseWithWindow, false)['row'] ?? [];
        $val = $this->value_from_row($tag, $row);

        return $this->format_value($isAmount, $val);
    }

    /** Returns [baseWithWindow|null, isAmount] */
    private function parse_tag(string $tag): array
    {
        $suffixes = [
            '_amount_total'         => true,
            '_count_total'          => false,
            '_status_success_total' => false,
            '_status_failed_total'  => false,
        ];
        foreach ($suffixes as $suf => $isAmount) {
            if (str_ends_with($tag, $suf)) {
                $base = substr($tag, 0, -strlen($suf));
                return [$base, $isAmount];
            }
        }
        return [null, false];
    }

    /**
     * Split "incoming_bisera_7" -> ["incoming_bisera", 7]
     * For bases like "target_2", do NOT treat trailing "_2" as a window,
     * because 2 is not in the allowed windows list.
     */
    private function split_window(string $baseWithWindow): array
    {
        if (preg_match('/^(.*)_([0-9]+)$/', $baseWithWindow, $m)) {
            $n = (int) $m[2];
            if (in_array($n, $this->autoWindows, true)) {
                return [$m[1], $n];
            }
        }
        return [$baseWithWindow, null];
    }

    /** Convert meta_key/meta_value usages to utf8mb4 to avoid collation errors */
    private function normalize_collations(string $sql): string
    {
        return preg_replace('/\b(m\d+)\.(meta_(?:key|value))\b/i', 'CONVERT($1.$2 USING utf8mb4)', $sql);
    }

    /** Inject table prefix and optional date window */
    private function prepare_sql(string $sqlTemplate, ?int $days): string
    {
        global $wpdb;
        $sql = strtr($sqlTemplate, ['{{prefix}}' => $wpdb->prefix]);

        // Fix collations on postmeta fields
        $sql = $this->normalize_collations($sql);

        // If a window is requested (e.g., 7 days), add a post_date filter
        if ($days !== null && $days > 0) {
            $sql = rtrim($sql);
            $hasSemi = substr($sql, -1) === ';';
            if ($hasSemi) $sql = substr($sql, 0, -1);

            $clause = "DATE(p.post_date) >= (CURRENT_DATE - INTERVAL {$days} DAY)";

            if (preg_match('/\bWHERE\b/i', $sql)) {
                $sql .= " AND {$clause}";
            } else {
                $sql .= " WHERE {$clause}";
            }
            $sql .= ';';
        }
        return $sql;
    }

    /**
     * Compute (or fetch cached) aggregated row for a base (with optional window suffix).
     * @return array{row:array<string,mixed>, debug:array}
     */
    public function get_base_row(string $baseWithWindow, bool $nocache = false): array
    {
        global $wpdb;

        [$sqlBase, $days] = $this->split_window($baseWithWindow);

        $result = [
            'row'   => [],
            'debug' => [
                'base'        => $baseWithWindow,
                'cached'      => false,
                'time_ms'     => 0.0,
                'error'       => '',
                'cache_key'   => '',
                'sql_used'    => '',
                'last_query'  => '',
            ],
        ];

        if (!isset($this->sqlMap[$sqlBase])) {
            $result['debug']['error'] = "Unknown base: {$sqlBase}";
            $this->debug[$baseWithWindow] = $result['debug'];
            return $result;
        }

        $cacheKey = 'bank_stats_row_' . md5($baseWithWindow . '|' . $wpdb->prefix);
        $result['debug']['cache_key'] = $cacheKey;

        if (!$nocache) {
            $cached = get_transient($cacheKey);
            if ($cached !== false && is_array($cached)) {
                $result['row'] = $cached;
                $result['debug']['cached'] = true;
                $this->debug[$baseWithWindow] = $result['debug'];
                return $result;
            }
        }

        $sql = $this->prepare_sql($this->sqlMap[$sqlBase], $days);
        $result['debug']['sql_used'] = $sql;

        $t0  = microtime(true);
        $row = $wpdb->get_row($sql, ARRAY_A);
        $dt  = (microtime(true) - $t0) * 1000.0;

        $result['debug']['time_ms']    = round($dt, 2);
        $result['debug']['last_query'] = (string) $wpdb->last_query;
        if (!empty($wpdb->last_error)) $result['debug']['error'] = (string) $wpdb->last_error;

        if (!is_array($row)) $row = [];
        $result['row'] = $row;

        if (!$nocache && empty($result['debug']['error'])) {
            set_transient($cacheKey, $row, $this->cacheTtl);
        }

        $this->debug[$baseWithWindow] = $result['debug'];
        return $result;
    }

    public function compute_rows_for_bases(array $bases, bool $nocache = false): array
    {
        $out = [];
        foreach ($bases as $b) $out[$b] = $this->get_base_row($b, $nocache);
        return $out;
    }

    private function value_from_row(string $tag, array $row): float
    {
        return isset($row[$tag]) ? (float) $row[$tag] : 0.0;
    }

    private function format_value(bool $isAmount, float $val): string
    {
        return $isAmount ? number_format($val, 2, '.', ' ') : number_format($val, 0, '.', ' ');
    }

    /** Group keys for admin: keep window suffix as part of the base label */
    public function all_bases(): array
    {
        $bases = [];
        foreach ($this->shortcodes as $sc) {
            $b = preg_replace('/_(amount|count|status_success|status_failed)_total$/', '', $sc);
            if ($b) $bases[$b] = true;
        }
        return array_keys($bases);
    }

    public function shortcodes(): array { return $this->shortcodes; }
    public function debug_log(): array  { return $this->debug; }

    /* ========= Admin ========= */

    public function admin_menu(): void
    {
        add_menu_page(
            __('Bank Statistics', 'bank-statistics'),
            __('Bank Statistics', 'bank-statistics'),
            'manage_options',
            'bank-statistics',
            [$this, 'render_admin'],
            'dashicons-chart-area',
            81
        );
    }

    public function enqueue_admin(string $hook): void
    {
        if ($hook !== 'toplevel_page_bank-statistics') return;
        wp_enqueue_style('bank-statistics-admin', BANK_STATISTICS_URL . 'assets/admin.css', [], BANK_STATISTICS_VERSION);
        wp_enqueue_script('bank-statistics-admin', BANK_STATISTICS_URL . 'assets/admin.js', ['jquery'], BANK_STATISTICS_VERSION, true);
    }

    public function render_admin(): void
    {
        $shortcodes = $this->shortcodes();
        $bases      = $this->all_bases();

        $nocache  = isset($_GET['nocache']) && $_GET['nocache'] === '1';
        $show_sql = isset($_GET['show_sql']) && $_GET['show_sql'] === '1';

        $rowsByBase = $this->compute_rows_for_bases($bases, $nocache);
        $debug      = $this->debug_log();

        include BANK_STATISTICS_PATH . 'includes/admin-page.php';
    }

    public function handle_clear_cache(): void
    {
        if (!current_user_can('manage_options')) wp_die(__('Not allowed', 'bank-statistics'));
        check_admin_referer('bank_statistics_clear_cache');

        global $wpdb;
        $like = $wpdb->esc_like('_transient_bank_stats_') . '%';
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s", $like));
        $like = $wpdb->esc_like('_transient_timeout_bank_stats_') . '%';
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s", $like));

        wp_redirect(add_query_arg(['page'=>'bank-statistics','cleared'=>'1'], admin_url('admin.php')));
        exit;
    }
}
