<?php

function show_referer(){
    if(strpos($_SERVER['HTTP_REFERER'], 'list-manage.com')){
        if(isset($_COOKIE['_wp_mailchimp_signup_form']) && $_COOKIE['_wp_mailchimp_signup_form'] !== $_SERVER['REQUEST_URI']){
            $path = $_COOKIE['_wp_mailchimp_signup_form'];
            unset($_COOKIE['_wp_mailchimp_signup_form']);
            header('Location: '.$path);
        }
    }
}

add_action('wp_head', 'show_referer');

function js_cookie_code(){
    ?>
    <script>
    function SetCookie(c_name,expiredays) {
        value = window.location.pathname;
        var exdate = new Date();
        exdate.setDate(exdate.getDate()+1);
        document.cookie=c_name+ "="+escape(value)+";path=/;expires="+exdate.toGMTString();
    }
    </script>
    <?php
}
add_action('wp_head', 'js_cookie_code');
