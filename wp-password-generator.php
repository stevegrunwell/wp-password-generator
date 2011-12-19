<?php
/*
	Plugin Name: WP-Password Generator
	Plugin URI: http://stevegrunwell.com/wp-password-generator
	Description: Generates a random password when creating a new WP user
	Version: 2.3
	Author: Steve Grunwell
	Author URI: http://stevegrunwell.com
	License: GPL2
*/

define('WP_PASSWORD_GENERATOR_VERSION', '2.3');

/**
 * Store the settings in a JSON-encoded array in the wp_options table
 *
 * Previous version of the readme.txt file encouraged users to edit wp_password_generator_generate()
 * in order to change characters or min/max lengths. Moving forward, the options will be stored in
 * wp_options to prevent changes to these values from being overwritten
 *
 * @return bool
 * @package WordPress
 * @subpackage WP Password Generator
 * @since 2.1
 */
function wp_password_generator_install(){
  $defaults = array(
    'version' => WP_PASSWORD_GENERATOR_VERSION,
    'min-length' => 7,
    'max-length' => 16
  );

  $opts = get_option('wp-password-generator-opts');
  if( $opts){
    // Remove 'characters', which was only used in version 2.1. We'll use whatever is defined in wp_generate_password()
    if( isset($opts['characters']) ){
      unset($opts['characters']);
    }
    if( isset($opts['min-length']) && intval($opts['min-length']) > 0 ){
      $defaults['min-length'] = intval($opts['min-length']);
    }
    if( isset($opts['max-length']) && intval($opts['max-length']) >= $defaults['min-length'] ){
      $defaults['min-length'] = intval($opts['max-length']);
    }
    /*
      We've checked what we need to. If there are other items in $stored, let them stay ($defaults won't overwrite them)
      as some dev has probably spent some time adding custom functionality to the plugin.
    */
    $defaults = array_merge($opts, $defaults);
  }
  update_option('wp-password-generator-opts', $defaults);
  return true;
}

/**
 * Instantiate the plugin/enqueue wp-password-generator.js
 *
 * @return bool
 * @package WordPress
 * @subpackage WP Password Generator
 * @since 1.0
 */
function wp_password_generator_load(){
	if( basename($_SERVER['PHP_SELF']) == 'user-new.php' ){
		wp_enqueue_script('wp-password-generator', trailingslashit(plugins_url(basename(dirname(__FILE__)))) . 'wp-password-generator.js', array('jquery'), WP_PASSWORD_GENERATOR_VERSION, true);
	}
	return true;
}

/**
 * Handle an Ajax request for a password, print response.
 *
 * Uses wp_generate_password(), a pluggable function within the WordPress core
 *
 * @return bool (echoes password)
 * @package WordPress
 * @subpackage WP Password Generator
 * @since 1.0
 */
function wp_password_generator_generate(){
	$opts = get_option('wp-password-generator-opts', false);
	if( !$opts || $opts['version'] < WP_PASSWORD_GENERATOR_VERSION ){ // No options or an older version
	  wp_password_generator_install();
	  $opts = get_option('wp-password-generator-opts', false);
	}
	$len = mt_rand($opts['min-length'], $opts['max-length']); // Min/max password lengths

	echo wp_generate_password($len, true, false);
	return true;
}

add_action('admin_print_scripts', 'wp_password_generator_load'); // run wp_password_generator_load() during admin_print_scripts
add_action('wp_ajax_generate_password', 'wp_password_generator_generate'); // Ajax hook
register_activation_hook(__FILE__, 'wp_password_generator_install');

?>