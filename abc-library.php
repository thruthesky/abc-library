<?php
/**
 * Plugin Name: ABC Library By Withcenter Dev Team
 * Plugin URI: http://it.phlgo.com
 * Author: JaeHo Song
 * Description: This is a basic helper library For Wordpress.
 * Version: 0.0.4
 *
 *
 */


/**
 * wp-include/library.php
 */

define('ABC_LIBRARY', TRUE);

/**
 *
 * ABC Library loads font-awesome, dashcons, wp-utils by default.
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('font-awesome', plugins_url('css/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_script( 'wp-util' );
    wp_enqueue_style('abc-button', plugins_url('css/abc-button.css', __FILE__) );
});

require "function.php";
require "class/user.php";
require "class/test.php";
require "shortcode.php";
require "hook.php";

dog('abc-library loaded --- ' . date('r'));


/**
 * ABC-Library Router
 * /abc/user/count ==> user::count
 * /user/count ==> user::count
 * /abc/test/all ==> test:all
 * /test/all ==> test:all
 */
if ( segment(0) == 'abc' ) loadRoute( segment(1), segment(2) );
if ( segment(0) == 'user' ) loadRoute( segment(0), segment(1) );
if ( segment(0) == 'test' ) loadRoute( segment(0), segment(1) );
