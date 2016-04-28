# ABC Library
Is a basic helper library for WordPress developed by Withcenter Dev Team.
Abc library can be used for other themes and plugins.



# How to use

1. Install or include abc-library

    1-1. Activate it.


2. Install depending plugins or themes.

    2-1. Activate it.

    2-2. The depending plugins or themes must code like below before using any of abc-library code.

# plugin

When you create a template in plugin template folder,

you must put CSS, Javascript in the template file.


## Default routes and templates

Intro page and User log-in/register/update/password-lost are the default templates and served by default.

Inside abc-library.php, it is registered like below.

    abc()->registerRoute(
        [
            'intro',
            'user-log-in',
            'user-register',
            'user-update',
            'user-password-lost',
        ]
    );


You can override the templates by creating a template with same file name


# theme


## header 와 footer 의 출력 옵션

    if ( ! isset($_REQUEST['_no_theme']) ) get_header();

    if ( ! isset($_REQUEST['_no_theme']) ) get_footer();

와 같이 해서 "?_no_theme=1" 와 같이 입력되면, 헤더, 푸터를 출력하지 않는다.

이것은 sidebar 에도 적용을 할 수 있다.

unittest 와 같은 경우는 이와 같이 사용 할 수 있다.



## abc()->header(), abc()->footer()

    @deprecated Do not use this methods. Hard code in the theme instead.

These methods are more on test purpose.

it simply calls get_header(), get_footer().


    The only difference is that if "?theme=no" is set, then it does not calls get_header(), get_footer().


Use these instead of get_header() and get_footer() when you do not need 'header' and 'footer' parts.

Use case

- when you test plugin or theme script.
- when you need to show content inside iframe.


test code :

    $ curl work.org/wordpress/intro?theme=no


# abc()->route( ' route name ' )

It checks if the route name is registered.

if no parameter given, segement(0) will be used instead.

# abc()->getTemplate( ' file name without .php ' )

It loads a template.

if no parameter given, segement(0) will be used instead.

if a template file exists on theme folder, then it uses that template or it uses the template in plugin-foler's template folder.


sample index.php

    <?php
    abc()->header();
    if ( abc()->route() ) echo abc()->getTemplate();
    else if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            get_template_part( 'content', get_post_format() );
        }
    }
    abc()->footer();


# How to apply abc()->route() and abc()->getTemplate() on other themes. 

Some times you will need to use this code to use the register, update, password reset. 

Put the code below inside any theme.


    <?php if ( have_posts() ) : ?>
        // ... code if there is post
    <?php elseif ( abc()->route() ) : ?>
        // ... Below will be run if /user-register, /user-password-lost accessed.
        <?php echo abc()->getTemplate(); ?>
    <?php endif; ?>




# User Registration / Login / Update / Password Reset

ABC Library has its own routine for user registration, login, update, password reset.



# shortcode

예제)

    [wp_log_in]로그인 정보[/wp_log_in]
    [wp_log_out]로그인하기[/wp_log_out]
    <br>
    [wp_log_info]

