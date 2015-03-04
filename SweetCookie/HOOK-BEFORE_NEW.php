<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 10:00 AM
 */

require_once('SweetCookie.php');

$sweet_cookie = new SweetCookie();

$cookie = $sweet_cookie->cookie_checker();

if (!$cookie) {
    response_message(403, "没有饼干！");
    exit();
}

global $post_author;

$post_author = $cookie;

if ($sweet_cookie->config['EX_HASH_IP']) {
    global $post_ip;

    $post_ip = md5(md5($post_ip . UR_SALT . md5($post_ip)) . UR_SALT);
}
