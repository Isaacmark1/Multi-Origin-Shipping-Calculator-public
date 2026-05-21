<?php
/*
Plugin Name: Multi-Origin Shipping Calculator
Plugin URI: -
Description: A WooCommerce shipping calculator for stores that ship from multiple origins, vendors, warehouses, suppliers, or countries. Calculates shipping using product origin zones, destination zones, chargeable weight, volumetric weight, tiered per-kg rates, handling fees, surcharges, and profit margin.
Version: 2.0.0
Author: OddEvenMan O
Author URI: https://www.linkedin.com/in/isaacmark-ogbuefi-64a20a2b4/
Text Domain: multi-origin-shipping-calculator
Domain Path: /languages
Requires at least: 6.0
Requires PHP: 7.4
WC requires at least: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin path
 */
define('PAF_PATH', plugin_dir_path(__FILE__));

require_once PAF_PATH . 'includes/class-db.php';

/**
 * Initialize Plugin
 */
function paf_init_plugin() {

    /**
     * Ensure WooCommerce is active
     */
    if (!class_exists('WooCommerce')) {
        return;
    }

    /**
     * Core Includes
     */
    
    require_once PAF_PATH . 'includes/class-checkout.php';
    require_once PAF_PATH . 'includes/class-rate-engine.php';
    require_once PAF_PATH . 'includes/class-admin.php';

    new PAF_Checkout();


    /**
     * Shipping Method Init
     */
    add_action('woocommerce_shipping_init', 'paf_shipping_method_init');

    function paf_shipping_method_init() {

        require_once PAF_PATH . 'includes/class-shipping-method.php';
    }

    /**
     * Register Shipping Method
     */
    add_filter(
        'woocommerce_shipping_methods',
        'paf_register_shipping_method'
    );

    function paf_register_shipping_method($methods) {

        $methods['pro_air_freight'] = 'PAF_Shipping_Method';

        return $methods;
    }

    /**
     * Admin UI
     */
    if (is_admin()) {

        new PAF_Admin();
    }
}

/**
 * Load Plugin After Plugins Loaded
 */
add_action('plugins_loaded', 'paf_init_plugin');

/**
 * Plugin Activation
 */
register_activation_hook(
    __FILE__,
    ['PAF_DB', 'install']
);
