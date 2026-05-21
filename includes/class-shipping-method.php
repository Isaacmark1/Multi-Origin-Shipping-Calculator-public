<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WC_Shipping_Method')) {
    return;
}

class PAF_Shipping_Method extends WC_Shipping_Method {

    public function __construct($instance_id = 0) {

        $this->id = 'pro_air_freight';

        $this->instance_id = absint($instance_id);

        $this->method_title = 'Multi-Origin Shipping Calculator';

       $this->method_description = 'Calculates shipping based on product origin zones, destination zones, chargeable weight, and tiered rates.';

        $this->supports = [
            'shipping-zones',
            'instance-settings',
            'instance-settings-modal',
        ];

        $this->init();

        $this->enabled = $this->get_option('enabled', 'yes');

        $this->title = $this->get_option(
            'title',
            'Multi-Origin Shipping'
        );
    }

    public function init() {

        $this->init_form_fields();

        $this->init_settings();

        add_action(
            'woocommerce_update_options_shipping_' . $this->id,
            [$this, 'process_admin_options']
        );
    }

    public function init_form_fields() {

        $this->instance_form_fields = [

            'enabled' => [
                'title' => 'Enable',
                'type' => 'checkbox',
                'label' => 'Enable Multi-Origin Shipping',
                'default' => 'yes'
            ],

            'title' => [
                'title' => 'Method Title',
                'type' => 'text',
                'default' => 'Multi-Origin Shipping'
            ]
        ];
    }

    public function calculate_shipping($package = []) {

        if (empty($package['contents'])) {

            $this->add_rate([
                'id' => $this->id . ':' . $this->instance_id,
                'label' => 'PAF CHECK — package contents empty',
                'cost' => 0.01,
                'calc_tax' => 'per_order',
            ]);

            return;
        }

        if (!class_exists('PAF_Rate_Engine')) {

            $this->add_rate([
                'id' => $this->id . ':' . $this->instance_id,
                'label' => 'PAF CHECK — PAF_Rate_Engine class not loaded',
                'cost' => 0.01,
                'calc_tax' => 'per_order',
            ]);

            return;
        }

        $engine = new PAF_Rate_Engine();

        $result = $engine->calculate($package);

        $cost = isset($result['cost'])
            ? (float) $result['cost']
            : 0;

        $message = isset($result['message'])
            ? $result['message']
            : 'No message returned from engine';

        /*
         * Temporary diagnostic mode:
         * Always show shipping so we can see the issue at checkout.
         */
        if ($cost <= 0) {

            $this->add_rate([
                'id' => $this->id . ':' . $this->instance_id,
                'label' => 'PAF CHECK — ' . $message,
                'cost' => 0.01,
                'calc_tax' => 'per_order',
                'package' => $package,
            ]);

            return;
        }

        $this->add_rate([
            'id' => $this->id . ':' . $this->instance_id,
            'label' => $this->title,
            'cost' => $cost,
            'calc_tax' => 'per_order',
            'package' => $package,
        ]);
    }
}
