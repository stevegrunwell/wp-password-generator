<?php
/*
	Plugin Name: WP-Password Generator
	Plugin URI: http://stevegrunwell.com/wp-password-generator
	Description: Generates a random password when creating a new WP user
	Version: 2.0
	Author: Steve Grunwell
	Author URI: http://stevegrunwell.com
	License: GPL2
*/

	function wp_password_generator_load(){
		if( basename($_SERVER['PHP_SELF']) == 'user-new.php' ){
			wp_enqueue_script('wp-password-generator', '/wp-content/plugins/wp-password-generator/wp-password-generator.js', array('jquery'), '2.0', true);
		}
		return;
	}

	/* Handle an Ajax request for a password */
	function wp_password_generator_generate(){
		$password = '';
		$len = mt_rand(7, 16);
		$allowed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()';
		$i = 0;
	
		while( $i <= $len ){
			$char = substr( $allowed, mt_rand(0, strlen($allowed)-1 ), 1 );
			if( !strstr($password, $char) ){ 
				$password .= $char;
				$i++;
			}
		}

		echo $password;
		return true;
	}
	
	add_action('admin_print_scripts', 'wp_password_generator_load'); 
	add_action('wp_ajax_generate_password', 'wp_password_generator_generate');

?>