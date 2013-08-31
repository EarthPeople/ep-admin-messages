<?php
/*
Plugin Name: EP Admin Messages
Plugin URI: http://earthpeople.se/
Description: Show custom messages in the admin area
Version: 0.1.3
Author: Earth People
Author URI: http://earthpeople.se/
License: GPL2
*/

// Make sure wp is loaded
if ( ! defined("ABSPATH") ) die("Can not load this file directly");

// Make sure PHP version is ok with namespaces and anonymous functions
if ( version_compare(phpversion(), "5.3.0") < 0 ) die("EP Admins Messages requires PHP version 5.3.0 or higher.");

// Only load inside admin
if ( is_admin() ) require_once( dirname(__FILE__) . "/ep-admin-messages.class.php" );
