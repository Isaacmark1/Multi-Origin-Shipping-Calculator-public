<?php

if (!defined('ABSPATH')) exit;

class PAF_DB {

    public static function install() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'paf_rates';
        $charset_collate = $wpdb->get_charset_collate();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            origin_zone VARCHAR(50) NOT NULL,
            destination_zone VARCHAR(50) NOT NULL,
            weight_tier VARCHAR(20) NOT NULL,
            rate DECIMAL(10,2) NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY origin_zone (origin_zone),
            KEY destination_zone (destination_zone),
            KEY weight_tier (weight_tier)
        ) $charset_collate;";

        dbDelta($sql);

        update_option('paf_db_version', '1.0');
    }
}
