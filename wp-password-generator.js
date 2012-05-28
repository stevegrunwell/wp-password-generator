/*
  Plugin Name: WP-Password Generator
  Plugin URI: http://stevegrunwell.com/wp-password-generator
  Version: 2.4
*/
/*jslint white: true, maxerr: 50, indent: 4 */

jQuery(function($){
  "use strict";
  $('#pass-strength-result').before('<br /><button id="password_generator" class="button-primary" value="' + i18n.generate + '" role="button">' + i18n.generate + '</button><br />');

  $('#password_generator').on('click', function(){
    $.post(ajaxurl, { action : 'generate_password' }, function(p){
      $('#pass1, #pass2').val(p).trigger('keyup');
      $('#password_generator_toggle').find('kbd').html(p);

      /** Append the 'Show password' link and bind the click event */
      if( $('#password_generator_toggle').length === 0 ){
        $('#send_password').prop('checked', 'checked'); // Only do this the first time
        $('#password_generator').after('<span id="password_generator_toggle" style="margin-left:.25em;"><a href="#" role="button">' + i18n.show + '</a></span>');
        $('#password_generator_toggle').on('click', 'a', function(){
          $(this).fadeOut(200, function(){
            $('#password_generator_toggle').html('<kbd style="font-size:1.2em;">' + $('#pass1').val() + '</kbd>');
          });
          return false;
        });
      }
    });
    return false;
  });
});