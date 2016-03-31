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
    $username = user()->getUsername();
    if ( $username ) return $content;
    else return '';
});
add_shortcode( 'wp_log_out', function($attr, $content=null) {
    if ( empty( $content ) ) return "Input logout content.";
    $username = user()->getUsername();
    if ( $username ) return '';
    else return $content;
});
add_shortcode( 'wp_log_info', function() {
    $username = user()->getUsername();
    if ( $username ) {
        $url = get_logout_url();
        return <<<EOH
        <strong>$username</strong> 님 환영합니다.<br>
		<a href="$url">로그아웃</a>
EOH;
    }
    else {
        return do_shortcode("[wordpress_social_login]");
    }
});
