/*
	Plugin Name: WP-Password Generator
	Plugin URI: http://stevegrunwell.com/wp-password-generator.php
	Version: 2.0
*/

jQuery(document).ready(function(){
	jQuery('#pass-strength-result').before('<br /><button id="password_generator" class="button-primary">Generate Password</button><br />');

	jQuery('#password_generator').bind('click', function(){
		jQuery.post(ajaxurl, { action : 'generate_password' }, function(p){
			jQuery('#pass1, #pass2').val(p).trigger('keyup');
			jQuery('#send_password').attr('checked', 'checked');
		});
		return false;
	});
});