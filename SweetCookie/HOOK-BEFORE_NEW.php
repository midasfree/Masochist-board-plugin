<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 10:00 AM
 */

require_once('sweetCookie.php');

$sweet_cookie = new SweetCookie();

$cookie = $sweet_cookie->cookie_checker();

if (!$cookie) {
    response_message(403, "没有饼干！");
    exit();
}

global $post_author;

$post_author = $cookie;
