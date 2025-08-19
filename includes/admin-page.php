<?php
if (!defined('ABSPATH')) { exit; }

/** @var string[] $shortcodes */
/** @var array<string,array{row:array,debug:array}> $rowsByBase */
/** @var array<string,array> $debug */
/** @var bool $nocache */
/** @var bool $show_sql */

$totalShortcodes = count($shortcodes);
$errors = array_filter($debug, static fn($d) => !empty($d['error']));
$cleared = isset($_GET['cleared']);
?>
<div class="wrap bank-statistics-wrap">
  <h1>Bank Statistics — Control Room</h1>

  <?php if ($cleared): ?>
  <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Cache cleared.', 'bank-statistics'); ?></p></div>
  <?php endif; ?>

  <div class="bank-statistics-toolbar">
    <form method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>" class="bank-statistics-controls">
      <input type="hidden" name="page" value="bank-statistics" />
      <label class="bs-toggle">
        <input type="checkbox" name="nocache" value="1" <?php checked($nocache); ?> />
        <?php esc_html_e('Bypass cache (recompute now)', 'bank-statistics'); ?>
      </label>
      <label class="bs-toggle">
        <input type="checkbox" name="show_sql" value="1" <?php checked($show_sql); ?> />
        <?php esc_html_e('Show SQL', 'bank-statistics'); ?>
      </label>
      <button class="button button-primary"><?php esc_html_e('Refresh view', 'bank-statistics'); ?></button>
    </form>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <input type="hidden" name="action" value="bank_statistics_clear_cache" />
      <?php wp_nonce_field('bank_statistics_clear_cache'); ?>
      <button class="button"><?php esc_html_e('Clear cached results', 'bank-statistics'); ?></button>
    </form>

    <input id="bs-search" class="regular-text" type="search" placeholder="<?php esc_attr_e('Search shortcodes…', 'bank-statistics'); ?>" />
  </div>

  <div class="bank-statistics-summary">
    <span class="bs-chip">
      <?php echo esc_html(sprintf(_n('%d shortcode', '%d shortcodes', $totalShortcodes, 'bank-statistics'), $totalShortcodes)); ?>
    </span>
    <span class="bs-chip <?php echo $nocache ? 'fresh' : 'cached'; ?>">
      <?php echo $nocache ? esc_html__('Mode: fresh (no cache)', 'bank-statistics') : esc_html__('Mode: cached', 'bank-statistics'); ?>
    </span>
    <span class="bs-chip <?php echo empty($errors) ? 'ok' : 'warn'; ?>">
      <?php echo empty($errors) ? esc_html__('No SQL errors', 'bank-statistics') : esc_html(sprintf(_n('%d error', '%d errors', count($errors), 'bank-statistics'), count($errors))); ?>
    </span>
  </div>

  <?php if (!empty($errors)): ?>
    <div class="bank-statistics-card bs-errors">
      <h2><?php esc_html_e('Errors', 'bank-statistics'); ?></h2>
      <ul>
        <?php foreach ($errors as $b => $d): ?>
          <li>
            <strong><?php echo esc_html($b); ?></strong>:
            <code><?php echo esc_html((string) $d['error']); ?></code>
            <?php if (!empty($d['last_query'])): ?>
              <details><summary><?php esc_html_e('Last query', 'bank-statistics'); ?></summary>
                <code class="bs-code"><?php echo esc_html((string) $d['last_query']); ?></code>
              </details>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="bank-statistics-card">
    <h2><?php esc_html_e('Registered shortcodes (with live values)', 'bank-statistics'); ?></h2>

    <table class="widefat fixed striped bs-table" id="bs-table">
      <thead>
        <tr>
          <th><?php esc_html_e('Base', 'bank-statistics'); ?></th>
          <th><?php esc_html_e('Shortcode', 'bank-statistics'); ?></th>
          <th class="col-value"><?php esc_html_e('Value', 'bank-statistics'); ?></th>
          <th class="col-cache"><?php esc_html_e('Cache', 'bank-statistics'); ?></th>
          <th class="col-time"><?php esc_html_e('Time (ms)', 'bank-statistics'); ?></th>
          <th class="col-error"><?php esc_html_e('Error', 'bank-statistics'); ?></th>
        </tr>
      </thead>
      <tbody>
      <?php
      foreach ($rowsByBase as $base => $pack):
          $row   = $pack['row'];
          $d     = $pack['debug'];
          $tags  = array_filter($shortcodes, static fn($sc) => str_starts_with($sc, $base . '_'));
          sort($tags);
          foreach ($tags as $tag):
              $isAmount  = str_ends_with($tag, '_amount_total');
              $val       = isset($row[$tag]) ? (float) $row[$tag] : 0.0;
              $valueStr  = $isAmount ? number_format($val, 2, '.', ' ') : number_format($val, 0, '.', ' ');
              $hasError  = !empty($d['error']);
      ?>
        <tr data-search="<?php echo esc_attr($base . ' ' . $tag); ?>">
          <td class="col-base">
            <code><?php echo esc_html($base); ?></code>
            <?php if ($show_sql && !empty($d['sql_used'])): ?>
              <details class="bs-sql"><summary><?php esc_html_e('SQL', 'bank-statistics'); ?></summary>
                <code class="bs-code"><?php echo esc_html((string) $d['sql_used']); ?></code>
              </details>
            <?php endif; ?>
          </td>
          <td class="col-tag"><code>[<?php echo esc_html($tag); ?>]</code></td>
          <td class="col-value"><strong><?php echo esc_html($valueStr); ?></strong></td>
          <td class="col-cache">
            <?php if ($d['cached']): ?>
              <span class="bs-badge cached"><?php esc_html_e('cached', 'bank-statistics'); ?></span>
            <?php else: ?>
              <span class="bs-badge fresh"><?php esc_html_e('fresh', 'bank-statistics'); ?></span>
            <?php endif; ?>
          </td>
          <td class="col-time"><?php echo esc_html(number_format((float) $d['time_ms'], 2, '.', '')); ?></td>
          <td class="col-error">
            <?php if ($hasError): ?>
              <span class="bs-badge error" title="<?php echo esc_attr((string) $d['error']); ?>"><?php esc_html_e('error', 'bank-statistics'); ?></span>
            <?php else: ?>
              <span class="bs-badge ok"><?php esc_html_e('ok', 'bank-statistics'); ?></span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="bank-statistics-card">
    <h2><?php esc_html_e('System & Debug', 'bank-statistics'); ?></h2>
    <table class="widefat striped">
      <tbody>
        <tr><th><?php esc_html_e('Plugin version', 'bank-statistics'); ?></th><td><?php echo esc_html(BANK_STATISTICS_VERSION); ?></td></tr>
        <tr><th><?php esc_html_e('PHP version', 'bank-statistics'); ?></th><td><?php echo esc_html(PHP_VERSION); ?></td></tr>
        <tr><th><?php esc_html_e('WordPress version', 'bank-statistics'); ?></th><td><?php echo esc_html(get_bloginfo('version')); ?></td></tr>
        <tr><th><?php esc_html_e('DB prefix', 'bank-statistics'); ?></th><td><code><?php global $wpdb; echo esc_html($wpdb->prefix); ?></code></td></tr>
        <tr><th><?php esc_html_e('Cache TTL (seconds)', 'bank-statistics'); ?></th><td><?php echo esc_html((string) apply_filters('bank_statistics_cache_ttl', 300)); ?></td></tr>
      </tbody>
    </table>
  </div>
</div>
