<?php
/**
 * @file test.php
 */
/**
 * Class test
 */
class test {
    public function all() {
        $this->in();
        $this->user();
        $this->abc();
    }
    public function user() {

        echo "Test User Class:\n";
        $user_login = 'TEST' . date('his');
        $meta = [
            'user_login' => $user_login,
            'user_pass' => '1234',
            'nickname' => 'NicknameTest',
            'user_email' => $user_login . '@gamil.com',
            'address' => 'address test',
            'first_name' => 'First Name ' . $user_login,
            'last_name' => 'Test Last Name',
            'skype' => 'SkypeTest',
            'kakao' => 'KakaoTest',
        ];



// delete if exists.
        if ( user( $meta['user_login'] )->exists() ) user( $meta['user_login'] )->delete();

        test ( ! user( $meta['user_login'] )->exists(), "error if exist. User $meta[user_login] exists. It should not exits.");
        test ( ! is_wp_error(user()->create($meta)), "error if create fail." );

        test ( user( $meta['user_login'] )->exists(), "error if not exists. User $meta[user_login] does not exist.");

        $user_a = user( $meta['user_login'] );
        $user_b = user( $meta['user_email'] );
        test ( $user_a->ID == $user_b->ID, "error if user is not loaded by email.");

        test ( user( $meta['user_login'] )->delete(), "error if delete failed." );
        test ( ! user( $meta['user_login'] )->exists(), "error if exists. User $meta[user_login] exists. It should not exits.");

        test ( ! is_wp_error(user()->create($meta)), "error if create failed." );

        $user = user( $meta['user_login'] );

        test( $user->exists(), "error if user not exists. User does not exist - $meta[user_login]" );
        test( $user->get('skype') == $meta['skype'], "error if sktype does not match. User skype does not match");

        $user->set('abc', 'def');
        test( $user->abc == 'def', 'error if abc is not def' );

        $new_email = "NewEmail" . date('is') . '@gmail.com';
//echo "\nnew_email: $new_email\n";
        $user->set('user_email', $new_email);
        test( $user->user_email == $new_email, "error if user_email is not $new_email. User email is " . $user->user_email);
        test( $user->user_email == user( $user->user_login )->user_email, "error if user_email is not $new_email. User email is " . $user->user_email);
        $obj = user( $user->ID );
        test( $obj->user_email == $user->user_email, "error if user_email is different from current instance and newly created instance.");


        $user->new_key = "new vlaue";
        test( $user->new_key == user( $user->ID )->new_key, 'error if new key is not same');


// nicename 은 소문자와 숫자, 하이픈만 되는가? 공백도 안되는가?
        $user->user_nicename = "mynicename" . date('is');
        test( $user->user_nicename == user( $user->ID )->user_nicename, "error if nice name does not match user->nicename : {$user->user_nicename}, obj->user_nicename: {$obj->user_nicename}");
        test( $user->user_nicename == user( $user->user_login )->user_nicename, "error if nice name does not match user->nicename : {$user->user_nicename}, obj->user_nicename: {$obj->user_nicename}");
        test( $user->user_nicename == user( $user->user_email )->user_nicename, "error if nice name does not match user->nicename : {$user->user_nicename}, obj->user_nicename: {$obj->user_nicename}");

        test ( user( $meta['user_login'] )->delete(), "error if delete failed. User delete failed." );




        $user_login = 'T' . date('is');
        $meta['user_login'] = $user_login;
        $meta['user_pass'] = $user_login;
        $meta['user_email'] = $user_login . '@gmail.com';
        $meta['nickname'] = $user_login;


        test( user()->currentUser()->ID == 0, "error if user logged in when it didn't");
        user()->create($meta);
        test( user()->currentUser()->ID == 0, "error if user logged in when it didn't");
        $user_o = user( $meta['user_email'] );


        wp_set_current_user( $user_o->ID );
        test( user()->currentUser()->ID == $user_o->ID, 'error if ID is not the same');
        test( user()->currentUser()->user_login == $user_o->user_login, 'error if user_login is not the same');
        $user_o->delete();
    }

    public function abc() {

        test( ! abc()->route( 'this-route-does-not-exists'), 'Error if route exists' );


        abc()->registerRoute('my-route');
        test( abc()->route( 'my-route') );
        abc()->registerRoute('test-route');
        test( abc()->route( 'test-route') );


    }
    public function in() {
        test( in('this-is-no-prameta') === null, 'Error if it is not null');
        $_GET['param100'] = '100';
        test( in('param100') == '100', 'Error if it is not 100');
        test( in('param100') == 100, 'Error if it is not 100');
        test( in('param100') != 200, 'Error if it is not 200');
    }
}
