<?php
/**
 * @file class.php
 */

/**
 * Class WP_INCLUDE_USER
 */
class WP_INCLUDE_USER {

    /**
     * Returns / Echoes username.
     * user()->username();
     * @return string
     */
    public function getUsername() {
        global $current_user;
        get_currentuserinfo();
        return $current_user->user_login;
    }
    public function username() { echo $this->getUsername(); }
}

/**
 * @return WP_INCLUDE_USER
 */
function user() {
    return new WP_INCLUDE_USER();
}

