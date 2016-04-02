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

    /**
     * @deprecated use abc()->getRoutes()
     * @return array
     */
    public function routes()
    {
        return self::$routes;
    }

    /**
     * Returns routes.
     * @return array
     */
    public function getRoutes() {
        return self::$routes;
    }

    /**
     * Check if the input $route is registered ( or exists in self::$routes )
     * @return bool
     */
    public function route( $route = null ) {
        if ( ! $route ) $route = segment( 0 );
        return in_array( $route, self::$routes );
    }

    /**
     * Registers routes.
     * @param $route
     */
    public function registerRoute( $route ) {
        if ( is_array( $route ) ) self::$routes += $route;
        else self::$routes[] = $route;
    }


    /**
     *
     * Renders the contents of the given template to a string and returns it.
     *
     * It requires the template file with WordPress environment.
     *
     * The globals are set up for the template file to ensure that the WordPress
     * environment is available from within the function. The query variables are
     * also available.
     *
     * @global array      $posts
     * @global WP_Post    $post
     * @global bool       $wp_did_header
     * @global WP_Query   $wp_query
     * @global WP_Rewrite $wp_rewrite
     * @global wpdb       $wpdb
     * @global string     $wp_version
     * @global WP         $wp
     * @global int        $id
     * @global WP_Comment $comment
     * @global int        $user_ID
     *
     * @param string $template_name     The name of the template to render (without .php)
     * @param array  $attributes        The PHP variables for the template
     *
     * @return string                   The contents of the template.
     *
     */
    public function getTemplate($template_name = null, $attributes = null ) {
        global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;


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
     * Loads & Echoes header / footer
     *
     * These methods simply mimics the get_header() / get_footer() tags.
     *
     * But the only difference is that these methods does not load the header / footer tempates
     *
     *      If "?theme=no" is set in the HTTP INPUT
     *
     * @return null
     *
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

