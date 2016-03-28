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


/**
 * ABC-Library Router
 */
if ( segment(0) == 'abc' ) {
    $class = segment(1);
    $method = segment(2);
    $obj = new $class();
    if ( method_exists( $obj, $method ) ) {
        $obj->$method();
        die();
    }
    die("$class::$method() does not exists.");
}
