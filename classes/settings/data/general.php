<?php

namespace Enogwe\Settings\Data;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GeneralData {
    private static $instance;
    public $data = array();

    /** @return GeneralData */
	public static function instance() {
		if ( GeneralData::$instance === null ) {
			GeneralData::$instance = new GeneralData;
		}
		return GeneralData::$instance;
    }

    public function __construct() {
        $this->run();
    }

    public function run () {
        $this->data = apply_filters(
            'ocean_wp_settings_general_data',
            array(
                'ocean_customzer_styling' => $this->setting('ocean_customzer_styling', 'head', 'oceanwp_sanitize_select'),
                'ocean_primary_color' => $this->setting('ocean_primary_color', '#13aff0', 'oceanwp_sanitize_color'),
                'ocean_background_image' => $this->setting('ocean_background_image', null, 'oceanwp_sanitize_image'),
                'ocean_background_image_position' => $this->setting('ocean_background_image_position', 'initial', 'sanitize_text_field'),
                'ocean_hover_primary_color' => $this->setting('ocean_hover_primary_color', '#0b7cac', 'oceanwp_sanitize_color'),
                'ocean_theme_button_color' => $this->setting('ocean_theme_button_color', '#ffffff', 'oceanwp_sanitize_color'),
                'ocean_theme_button_hover_color' => $this->setting('ocean_theme_button_hover_color', '#ffffff', 'oceanwp_sanitize_color'),
                'ocean_error_page_blank' => $this->setting('ocean_error_page_blank', 'off', 'oceanwp_sanitize_select'),
                'ocean_error_page_layout' => $this->setting('ocean_error_page_layout', 'full-width', 'oceanwp_sanitize_select'),
                'ocean_error_page_template' => $this->setting('ocean_error_page_template', '0', 'oceanwp_sanitize_select'),
            )
        );
    }

    public function setting (string $name, $default, $callback) {
        return array (
            'name'    => $name,
            'settings' => array (
                'transport'           	=> 'postMessage',
                'default'           	=> $default,
                'sanitize_callback' 	=> $callback
            )
        );
    }
}
