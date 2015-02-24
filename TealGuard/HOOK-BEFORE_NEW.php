<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 12:54 PM
 */

require_once('TealGuard.php');

$teal_guard = new TealGuard();

if ($teal_guard->guard_activation()) {
    response_message(403, "You are not to allowed to post");
    exit();
}