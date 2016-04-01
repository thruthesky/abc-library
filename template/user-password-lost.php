<?php
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    ob_start();
    include ABSPATH . '/wp-login.php';
    $output = ob_get_clean();
    $errors = retrieve_password();
    if ( is_wp_error($errors) ) {
        echo get_error_message($errors);
    }
    else {
        _e('Password reset link has been sent to your email. Please check your email.');
    }
}
?>
<h2>Plugin User password lost</h2>


<section class="lost-password">
    <form action="<?php echo home_url('/user-password-lost')?>" method="POST">
        <input type="hidden" name="redirect_to" value="<?php echo home_url('/log-in?action=lostpassword')?>">
        <div class="line">
            <label class="caption" for="user_login">User ID or Email</label>
            <div class="text"><input type="text" name="user_login" maxlength="64" id="user_login" tabindex="100"></div>
        </div>
        <div class="line submit">
            <div class="text"><input class="abc-button" type="submit" value="Send me new password" tabindex="121"></div>
        </div>

        <div class="line cancel">
            <div class="text abc-button cancel">Cancel</div>
        </div>

    </form>
</section>

