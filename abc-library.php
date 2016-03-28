<?php
/**
 * Plugin Name: ABC Library By Withcenter Dev Team
 * Plugin URI: http://it.phlgo.com
 * Author: JaeHo Song
 * Description: This is a basic helper library For Wordpress.
 * Version: 0.0.4
 */


/**
 * wp-include/library.php
 */

define('ABC_LIBRARY', TRUE);

require "function.php";
require "class/user.php";
require "shortcode.php";
require "hook.php";

dog('abc-library loaded --- ' . date('r'));
