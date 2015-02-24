<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 2:19 PM
 */

require_once('TealGuard.php');

$teal_guard = new TealGuard();

if ($teal_guard->guard_activation()) {
    print_r(json_encode([$teal_guard->config["GUARD_SAYS"]]));
    exit();
}