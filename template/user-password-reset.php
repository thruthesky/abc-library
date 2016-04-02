<div class="password-reset">
    <h2>Password Reset - Abc Plugin</h2>
    <?php
    $user = check_password_reset_key( in('key'), in('login') );
    if ( ! $user || is_wp_error( $user ) ) { // 에러가 발생 한 경우,
        if ( $user && $user->get_error_code() === 'expired_key' ) { // 패스워드 변경 키 유효 기간이 지난 경우,
            echo '<div class="bad">' . __("Password reset time expired. Please reset the password again.") . '</div>';
        }
        else { // 그 외의 경우, 키를 잘못된 것으로 인정.
            echo '<div class="bad">' . __("Bad password reset link. Please reset the password again.") . '</div>';
        }
        return;
    }
    $new_password = chr(ord('a') + rand(0, 25));
    $new_password .= chr(ord('a') + rand(0, 25));
    $new_password .= rand(111, 999);
    reset_password( $user, $new_password );
    ?>
    <div class="good">
        <div class="title"><?php _e("Your temporary password is below. Please login and change your password.")?></div>
        <div class="new-password"><?php echo $new_password?></div>
    </div>
</div>
