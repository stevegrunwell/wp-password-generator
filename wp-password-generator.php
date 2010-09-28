<?php
/*
	Plugin Name: WP-Password Generator
	Plugin URI: http://stevegrunwell.com/wp-password-generator.php
	Description: Generates a random password when creating a new WP user
	Version: 1.1
	Author: Steve Grunwell
	Author URI: http://stevegrunwell.com
	License: GPL2
*/

  function wp_password_generator_load(){
    wp_enqueue_script( 'wp-password-generator', '/wp-content/plugins/wp-password-generator/wp-password-generator.js', array('jquery'), '1.0', true );
  }
	  
  # Handle an Ajax request for a password
  function wp_password_generator_generate(){
	$password = '';
    $len = mt_rand(7, 16);
	$allowed = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()';
	$i = 0;
	
	while($i <= $len){
	  $char = substr( $allowed, mt_rand(0, strlen($allowed)-1 ), 1 );
	  if( strstr($password, $char) ){ continue; } else { $password .= $char; }
	  $i++;
	}
	
	echo $password;
  }
  
  # Return a password via Ajax
  if( isset($_POST['password-generator-generate']) ){
    wp_password_generator_generate();
  } else {
	add_action('admin_print_scripts', 'wp_password_generator_load'); 
  }
?>