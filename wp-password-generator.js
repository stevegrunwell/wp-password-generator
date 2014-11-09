/**
 * Scripting for the "Generate Password" button
 *
 * @package WordPress
 * @subpackage WP Password Generator
 * @author Steve Grunwell
 */
/** jslint white: true, maxerr: 50, indent: 4 */

jQuery(function ($) {
  "use strict";

  $('#pass-strength-result').before('<br /><button id="password_generator" class="button-primary" value="' + wpPasswordGenerator.generate + '" role="button">' + wpPasswordGenerator.generate + '</button><br />');

  $('#password_generator').on('click', function () {
    $.post(ajaxurl, {
      action: 'generate_password'
    }, function(p) {
      $('#pass1, #pass2').val(p).trigger('keyup');
      $('#password_generator_toggle').find('kbd').html(p);

      /** Append the 'Show password' link and bind the click event */
      if ( $('#password_generator_toggle').length === 0) {
        $('#send_password').prop('checked', true); // Only do this the first time
        $('#password_generator').after('<span id="password_generator_toggle" style="margin-left:.75em;"><a href="#" role="button">' + wpPasswordGenerator.show + '</a></span>');
        $('#password_generator_toggle').on('click', 'a', function() {
          $(this).fadeOut(200, function () {
            $('#password_generator_toggle').html('<kbd style="font-size:1.2em;">' + $('#pass1').val() + '</kbd>');
          });
          return false;
        });
      }
    });
    return false;
  });
});
