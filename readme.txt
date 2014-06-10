=== WP Password Generator ===
Contributors: stevegrunwell, VanPattenMedia
Donate link: http://stevegrunwell.com/wp-password-generator
Tags: password, password generator, users, wp_generate_password, pluggable
Requires at least: 3.2
Tested up to: 3.9.1
Stable tag: 2.6
License: GPLv2 or later

WP Password Generator takes the hassle out of creating new WordPress users by generating random, secure passwords with one click.


== Description ==

When administrators create new users through the WordPress admin interface (wp-admin/user-new.php), they are forced to come up with a password for the new user. The administrator is faced with a choice: use a separate password generator app or waste precious time coming up with a clever password only one person will ever see.

WP Password Generator takes the hassle out of creating new user passwords. Simply click "Generate Password" and your user has a unique, 7-16 character password. The password generator function is also totally pluggable, so you can easily change the way passwords are generated in order to meet your standards.

Please note that this plugin does require javascript to be enabled in order to work. Without javascript, the generator will simply be unavailable.


== Installation ==

1. Upload the '/wp-password-generator/' plugin directory to '/wp-content/plugins'
2. Activate the plugin
3. That's it!


== Screenshots ==

1. The "Generate Password" button just above the strength indicator in /wp-admin/user-new.php with the new 'Show password' link beside it
2. A generated password revealed by the user clicking 'Show password'. This password will update with subsequent generations.


== Frequently Asked Questions ==

= How does the plugin generate passwords? =

WP Password Generator un-obtrusively injects a "Generate Password" button into /wp-admin/user-new.php. When the button is clicked, an Ajax call is fired off to /wp-content/plugins/wp-password-generator/wp-password-generator.php, which returns a randomly-generated password.

As of version 2.2, WP Password Generator calls the pluggable `wp_generate_password()` function (which is the same function WordPress uses to create new passwords for users who have clicked "Forgot password?"). This function can be overridden in a theme or plugin, if desired (see "Can I change the way my passwords are generated?" below).

= Is there anything to configure? =

Not directly, but as of version 2.2 the plugin uses the pluggable `wp_generate_password()` function. If a developer chooses to override the function, the passwords created by the plugin will use the same methods and rules applied to passwords created through the "Forgot password?" tool. Minimum and maximum password lengths can also be set in the `wp_options` table (one row with the key of `wp-password-generator-opts`), though there is no dedicated settings page for these values (by default, passwords are between 7-16 characters) and they should suffice for 99% of users.

= Can I change the way my passwords are generated? =

Since version 2.2 WP Password Generator has used the pluggable function `wp_generate_password()` to handle the actual generation of passwords. This switch a) kept the codebase more DRY and b) allows users to easily override the generator logic without editing core or plugin files.

The default generator looks something like this and can be found in wp-includes/pluggable.php (line 1478 in core version 3.3.2):

    if ( !function_exists('wp_generate_password') ) :
    /**
     * Generates a random password drawn from the defined set of characters.
     *
     * @since 2.5
     *
     * @param int $length The length of password to generate
     * @param bool $special_chars Whether to include standard special characters. Default true.
     * @param bool $extra_special_chars Whether to include other special characters. Used when
     *   generating secret keys and salts. Default false.
     * @return string The random password
     **/
    function wp_generate_password( $length = 12, $special_chars = true, $extra_special_chars = false ) {
      $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      if ( $special_chars )
        $chars .= '!@#$%^&*()';
      if ( $extra_special_chars )
        $chars .= '-_ []{}<>~`+=,.;:/?|';

      $password = '';
      for ( $i = 0; $i < $length; $i++ ) {
        $password .= substr($chars, wp_rand(0, strlen($chars) - 1), 1);
      }

      // random_password filter was previously in random_password function which was deprecated
      return apply_filters('random_password', $password);
    }
    endif;

To overwrite the default behavior, simply create a function named `wp_generate_password()` in your theme's functions.php file. WordPress will then substitute your theme's `wp_generate_password()` for the default.

You can also adjust the arguments passed to `wp_generate_password()` via the `wp_password_generator_args` filter. For example, you could require 16 character passwords with the following:

    /**
     * Set the length of generated passwords from WP Password Generator to 16 characters
     *
     * @param array $args Default arguments
     * @return array
     */
    function mysite_set_password_requirements( $args ) {
      $args['length'] = 16;
      return $args;
    }
    add_action( 'wp_password_generator_args', 'mysite_set_password_requirements' );

= Can I use WP Password Generator to change existing users' passwords? =

As of version 2.5 the "Generate Password" button has been added to the profile/user edit pages.

= Does the plugin work with WordPress Multisite? =

WordPress Multisite already generates random passwords for new Multisite users so WP Password Generator isn't necessary in Multisite installations.


== Changelog ==

= 2.6 =
* Added a filter `wp_password_generator_args` which allows to modify the args supplied to the built-in `wp_generate_password()` function
* Fixed bug where a "0" was always being appended to the end of generated passwords (thank you to Rig Kruger and [Peter Berce](http://berce.us/) for bringing it to my attention!)
* Added a languages directory and loaded the text-domain so translations are applied automatically
* Added Dutch translation (thanks David Mosterd of (CodPress)[http://www.codepress.nl/] of CodePress)
* Fixed copy-paste error when assigning min/max-length params for passwords (thanks [Robert Paprocki](https://github.com/p0pr0ck5))

= 2.5 =
* Added password generator to user-edit.php and profile.php at the suggestion of [Dave Griffin](https://github.com/davegriffin) ([#1](https://github.com/stevegrunwell/wp-password-generator/issues/1))
* Added Spanish translation (corrections/improvements welcome, I translated myself with Google Translate and my two years of high school Spanish).

= 2.4 =
* Added i18n support and included the POT file in the plugin files
* Replaced instances of `bind()` and `delegate()` with jQuery's `on()` method
* Added instructions for overriding `wp_generate_password()` in the README file
* Promoted Chris Van Patten (VanPattenMedia) from "special thanks" to a plugin contributor
* Plugin repo has been migrated to GitHub: https://github.com/stevegrunwell/wp-password-generator - Trac will only receive named releases (though not much has changed in that respect).

= 2.3 =
* Now works in WordPress installations that don't use the standard `wp-content/` directory location
* Improved javascript performance

= 2.2 =
* Use the pluggable wp_generate_password() function to handle password creation rather than WP Password Generator's internal function
* Removed 'characters' key from the plugin settings

= 2.1 =
* Ability to show generated password beside the generate button
* "Send this password?" checkbox only auto-checked the first time a password is generated. Subsequent generations will not re-check this box.
* Store permitted characters and min/max password lengths in the `wp_options` table to prevent them from being overridden in future updates
* jQuery functions are wrapped to allow the $ shortcut while in no-conflict mode
* Better adherence to WordPress code standards

= 2.0 =
* Clicking 'Generate Password' will also update the password strength indicator and automatically check the 'Send Password?' checkbox
* Removed generator button from the user-edit screen as these passwords aren't sent to the user
* Ajax call now uses admin-ajax for better support for non-standard WordPress installations
* Better adherence to the WordPress coding standards
* Updated the special thanks section of readme.txt
* Counter in `wp_password_generator_generate()` will only increment if a character has been added to the password string
* wp-password-generator.js now passes JSLint

= 1.1 =
* Passwords now vary between 7 and 16 characters

= 1.0 =
* First public version of the plugin


== Upgrade Notice ==

= 2.6 =
Fixed bug where a "0" was always being appended to generated passwords. Password generator arguments can now be controlled via the `wp_password_generator_args` filter. Added Dutch translation.

= 2.5 =
Password generator will now appear on user profile and edit screens. Added Spanish localization.

= 2.4 =
Added i18n support. Refactored jQuery scripting to be more future-proof.

= 2.3 =
Plugin will now work in WordPress installations where wp-content/ has a different name or location. Scripting has been updated to work with newer versions of jQuery - version 2.3 is not suitable for WordPress versions below 3.2

= 2.2 =
Password generation is now handled by the `wp_generate_password()` pluggable function so that both generated and "Lost password" requests are handled by the same function.

= 2.1 =
Ability to view generated passwords before submitting form. Only auto-check the 'Send password' option upon first generation.

= 2.0 =
The password strength indicator is now updated when a password is generated. Better support for non-standard WordPress instances. Removed generator from user-edit screen.

= 1.1 =
Generated passwords now vary between 7 and 16 characters in length, rather than the eight-character limit of version 1.0


== Special Thanks ==

Special thanks goes out to [Greg Laycock](http://76horsepower.com/) for his input during the ongoing development of this plug-in. Additional thanks to WordPress users pampfelimetten for suggesting the plugin hook into the strength indicator and michapixel for recommending the 'Show password' feature. [Dave Griffin](https://github.com/davegriffin) and Marcel Kuiper also convinced me to expand to the user edit screen for version 2.5. David Mosterd of (CodePress)[http://www.codepress.nl/] also contributed to the development of 2.6. Finally, Chris Van Patten of [Van Patten Media](http://vanpattenmedia.com/) has also contributed immensely to the ongoing development and refinement of the plugin.