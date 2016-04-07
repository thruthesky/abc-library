<?php
/**
 * @file hook.php
 *
 * @desc This library file helps on hooking.
 * Do hooks.
 *
 */

/**
 * Password Reset Hook
 * @warning Once you install this plugin, it will automatically hook and do its way.
 *
 */

add_action('init', function() {
    if ( in('action') == 'rp' && in('key') && in('login') ) {
        $url = remove_query_arg( 'action' );
        $url = str_replace("wp-login.php", 'user-password-reset', $url);
        wp_redirect( $url );
        die();
    }
});

/**
 * Displays the markup(HTML) on the hook.
 * @param $action - action hook name to display data on.
 * @param $option - option name of the storage.
 * @param null $element - element name if the storage is array.
 */
function display_option_on( $action, $option, $element = null ) {
    add_action( $action, function() use ( $option, $element ) {
        $storage = get_option( $option );
        $markup = null;
        if ( $element ) {
            if ( isset($storage[$element] ) ) $markup = $storage[$element];
        }
        else $markup = $storage;
        echo $markup;
    });
}
add_filter( 'the_content', function( $content ) {
    $str = "Length of Content: " . strlen($content);
    $content = "$str $content";
    return $content;
});
add_action( 'get_header', function() {

} );