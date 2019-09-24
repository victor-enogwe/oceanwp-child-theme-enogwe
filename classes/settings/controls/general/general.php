<?php

namespace Enogwe\Settings;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once trailingslashit( get_stylesheet_directory() ) . 'classes/settings/data/general.php';

class OceanWP_General_Customizer {
	private $panel = 'ocean_general_panel';
	private $data;
	private static $instance;

	/** @return OceanWP_General_Customizer */
	public static function instance( \Enogwe\Settings\Data\GeneralData $data ) {
		if ( self::$instance === null ) {
			self::$instance = new OceanWP_General_Customizer( $data );
		}
		return self::$instance;
	}

	public function __construct( \Enogwe\Settings\Data\GeneralData $data ) {
		$this->data = $data->data;
		$this->run();
	}

	public function run() {
		$this->actions();
	}

	public function actions() {
        add_action( 'customize_register', array( $this, 'customizer_options' ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ) );
		// add_filter('ocean_head_css', array( $this, 'head_css'));
    }

    public function customizer_scripts() {
        $dir = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/';
        wp_register_script(
            'oceanwp-general-controls',
            $dir . 'controls/general.js',
            array('jquery', 'wp-i18n', 'customize-controls'),
            null,
            true
        );

        wp_enqueue_script( 'oceanwp-general-controls' );
    }

	public function customizer_options( \WP_Customize_Manager $wp_customize ) {
        $this->add_settings( $wp_customize );
        $this->modifyControls( $wp_customize );
	}

	public function add_settings( \WP_Customize_Manager $wp_customize ) {
        foreach ( $this->data as $setting ) {
            $wp_customize->add_setting( $setting['name'], $setting['settings'] );
        }
    }

    public function modifyControls( \WP_Customize_Manager $wp_customize ) {
        $wp_customize->get_control( 'header_image' )->active_callback = 'oceanwp_cac_has_background_image';
    }
}

return OceanWP_General_Customizer::instance( \Enogwe\Settings\Data\GeneralData::instance() );
