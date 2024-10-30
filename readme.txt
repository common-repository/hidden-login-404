=== Hidden Login 404 ===
Contributors: vovasik, petrozavodsky
Donate link: http://alkoweb.ru/
Tags: login form, anti brute force, antispam
Requires at least: Your web server is running on apache, nginx not supported.
Tested up to: 5.2.3
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plug-in to hide the login page, change the url: wp-login.php and wp-admin maintaining functionality

== Description ==

In connection with the cases of attempts to guess passwords to the administrative panel on the CMS website, the need to plug protects your authorization form.
Plugin Hidden Login 404 redirects requests to the administration of the site at an arbitrary URL is hampering password guessing attempts.
404 received a response from the server, most of the brute Forz Bots stop guessing attempts without creating a heavy load on the blog.
Attention.
After activating the plugin, you will not be able to log in to wordpress, standard obrazaom pages wp-login.php and wp-admin.

== Installation ==
1. Upload `hidden_login` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= After activating the plugin can not login. What to do =

After activating the plugin, your admin panel will be on yadostupna url http://youdomine.com/su.php


= Remove and uninstall the plugin manually =

1. Delete the directory 'hidden_login' from the directory 'plugins'
2. Remove from. Htaccess file lines:

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^su.php$ wp-login.php [L]
</IfModule>

== Screenshots ==

1. Activating the plugin.

== Changelog ==

= 1.0 =

Added redirect authorized user

== Upgrade Notice ==

= 1.0 =

This version has become possible to apply directly to the url http:// youdomine.com/su.php with the book, with the fall in the admin panel

This program is free software; you can redistribute it and/or modify it under
the terms of the [GNU General Public License][] as published by the Free
Software Foundation; either version 2 of the License, or (at your option) any
later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

[GNU General Public License]: http://www.gnu.org/copyleft/gpl.html
