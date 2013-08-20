=== EP Admin Messages ===
Contributors: EarthPeople, eskapism
Donate link: http://earthpeople.se/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: admin, wp admin, wordpress admin, messages, notices, information, client, help
Requires at least: 3.6
Tested up to: 3.6
Stable tag: 0.1

Show messages in WP Admin. Different messages can be shown at different places, for different people.

== Description ==

With EP Admin Messages you can show messages in the admin area of WordPress.

= Locations where messages can be shown =

You have full control over where your messages will be shown. 
Each message can be placed in one or several of the following places:

* on the dashboard
* on the overview screen for posts, pages, and custom post types
* on the edit screen for posts, pages and custom post types
* on posts with a specific slug or a slug based on a wildcard
* on the user overview screen and on user profiles
* on the plugin page

= Use capabilities to limit who can see what =

Each message can be limited to be shown only to users with a specific [capability](http://codex.wordpress.org/Glossary#Capabilities).

You can for example show one message to your editors, i.e. users with the capability "edit_posts", and another message to your admins, i.e. users with the capability "manage_options".

= Limit messages to posts with specific slugs =

Messages can be limited to only be shown on posts that match a specific slug, or a slug that matches a wildcard.

This way it's easy to for example show page specific information, letting a user know what a page is for, what they should put in in, and so on.

= Controlled by JSON =

All settings are made with a config file that you put in the theme directory.
This means that there are no settings for the user to change. This also means that you can add messages using your regular deploy method. Just upload an updated config file and you're done. No database syncing needed; hooray!

= Usage scenarios =

To give you an idea what this plugin may be used for, I'll give you a list of what I do with it.

I'm using EP Simple Messags to:

* ... write documentation for users and developers.
* ... show editors what [Mustache tags](http://mustache.github.io/) are available for a specific post (controlled by post slug). You know, things like `{{user.firstname}}` or `{{campaign.name}}`, that there is no way that they (or I!) will ever remember.
* ... show a message on the dashboard with support info, like who made the site and who they should contact for support questions.
* ... let the user know what shortcodes that are available for all posts.


== Installation ==

1. Upload the plugin folder to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add a file called `ep-config.json` to your theme directory. This file contains your config in JSON-format. 

== Screenshots ==

1. ....
2. ....

== Changelog ==

= 0.1 =

* First working version.

