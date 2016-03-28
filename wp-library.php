<?php
/**
 * Plugin Name: Wordpress Library By Withcenter Dev Team
 * Plugin URI: http://it.phlgo.com
 * Author: JaeHo Song
 * Description: Helper Library For Wordpress
 * Version: 0.0.4
 */


/**
 * wp-include/library.php
 */

define('WP_LIBRARY', TRUE);

require "function.php";
require "class/user.php";
require "shortcode.php";
require "hook.php";

dog('wp-library loaded --- ' . date('r'));


if ( segment(0) == 'wp-library' ) require 'test/test.php';





/**
 * Make this plugin run first.
 */
add_action("activated_plugin", function () {
    // ensure path to this file is via main wp plugin path
    $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
    $this_plugin = plugin_basename(trim($wp_path_to_this_file));
    $active_plugins = get_option('active_plugins');
    $this_plugin_key = array_search($this_plugin, $active_plugins);
    if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
        array_splice($active_plugins, $this_plugin_key, 1);
        array_unshift($active_plugins, $this_plugin);
        update_option('active_plugins', $active_plugins);
    }
});

