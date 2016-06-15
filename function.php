<?php
/**
 * @file function.php
 * @package abc-library
 *
 */


if ( ! function_exists('in') ) {
    /**
     *
     * @note By default it returns null if the key does not exist.
     *
     * @param $name
     * @param null $default
     * @return null
     *
     */
    function in( $name, $default = null ) {
        if ( isset( $_POST[$name] ) ) return $_POST[$name];
        else if ( isset( $_GET[$name] ) ) return $_GET[$name];
        else return $default;
    }
}



if ( ! function_exists( 'di' ) ) {
    function di($o) {
        $re = print_r($o, true);
        $re = str_replace(" ", "&nbsp;", $re);
        $re = explode("\n", $re);
        echo implode("<br>", $re);
    }
}

function test( $re, $message = null ) {
    static $count_test = 0;
    $count_test ++;
    if ( $re ) echo "$count_test ";
    else {
        echo "\nERROR : $message\n";
        die();
    }
}

/**
 * @note 2016-06-11 Adding default value.
 * @todo remove segments() in other libraries.
 */
if ( ! function_exists('segments') ) {
    /**
     * @param null $n
     * @return array|null
     *      if $n is null, then it returns whole segments in an array.
     */
    function segments($n = NULL) {
        $u = strtolower(site_url());
        $u = str_replace("http://", '', $u);
        $u = str_replace("https://", '', $u);
        $r = strtolower($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $uri = str_replace( "$u/", '', $r);
        $arr = explode('?', $uri);
        $re = [];
        if ( $arr ) {
            $re = explode('/', $arr[0]);
        }
        if ( $n !== NULL ) {
            if ( isset($re[$n]) ) return $re[$n];
            else return NULL;
        }
        else return $re;
    }
    function segment( $n = 0 ) {
        return segments($n);
    }

}
if ( ! function_exists('seg') ) {

    function seg($n = 0 ) {
        return segment($n);
    }

}


/**
 *
 * Removes admin toolbar on top of the website ( not in admin page )
 *
 *
 * @param bool $admin
 *      - if it's true, it removes admin bar for admin also.
 *      - if it's false, it only removes admin bar for users. not for admin.
 *
 * @code
        add_action('after_setup_theme', function (){
            remove_admin_bar(true);
        });
 * @endcode
 */
function remove_admin_bar( $admin = false ) {
    if ( $admin ) {
        show_admin_bar(false);
    }
    else if ( ! current_user_can('administrator') && ! is_admin() ) {
        show_admin_bar(false);
    }
}

function get_logout_url() {
    is_home() ? $logout_url = home_url() : $logout_url = get_permalink();
    return wp_logout_url($logout_url);
}


/**
 * @deprecated use opt()
 * @param $storage
 * @param $name
 * @param bool|true $escape
 */
function option($storage, $name, $escape = true) {
    $options = get_option($storage);
    if ( $escape ) $re = esc_attr( $options[$name] );
    else $re = $options[$name];
    echo $re;
}

/**
 *
 * Returns option value
 *
 * @param $name - is option name. It can be an element of array. like "abc[def]"
 * @param null $default - is the default value which will be returned if the value of the option name is empty.
 * @param bool $escape
 * @return mixed|null|void
 * @code
 *  echo opt('abc', 'def');
 *  echo opt('lms[logo]', 'img/logo.jpg');
 * @endcode
 *
 * @code
 *      "option('lms', 'company_name')" can be converted into "opt('lms[company_name]')"
 *      "get_option( 'lms' );" can be converted into "get_opt('lms')"
 * @endcode
 */
function get_opt($name, $default=null, $escape = true) {


    $value = null;
    if ( strpos( $name, '[' ) ) {
        list( $name, $rest ) = explode( '[', $name );
        $element = trim($rest, ']');
        $arr = get_option( $name );
        if ( isset( $arr[$element] ) ) $value = $arr[$element];
    }
    else {
        $value = get_option( $name );
    }


    if ( empty($value) ) $value = $default;

    if ( $escape ) $value = esc_attr( $value );

    return $value;
}

/**
 * Echoes the return value of 'get_opt'
 * @param $name
 * @param null $default
 * @param bool $escape
 * @code
 * <?php opt('lms[logo]', 'img/logo.jpg')?>
 * @endcode
 */
function opt($name, $default=null, $escape = true) {
    echo get_opt($name, $default, $escape);
}




/**
 * @return string - theme directory uri
 */
function td() {
    return get_template_directory_uri();
}

/**
 * Echoes td()
 */
function tde() {
    echo td();
}

/**
 * @deprecated use imge()
 * @note it ECHOes image directory uri including ending slash.
 */
function id() {
    echo td() . '/img/';
}
function img() {
    return td() . '/img/';
}
function img_e() {
    echo img();
}




/**
 * @deprecated just use esc_url(home_url())
 *
 * Echoes home page directory uri including slash.
 *
 */
function hd() {
    echo esc_url( home_url( '/' ) );
}




if ( ! function_exists( 'dog' ) ) {

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

}


/**
 *
 * ABC Routing
 *
 * @code How to register routes.
        abc_register_route( array(
        'about-us',
        'level-test',
        'enrollment',
        'curriculum',
        'reservation',
        ) );
 * @endcode
 *
 * @code How to load script if route is accessed.
    if ( abc_registered_route( $segment = segment(0) )) {
        include get_template_directory() . "/page/$segment.php";
    }
 * @endcode
 *
 *
 */
$GLOBALS['abc_routes'] = array();
/**
 * @deprecated use abc()->registerRoute( 'route' );
 * @param array $array
 */
function abc_register_route( array $array ) {
    global $abc_routes;
    $abc_routes += $array;
    add_filter('template_redirect', function () use ( $abc_routes ) {
        global $wp_query;
        if ( is_404() ) {
            if ( abc_registered_route(segment(0)) ) {
                status_header( 200 );
                $wp_query->is_404=false;
            }
        }
    });
}

/**
 * @deprecated use abc()->route()
 * @param $route
 * @return bool
 */
function abc_registered_route( $route ) {
    global $abc_routes;
    return in_array( $route, $abc_routes );
}

/**
 *
 * @param $code
 * @param string|WP_Error $message - it may be a string or WP_Error.
 *  If WP_Error is passed, then it gets the key and message of the error.
 * @return array
 */
function json_error( $code, $message ) {
    if ( is_wp_error( $message ) ) {
        list ( $k, $v ) = each ($message->errors);
        $message = "$k : $v[0]";
    }
    return array(
        'code' => $code,
        'message' => $message
    );
}

function json_success( $data = array() ) {
    return array(
        'code' => 0,
        'data' => $data
    );
}

/**
 * Returns error message from WP_Error.
 * @param $error
 * @return string|void
 */
function get_error_message( $error ) {
    if ( ! is_wp_error($error) ) return;

    list ( $k, $v ) = each ($error->errors);
    return "$k : $v[0]";
}

function loadRoute( $class, $method ) {
    $obj = new $class();
    if ( method_exists( $obj, $method ) ) {
        $obj->$method();
        die();
    }
    die("$class::$method() does not exists.");
}

/**
 * Alerts the message in Javascript
 * @param $msg
 * @return null
 */
function jsAlert($msg) {
    echo <<<EOS
    <script>
    setTimeout(function(){
        alert("$msg");
    }, 200);
    </script>
EOS;
    return null;
}


/**
 *
 * Returns domain with/without "www." & "TLDs"
 *
 * @param bool|true $host_without_TLD
 * @param null $domain
 * @return mixed|null|string
 * @code

echo '<br>' . get_domain_name(true, 'www.philgo.com');               // philgo
echo '<br>' . get_domain_name(false, 'www.philgo.com');              // www.philgo.com
echo '<br>' . get_domain_name(true, 'tv.philgo.co.kr');              // tv.philgo
echo '<br>' . get_domain_name(false, 'tv.philgo.co.kr');             // tv.philgo.co.kr
echo '<br>' . get_domain_name(true, 'tv.philgo.net');                // tv.philgo
echo '<br>' . get_domain_name(true, 'abc.def.philgo.org');           // abc.def.philgo
echo '<br>' . get_domain_name(true, 'www.def.philgo.kr');            // def.philgo
echo '<br>' . get_domain_name(true, 'www.philgo.net');               // philgo

 *
 * @endcode
 */
function get_domain_name( $host_without_TLD = true, $domain = null ) {
    $arr = [ 'co.kr', 'kr', 'com', 'net', 'org' ];
    if ( empty($domain) ) $domain = $_SERVER['HTTP_HOST'];
    $domain = strtolower( $domain );
    if ( $host_without_TLD ) {
        $domain = str_replace('www.', '', $domain);
        foreach( $arr as $needle ) {
            if ( strpos( $domain, '.'.$needle) ) return str_replace( '.' . $needle, '', $domain );
        }
    }
    return $domain;
}
