=== Plugin Name ===
Contributors: SteveGrunwell
Donate link: http://stevegrunwell.com/
Tags: password, password generator, users
Requires at least: 3.0.1
Tested up to: 3.0.1
Stable tag: 1.0

Generates a random password (via Ajax) for new users created through wp-admin/user-new.php.


== Description ==

When administrators create new users through the WordPress admin interface (wp-admin/user-new.php), they are forced to come up with a password for the new user. The administrator is faced with a choice: use a separate password generator app or waste precious time coming up with a clever password only one person will ever see.

WP-Password Generator takes the hassle out of creating new or insecure passwords. Simply click "Generate Password" and your user has a unique, eight character password.

Please note that this plugin does require javascript to be enabled in order to work. Without javascript, the generator will simply be unavailable.


== Installation ==

1. Upload the '/wp-password-generator/' plugin directory to '/wp-content/plugins'
2. Activate the plugin
3. That's it!


== Frequently Asked Questions ==

= How does the plugin generate passwords? =

WP-Password Generator non-obtrusively injects a "Generate Password" button into '/wp-admin/user-new.php'. When the button is clicked, an Ajax call is fired off to '/wp-content/plugins/wp-password-generator/wp-password-generator.php', which returns a randomly-generated password.

By default, the script creates eight-character passwords using alpha-numeric (both upper and lowercase letters) and select (!@#$%^&*()) characters, with no individual character appearing more than once in the password.

= Is there anything to configure? =

No. Version 1.0 of this plug-in does not include a configuration menu. If you'd like to modify the parameters of the password generator, you'll need to edit the wp_password_generator_generate() function in wp-password-generator.php.

The only parameters to change are $len (length of the password) and $allowed (all allowed characters).


== Changelog ==

= 1.0 =
* First public version of the plugin