<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 12:18 PM
 */
class SweetCookie
{
    public $config;
    private $expiration_time;

    function __construct()
    {
        global $plugin;

        $this->config = $plugin->config['losses.sweet.cookie'];
        $this->expiration_time = time() + $this->config['EX_EXPIRATION_TIME'] * 86400;
    }

    private function generate_cookie()
    {
        $_SESSION['sweetCookie']['cookie'] = substr(md5(time() . UR_SALT), 0, 7); //饼干生成方法
        $_SESSION['sweetCookie']['expiration_time'] = $this->expiration_time;

        return $_SESSION['sweetCookie']['cookie'];
    }

    public function cookie_checker()
    {
        if (isset($_SESSION['logined']))
            return 'Admin';

        if (!isset($_SESSION['sweetCookie']['cookie'])
            || time() > $_SESSION['sweetCookie']['expiration_time']
        ) {
            if (!$this->config['EX_ENABLE_COOKIE']) {
                return false;
            } else {
                return $this->generate_cookie();
            }
        } else {
            $_SESSION['sweetCookie']['expiration_time'] = $this->expiration_time;
            return $_SESSION['sweetCookie']['cookie'];
        }
    }
}