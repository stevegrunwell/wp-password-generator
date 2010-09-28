/*
	Plugin Name: WP-Password Generator
	Plugin URI: http://stevegrunwell.com/wp-password-generator.php
	Version: 1.1
*/

(function($){
  $(document).ready(function(){
    $('#pass-strength-result').before('<br /><button id="password_generator" class="button-primary">Generate Password</button><br />');
  
    $('#password_generator').bind('click', function(){
      $.ajax({
        type: 'post',
        url: '../wp-content/plugins/wp-password-generator/wp-password-generator.php',
        data: 'password-generator-generate=true',
        success: function(p){
          $('#pass1, #pass2').val(p);
        }
      });
      return false;
    });
	
  });
})(jQuery);