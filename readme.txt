=== EP Admin Messages ===
Contributors: EarthPeople, eskapism
Donate link: http://earthpeople.se/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: admin, wp admin, wordpress admin, messages, notices, information, client, help, admin notice, admin notices, metabox, developer, developers
Requires at least: 3.6
Tested up to: 3.6
Stable tag: 0.1.1

Show messages in WP Admin. Different messages can be shown at different places, for different people.

== Description ==

With EP Admin Messages you can show messages in the admin area of WordPress. Each message can be shown at multiple places and can be limited to only be shown to specific user groups using capabilities.

This plugin requires that you add a config file to your themes folder. It's mostly useful for theme developers that want tho show messages in the admin to the users of their site.

= Plugin features =

* Show messages in WordPress Admin
* Show messages in different places
* Show different messages for different users
* Format messages using HTML
* Stores settings in a JSON-file. No config screen!
* Suitable for website and theme developers that want to push message changes automatically.


= Messages are shown where you want them to be shown =

You have full control over where your messages will be shown. 
Each message can be placed in one or several of the following places:

* dashboard
* overview screen for posts, pages, and custom post types
* edit screen for posts, pages and custom post types
* posts with a specific slug or a slug based on a wildcard
* user overview screen and on user profiles
* plugin install/update page


= Messages are only shown to the users that you choose =

Each message can be limited to be shown only to users with a specific [capability](http://codex.wordpress.org/Glossary#Capabilities).

You can for example show one message to your editors, i.e. users with the capability "edit_posts", and another message to your admins, i.e. users with the capability "manage_options".

= Messages can be selectd to be shown only on the posts you choose =

Messages can be limited to only be shown on posts that match a specific slug, or a slug that matches a wildcard.

This way it's easy to for example show page specific information, letting a user know what a page is for, what they should put in in, and so on.


= Config file uses JSON =

All settings are configured with a config file that uses JSON and that you put in the themes directory.

This means that there are no settings for the user to change. This also means that you can add messages using your regular deploy method. Just upload an updated config file and you're done. No database syncing needed; hooray!


= Usage scenarios =

To give you an idea what this plugin may be used for, I'll give you a list of what I do with it.

EP Simple Messages can be used to…

* … write documentation for users and developers.
* … show users what [Mustache tags](http://mustache.github.io/) are available for a specific post. You know, things like `{{user.firstname}}` or `{{campaign.name}}`.
* … show a message on the dashboard with support info, like who made the site and who they should contact for support questions.
* … let the user know what shortcodes that are available for all posts.


= Open source =

The [source code for EP Admin Messages](https://github.com/EarthPeople/ep-admin-messages) is available at GitHub.


== Installation ==

1. Upload the plugin folder to your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Add a file called `.ep-config.json` to your theme directory. This file contains your config in JSON-format. 
1. Optional: update your `.htaccess` to disable access to the config file used by this plugin (if you don't do this everyone with access to your site may be able to read your messages):

`
# Forbid access to all files beginning with a dot (.).
RedirectMatch 403 /\..*$

# Or forbid access to only .ep-config.json
# RedirectMatch 403 /\.ep-config\.json$
`


== Screenshots ==

1. Three messages being shown on the edit post screen. Notice that you can add HTML to your messages and add headlines, links, images, and so on.
2. Four messages being shown on the dashboard.


== Changelog ==

= 0.1.1 =

* Use `.ep-config.json` instead of `ep-config.json` for configuration file. Makes it a bit more secure, since dot-files often are hidden and protected by default.
* Example config `config-example.json` updated with better examples and is now in english.
* Fixed bug with notice warning when creating new posts.
* Added screenshots.

= 0.1 =

* First working version.

