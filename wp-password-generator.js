/*
  Plugin Name: WP-Password Generator
  Plugin URI: http://stevegrunwell.com/wp-password-generator
  Version: 2.3
*/
/*jslint white: true, maxerr: 50, indent: 4 */

jQuery(function(){
	'use strict';
   jQuery('#pass-strength-result').before('<br /><button id="password_generator" class="button-primary">Generate Password</button><br />');

   jQuery('#password_generator').bind('click', function(){
     jQuery.post(ajaxurl, { action : 'generate_password' }, function(p){
       jQuery('#pass1, #pass2').val(p).trigger('keyup');
       jQuery('#password_generator_toggle').find('kbd').html(p);

       /** Append the 'Show password' link and bind the click event */
       if( jQuery('#password_generator_toggle').length === 0 ){
         jQuery('#send_password').prop('checked', 'checked'); // Only do this the first time
         jQuery('#password_generator').after('<span id="password_generator_toggle" style="margin-left:.25em;"><a href="#">Show password</a></span>');
         jQuery('#password_generator_toggle').delegate('a', 'click', function(){
           jQuery(this).fadeOut(200, function(){
             jQuery('#password_generator_toggle').html('<kbd style="font-size:1.2em;">' + jQuery('#pass1').val() + '</kbd>');
           });
           return false;
         });
       }
     });
     return false;
   });
});