<?php
/**
 * Plugin Name: WP Password Generator
 * Plugin URI: http://stevegrunwell.com/wp-password-generator
 * Description: Generates a random password when creating a new WP user
 * Version: 2.7.1
 * Author: Steve Grunwell
 * Author URI: http://stevegrunwell.com
 * License: GPL2
 *
 * @author Steve Grunwell
 */

define( 'WP_PASSWORD_GENERATOR_VERSION', '2.7.1' );

/**
 * Load the textdomain for translating the plugin.
 *
 * @since 2.6
 */
function wp_password_generator_init() {
	load_plugin_textdomain(
		'wp-password-generator',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
	);
}

add_action( 'plugins_loaded', 'wp_password_generator_init' );


/**
 * Store plugin settings the wp_options table (key = 'wp-password-generator-opts')
 *
 * Previous versions (1.x) of the readme.txt file encouraged users to edit the
 * wp_password_generator_generate() function in order to change characters or min/max lengths.
 * Moving forward, the options will be stored in wp_options to prevent changes to these values from
 * being overwritten.
 *
 * @since 2.1
 */
function wp_password_generator_install() {
	$defaults = array(
		'version'     => WP_PASSWORD_GENERATOR_VERSION,
		'min-length'  => 7,
		'max-length'  => 16
	);

	$opts = get_option( 'wp-password-generator-opts' );
	if ( $opts ) {

		// Remove 'characters', which was only used in version 2.1. We'll use whatever is defined in wp_generate_password()
		if ( isset( $opts['characters'] ) ) {
			unset( $opts['characters'] );
		}

		if ( isset( $opts['min-length'] ) && intval( $opts['min-length'] ) > 0 ) {
			$defaults['min-length'] = intval( $opts['min-length'] );
		}

		if ( isset( $opts['max-length'] ) && intval( $opts['max-length'] ) >= $defaults['min-length'] ) {
			$defaults['max-length'] = intval( $opts['max-length'] );
		}

		/*
		 * We've checked what we need to. If there are other items in $stored, let them stay ($defaults
		 * won't overwrite them) as some dev has probably spent some time adding custom functionality
		 * to the plugin.
		 */
		$defaults = array_merge( $opts, $defaults );
	}

	update_option( 'wp-password-generator-opts', $defaults );
	return;
}

register_activation_hook( __FILE__, 'wp_password_generator_install' );

/**
 * Instantiate the plugin/enqueue wp-password-generator.js.
 *
 * @since 1.0
 */
function wp_password_generator_load() {
	$current_screen = get_current_screen();
	if ( in_array( $current_screen->base, array( 'profile', 'user', 'user-edit' ) ) ) {
		wp_enqueue_script(
			'wp-password-generator',
			plugins_url( 'wp-password-generator.js', __FILE__ ),
			array( 'jquery' ),
			WP_PASSWORD_GENERATOR_VERSION,
			true
		);
		$i18n = array(
			'generate' => __( 'Generate Password', 'wp-password-generator' ),
			'show'     => __( 'Show Password', 'wp-password-generator' )
		);
		wp_localize_script( 'wp-password-generator', 'wpPasswordGenerator', $i18n );
	}
	return;
}

add_action( 'admin_print_scripts', 'wp_password_generator_load' );

/**
 * Handle an Ajax request for a password, print response.
 *
 * Uses wp_generate_password(), a pluggable function within the WordPress core.
 *
 * @since 1.0
 */
function wp_password_generator_generate() {
	$opts = get_option( 'wp-password-generator-opts', false );
	if ( ! $opts || $opts['version'] < WP_PASSWORD_GENERATOR_VERSION ) { // No options or an older version
		wp_password_generator_install();
		$opts = get_option( 'wp-password-generator-opts', false );
	}
	$len = mt_rand( $opts['min-length'], $opts['max-length'] ); // Min/max password lengths

	// Allow to modify the args supplied to wp_generate_password
	$args = array(
		'length'              => $len,
		'special_chars'       => true,
		'extra_special_chars' => false,
	);

	/**
	 * Filter arguments being passed to wp_generate_password().
	 *
	 * @param array $args The $length, $special_chars, and $extra_special_chars arguments for
	 *                    the wp_generate_password() function.
	 * @param array $opts Plugin options stored in the options table.
	 */
	echo call_user_func_array( 'wp_generate_password', apply_filters( 'wp_password_generator_args', $args, $opts ) );
	exit;
}

add_action( 'wp_ajax_generate_password', 'wp_password_generator_generate' ); // Ajax hook