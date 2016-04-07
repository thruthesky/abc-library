<?php

/**
 *
add_shortcode( 'wp_log_in', function() {
$username = user()->getUsername();
if ( $username ) {
$url = get_logout_url();
return <<<EOH
로그인 성공<br>
<strong>$username</strong> 님 환영합니다.<br>
<a href="$url">로그아웃</a>
EOH;
}
else {
return "로그인 하기<br>" . do_shortcode("[wordpress_social_login]");
}
});
 * */

add_shortcode( 'wp_log_in', function($attr, $content=null) {
    if ( empty( $content ) ) return "Input login content.";
    if ( user()->login() ) return $content;
    else return '';
});
add_shortcode( 'wp_log_out', function($attr, $content=null) {
    if ( empty( $content ) ) return "Input logout content.";
    if ( user()->login() ) return '';
    else return $content;
});
add_shortcode( 'wp_log_info', function() {
    if ( user()->login() ) {
	$username = user()->user_login;
        $url = get_logout_url();
        return <<<EOH
        <strong>$username</strong> 님 환영합니다.<br>
		<a href="$url">로그아웃</a>
EOH;
    }
    else {
        $re = null;
        include_once ABSPATH . '/wp-admin/includes/plugin.php';
        if ( is_plugin_active('wordpress-social-login/wp-social-login.php') ) $re .= do_shortcode("[wordpress_social_login]");
        ob_start();
        include 'template/user-log-in.php';
        $re .= ob_get_clean();
        return $re;
    }
});
