<?php
/**
 * @file hook.php
 *
 * @desc This library file helps on hooking.
 * Do hooks.
 *
 */


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
