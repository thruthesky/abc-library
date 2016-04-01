<?php

class abc {
    static $routes = [];
    public function __construct()
    {
        add_filter('template_redirect', function() {
            global $wp_query;
            if ( is_404() ) {
                if ( in_array( segment(0), abc()->routes() ) ) {
                    status_header( 200 );
                    $wp_query->is_404 = false;
                }
            }
        });
    }

    public function routes()
    {
        return self::$routes;
    }

    /**
     * @return bool
     */
    public function route( $route = null ) {
        if ( ! $route ) $route = segment( 0 );
        return in_array( $route, self::$routes );
    }

    public function registerRoute( $route ) {
        if ( is_array( $route ) ) self::$routes += $route;
        else self::$routes[] = $route;
    }

    /**
     *
     * Renders the contents of the given template to a string and returns it.
     *
     * @param string $template_name The name of the template to render (without .php)
     * @param array  $attributes    The PHP variables for the template
     *
     * @return string               The contents of the template.
     *
     */
    public function getTemplate($template_name = null, $attributes = null ) {

        if ( empty( $template_name ) ) $template_name = segment(0);
        if ( ! $attributes ) {
            $attributes = array();
        }

        $path = get_template_directory() . "/$template_name.php";
        if ( ! file_exists( $path ) ) $path = ABC_PATH . "template/$template_name.php";


        ob_start();

        do_action( 'abc_before_' . $template_name );

        require( $path );

        do_action( 'abc_after_' . $template_name );

        $html = ob_get_contents();

        ob_end_clean();


        do_action( 'abc_template_html_' . $template_name, $html );

        return $html;
    }


    /**
     *
     * Load header
     *
     * If "?theme=no" is input, it does not load header.
     *
     * @return null
     */
    public function header() {
        if ( in('theme') == 'no' ) return null;
        get_header();
    }
    public function footer() {
        if ( in('theme') == 'no' ) return null;
        get_footer();
    }
}

function abc() {
    return new abc();
}

