=== Plugin Name ===
Contributors: SteveGrunwell
Donate link: http://stevegrunwell.com/wp-password-generator
Tags: password, password generator, users, wp_generate_password, pluggable
Requires at least: 3.2
Tested up to: 3.3
Stable tag: 2.3

Generates a random password (via Ajax) for new users created through wp-admin/user-new.php.


== Description ==

When administrators create new users through the WordPress admin interface (wp-admin/user-new.php), they are forced to come up with a password for the new user. The administrator is faced with a choice: use a separate password generator app or waste precious time coming up with a clever password only one person will ever see.

WP-Password Generator takes the hassle out of creating new or insecure passwords. Simply click "Generate Password" and your user has a unique, 7-16 character password.

Please note that this plugin does require javascript to be enabled in order to work. Without javascript, the generator will simply be unavailable.


== Installation ==

1. Upload the '/wp-password-generator/' plugin directory to '/wp-content/plugins'
2. Activate the plugin
3. That's it!


== Frequently Asked Questions ==

= How does the plugin generate passwords? =

WP-Password Generator un-obtrusively injects a "Generate Password" button into '/wp-admin/user-new.php'. When the button is clicked, an Ajax call is fired off to '/wp-content/plugins/wp-password-generator/wp-password-generator.php', which returns a randomly-generated password.

As of version 2.2, WP Password Generator calls the pluggable wp_generate_password() function (which is the same function WordPress uses to create new passwords for users who have clicked "Forgot password?"). This function can be overridden in a theme or plugin, if desired.

= Is there anything to configure? =

Not directly, but as of version 2.2 the plugin uses the pluggable wp_generate_password() function. If a developer chooses to override the function, the passwords created by the plugin will use the same methods and rules applied to passwords created through the "Forgot password?" tool. Minimum and maximum password lengths can also be set in the wp_options table (one row with the key of "wp-password-generator-opts"), though there is no dedicated settings page for these values (by default, passwords are between 7-16 characters).


== Screenshots ==

1. The "Generate Password" button just above the strength indicator in /wp-admin/user-new.php with the new 'Show password' link beside it
2. A generated password revealed by the user clicking 'Show password'. This password will update with subsequent generations.


== Changelog ==

= 2.3 =
* Now works in WordPress installations that don't use the standard `wp-content/` directory location
* Improved javascript performance

= 2.2 =
* Use the pluggable wp_generate_password() function to handle password creation rather than WP Password Generator's internal function
* Removed 'characters' key from the plugin settings

= 2.1 =
* Ability to show generated password beside the generate button
* 'Send this password?' checkbox only auto-checked the first time a password is generated. Subsequent generations will not re-check this box.
* Store permitted characters and min/max password lengths in the `wp_options` table to prevent them from being overridden in future updates
* jQuery functions are wrapped to allow the $ shortcut while in no-conflict mode
* Better adherence to WordPress code standards

= 2.0 =
* Clicking 'Generate Password' will also update the password strength indicator and automatically check the 'Send Password?' checkbox
* Removed generator button from the user-edit screen as these passwords aren't sent to the user
* Ajax call now uses admin-ajax for better support for non-standard WordPress installations
* Better adherence to the WordPress coding standards
* Updated the special thanks section of readme.txt
* Counter in wp_password_generator_generate() will only increment if a character has been added to the password string
* wp-password-generator.js now passes JSLint

= 1.1 =
* Passwords now vary between 7 and 16 characters

= 1.0 =
* First public version of the plugin


== Upgrade Notice ==

= 2.3 =
Plugin will now work in WordPress installations where `wp-content/` has a different name or location. Scripting has been updated to work with newer versions of jQuery - version 2.3 is not suitable for WordPress versions below 3.2

= 2.2 =
Password generation is now handled by the wp_generate_password() pluggable function so that both generated and "Lost password" requests are handled by the same function.

= 2.1 =
Ability to view generated passwords before submitting form. Only auto-check the 'Send password' option upon first generation.

= 2.0 =
The password strength indicator is now updated when a password is generated. Better support for non-standard WordPress instances. Removed generator from user-edit screen.

= 1.1 =
Generated passwords now vary between 7 and 16 characters in length, rather than the eight-character limit of version 1.0


== Special Thanks ==

Special thanks goes out to Greg Laycock (http://76horsepower.com/) for his input during the ongoing development of this plug-in. Additional thanks to WordPress users pampfelimetten for suggesting the plugin hook into the strength indicator and michapixel for recommending the 'Show password' feature. Chris Van Patten (http://vanpattenmedia.com/) also deserves major props for assistance with version 2.3.