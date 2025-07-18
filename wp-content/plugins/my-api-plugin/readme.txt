=== My API Plugin ===
Contributors: yourusername
Tags: api, database, custom table, remote post, plugin development
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin that collects user data, stores it in a custom database table, and sends it to a third-party API.

== Description ==

**My API Plugin** allows you to collect user input (Name, Email, Date) from the WordPress admin area. This data is:
- Stored in a custom database table
- Sent to a third-party API (or test API like webhook.site)

This plugin is written using modern, modular OOP code and includes:
- Custom admin menu and form
- API integration using `wp_remote_post()`
- Secure and sanitized form handling
- Activation hook to create the custom table
- Deactivation hook to clean up (optional)
- “Settings” link on the Plugins page for quick access

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **API Plugin** in the admin sidebar
4. Enter sample data and click submit
5. View results on your mock API endpoint (like [webhook.site](https://webhook.site))

== Frequently Asked Questions ==

= Does this plugin require an actual API? =
No, you can test it using [https://webhook.site](https://webhook.site) or plug in your own API URL.

= Does it store the data locally? =
Yes. Submitted data is stored in a custom table called `wp_my_api_plugin_users`.

= Will the database table be removed on deactivation? =
Not by default, but you can uncomment the code in `on_deactivate()` if you want to drop the table.

== Screenshots ==

1. Admin form to collect user data
2. Example data sent to webhook.site
3. Custom database table in phpMyAdmin

== Changelog ==

= 1.0 =
* Initial release
* Collects user input
* Stores data in DB
* Sends data to external API
* Includes settings link and deactivation hook

== Upgrade Notice ==

= 1.0 =
First stable release. No upgrade steps necessary.

