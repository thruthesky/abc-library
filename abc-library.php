<?php
/**
 * Plugin Name: ABC Library By Withcenter Dev Team
 * Plugin URI: http://it.phlgo.com
 * Author: JaeHo Song
 * Description: This is ABC Library For WordPress. See Readme.MD file for more information.
 * Version: 0.0.4
 *
 *
 *
 */
/**
 * wp-include/library.php
 */
if ( defined('ABC_LIBRARY') ) return;
define('ABC_LIBRARY', TRUE);
define( 'ABC_PATH', plugin_dir_path( __FILE__ ) );

$GLOBALS['abc_classes'] = [];
global $abc_classes;

require "function.php";
require "shortcode.php";
require "hook.php";


require "class/user.php";       $abc_classes[] = 'user';
require "class/test.php";       $abc_classes[] = 'test';
require "class/abc.php";        $abc_classes[] = 'abc';


dog('abc-library ' . date('r'));



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
 *
 * @note Apr 4, 2016. Routing pattern has been updated for naming class::methods. It only routes if class name and method name look Okay.
 *
 *          - It passes route which does not look like class::method - "http://work.org/wordpress/user-register"
 *          - It runs after all plugin-script and theme/functions.php have been loaded.
 *
 * ABC-Library Router
 * /abc/count ==> abc::count
 * /user/count ==> user::count
 * /abc/all ==> abc:all
 * /test/all ==> test:all
 */
add_action('wp_loaded', function(){
    global $abc_classes;
    //dog('abc-library: wp_loaded');
    if ( in_array( segment(0), $abc_classes) ) loadRoute( segment(0), segment(1) );
});


/**
 *
 * ABC Library loads font-awesome, dashcons, wp-utils by default.
 */
add_action( 'wp_enqueue_scripts', function() {
    dog('abc-library: wp_enqueue_scripts');
    wp_enqueue_style('font-awesome', plugins_url('css/font-awesome/css/font-awesome.min.css', __FILE__));
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_script( 'wp-util' );
});



