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

add_action('wp_footer', function(){
    /**
     *
     * @todo this code must be moved into lms
    $domain = get_opt('lms[domain]');
    if ( empty($domain) ) {
        echo "
    <script>
    alert('Error: No domain in LMS Settings.');
    </script>
    ";
    }
    */
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
