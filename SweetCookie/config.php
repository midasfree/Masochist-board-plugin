<?php
/******************************************\
 * sweetCookie plugin for Masochist-Board *
 *                  Ver 0.1 By Losses Don *
 *                   losses.don@gmail.com *
 ******************************************/

$plugin_info = [
    "IDENTIFICATION" => "losses.sweet.cookie"
];

$plugin_injector = [
    "HOOK-BEFORE_NEW" => "HOOK-BEFORE_NEW.php"
];

$plugin_config = [
    "EX_ENABLE_COOKIE" => true,
    "EX_EXPIRATION_TIME" => 30,
    "EX_HASH_IP" => false
];