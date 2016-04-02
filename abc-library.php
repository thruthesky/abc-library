<?php
/**
 * Plugin Name: ABC Library By Withcenter Dev Team
 * Plugin URI: http://it.phlgo.com
 * Author: JaeHo Song
 * Description: This is a basic helper library For Wordpress.
 * Version: 0.0.4
 *
 *
 *
 */
/**
 * wp-include/library.php
 */

define('ABC_LIBRARY', TRUE);
define( 'ABC_PATH', plugin_dir_path( __FILE__ ) );
$GLOBALS['abc_classes'] = array();
global $abc_classes;

require "function.php";
require "shortcode.php";
require "hook.php";


require "class/user.php";           $abc_classes[] = 'user';
require "class/test.php";           $abc_classes[] = 'test';
require "class/abc.php";            $abc_classes[] = 'abc';


dog('abc-library' . date('r'));



abc()->registerRoute(
    [
        'intro',
        'user-log-in',
        'user-register',
        'user-update',
        'user-password-lost',
        'user-password-reset',
    ]
);

/**
 * ABC-Library Router
 * /abc/count ==> abc::count
 * /user/count ==> user::count
 * /abc/all ==> abc:all
 * /test/all ==> test:all
 */
if ( in_array( segment(0), $abc_classes ) ) loadRoute( segment(0), segment(1) );

/**
 *
 * ABC Library loads font-awesome, dashcons, wp-utils by default.
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style('font-awesome', plugins_url('css/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_script( 'wp-util' );
});



