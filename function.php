<?php

/**
 *
 */

function di($o) {
    $re = print_r($o, true);
    $re = str_replace(" ", "&nbsp;", $re);
    $re = explode("\n", $re);
    echo implode("<br>", $re);
}


function segments($n = NULL) {
    $u = strtolower(site_url());
    $u = str_replace("http://", '', $u);
    $u = str_replace("https://", '', $u);
    $r = strtolower($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    $uri = str_replace( "$u/", '', $r);
    $re = explode('/', $uri);
    if ( $n !== NULL ) return $re[$n];
    else return $re;
}
function segment($n) {
    return segments($n);
}


/**
 * Removes admin bar for users only.
 */

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function get_logout_url() {
    is_home() ? $logout_url = home_url() : $logout_url = get_permalink();
    return wp_logout_url($logout_url);
}


function option($storage, $name, $escape = true) {
    $options = get_option($storage);
    if ( $escape ) $re = esc_attr( $options[$name] );
    else $re = $options[$name];
    echo $re;
}

/**
 * @return string - theme directory uri
 */
function td() {
    return get_template_directory_uri();
}

/**
 * @note it ECHOes image directory uri including ending slash.
 */
function id() {
    echo td() . '/img/';
}

/**
 * Echoes home page directory uri including slash.
 */
function hd() {
    echo esc_url( home_url( '/' ) );
}




function dog( $message ) {
    static $count_dog = 0;
    $count_dog ++;
    if( WP_DEBUG === true ){
        if( is_array( $message ) || is_object( $message ) ){
            $message = print_r( $message, true );
        }
        else {

        }
    }
    $message = "[$count_dog] $message";
    error_log( $message );
}
