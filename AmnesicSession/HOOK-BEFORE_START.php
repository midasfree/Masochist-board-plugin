<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 3/4/2015
 * Time: 6:59 PM
 */

require_once('AmnesicSession.php');

$amnesic_session = new AmnesicSession();

session_set_save_handler(
    array($amnesic_session, 'open'),
    array($amnesic_session, 'close'),
    array($amnesic_session, 'read'),
    array($amnesic_session, 'write'),
    array($amnesic_session, 'destroy'),
    array($amnesic_session, 'gc')
);