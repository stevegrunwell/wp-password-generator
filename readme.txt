=== Plugin Name ===
Contributors: SteveGrunwell
Donate link: http://stevegrunwell.com/wp-password-generator.php
Tags: password, password generator, users
Requires at least: 3.0.1
Tested up to: 3.1.1
Stable tag: 2.0

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

WP-Password Generator non-obtrusively injects a "Generate Password" button into '/wp-admin/user-new.php'. When the button is clicked, an Ajax call is fired off to '/wp-content/plugins/wp-password-generator/wp-password-generator.php', which returns a randomly-generated password.

By default, the script creates 7-16 character passwords using alpha-numeric (both upper and lowercase letters) and select (!@#$%^&*()) characters, with no individual character appearing more than once in the password.

= Is there anything to configure? =

No. Version 1.1 of this plug-in does not include a configuration menu. If you'd like to modify the parameters of the password generator, you'll need to edit the wp_password_generator_generate() function in wp-password-generator.php.

The only parameters to change are $len (length of the password) and $allowed (all allowed characters).


== Screenshots ==

1. The "Generate Password" button just above the strength indicator in /wp-admin/user-new.php


== Changelog ==

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

= 2.0 =
The password strength indicator is now updated when a password is generated. Better support for non-standard WordPress instances. Removed generator from user-edit screen.

= 1.1 =
Generated passwords now vary between 7 and 16 characters in length, rather than the eight-character limit of version 1.0


== Special Thanks ==

Special thanks goes out to Greg Laycock (http://76horsepower.com/) for his input during the ongoing development of this plug-in. Additional thanks to WordPress user pampfelimetten for suggesting the plugin hook into the strength indicator.