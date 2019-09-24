<?php

namespace Enogwe;

require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer.php';

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Customizer {
	private static $instance;

	/** @return Customizer */
	public static function instance() {
		if ( self::$instance === null ) {
			self::$instance = new Customizer();
		}
		return self::$instance;
	}

	public function __construct() {
		if ( is_customize_preview() ) {
			$this->run();
		}
	}

	public function run() {
		$this->actions();
	}

	public function actions() {
		// add_action('customize_controls_enqueue_scripts', array($this, 'deregister_customizer_scripts'));
		remove_action('after_setup_theme',	array(\OceanWP_Customizer::instance(), 'register_options'));
		add_action('after_setup_theme',	array($this, 'register_options'));
		// add_action('customize_controls_print_scripts', array($this, 'list_scripts_styles'));
	}

	public function deregister_customizer_scripts() {
		$scripts = array(
			'oceanwp-general',
			'oceanwp-color',
			'oceanwp-buttonset',
			'oceanwp-range',
			'oceanwp-radio-image',
			'oceanwp-dimensions',
			'oceanwp-icon-select',
			'oceanwp-multicheck',
			'oceanwp-select2',
			'oceanwp-typography-js',
			'oceanwp-text-js',
			'oceanwp-slider',
			'oceanwp-textarea',
			'oceanwp-sortable',
			'oceanwp-upsell',
			// styles only
			'oceanwp-heading',
			'oceanwp-typography',
		);

		foreach ( $scripts as $handle ) {
			wp_deregister_script( $handle );
			wp_deregister_style( $handle );
		}
	}

	public function list_scripts_styles() {
		global $wp_scripts, $wp_styles;

		echo "registered scripts\n";

		foreach ( $wp_scripts->queue as $handle ) {
			echo $handle . ' | ' . $wp_scripts->registered[ $handle ]->src . "\n";
		}
		echo "registered styles\n";

		foreach ( $wp_styles->queue as $handle ) {
			echo $handle . ' | ' . $wp_styles->registered[ $handle ]->src . "\n";
		}
	}

	public function register_options() {
		// Var
		$dir       = trailingslashit( get_template_directory() ) . 'customizer/settings/';
		$child_dir = trailingslashit( get_stylesheet_directory() ) . 'classes/settings/controls/';

		// Customizer files array
		$files = array(
			'general',
			// 'typography',
			// 'topbar',
			// 'header',
			// 'blog',
			// 'sidebar',
			// 'footer-widgets',
			// 'footer-bottom',
		);

		foreach ( $files as $key ) {
			$setting = str_replace( '-', '_', $key );
			// If Ocean Extra is activated
			if ( OCEAN_EXTRA_ACTIVE
				&& class_exists( 'Ocean_Extra_Theme_Panel' ) ) {

				if ( \Ocean_Extra_Theme_Panel::get_setting( 'oe_' . $setting . '_panel' ) ) {
					require_once $child_dir . $key . '/' . $key . '.php';
				}
			} else {
				require_once $child_dir . $key . '/' . $key . '.php';
			}
		}

		// If WooCommerce is activated
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			require_once $dir . 'woocommerce.php';
		}

		// Easy Digital Downloads Settings
		if ( OCEANWP_EDD_ACTIVE ) {
			require_once $dir . 'edd.php';
		}

		// If LifterLMS is activated
		if ( OCEANWP_LIFTERLMS_ACTIVE ) {
			require_once $dir . 'lifterlms.php';
		}

		// If LearnDash is activated
		if ( OCEANWP_LEARNDASH_ACTIVE ) {
			require_once $dir . 'learndash.php';
		}
	}
}
