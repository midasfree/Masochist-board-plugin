<?php
/******************************************\
 *  TealGuard plugin for Masochist-Board  *
 *                  Ver 0.1 By Losses Don *
 *                   losses.don@gmail.com *
 ******************************************/

$plugin_info = [
    "IDENTIFICATION" => "losses.teal.guard"
];

$plugin_injector = [
    "HOOK-BEFORE_NEW" => "HOOK-BEFORE_NEW.php",
    "HOOK-BEFORE_POST" => "HOOK-BEFORE_VIEW.php",
    "HOOK-BEFORE_LIST" => "HOOK-BEFORE_VIEW.php"
];

$plugin_config = [
    "GUARD_CONTENT" => ['session.sweetCookie.cookie'],

    "GUARD_TICKER" => 1,

    "GUARD_COL" => [
        'author' => 'session.sweetCookie.cookie'
    ],

    "CHAIN_MODE" => true,

    "GUARD_READONLY" => false,

    "GUARD_SAYS" => [
        "id" => 0,
        "title" => "汝已经被驱逐出境。",
        "content" => "亲爱的用户，由于某些原因您被驱逐出境，无法再访问本站的任何内容。",
        "author" => "茅场晶彦",
        "time" => "4242-42-42 42:42:42",
        "sage" => 0,
        "upid" => 0,
        "category" => 0
    ]
];
