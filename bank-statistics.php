<?php
/**
 * Plugin Name: Bank Statistics
 * Description: KPI shortcodes moved from theme to plugin. Preserves original shortcode names and SQL logic.
 * Version:     1.2.1
 * Author:      1 Click Studio Ltd.
 * Requires PHP: 8.0
 * Text Domain: bank-statistics
 */

if (!defined('ABSPATH')) { exit; }

define('BANK_STATISTICS_VERSION', '1.2.1');
define('BANK_STATISTICS_PATH', plugin_dir_path(__FILE__));
define('BANK_STATISTICS_URL', plugin_dir_url(__FILE__));

require_once BANK_STATISTICS_PATH . 'includes/class-plugin.php';

add_action('plugins_loaded', function () {
    \Bank_Statistics\Plugin::instance();
});
