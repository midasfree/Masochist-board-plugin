<?php

    require_once ('ColorfulMonkey.php');
    
    $colorful_monkey = new ColorfulMonkey();
    
    global $data;
    
    echo json_encode($colorful_monkey->color_change($data));
    
    exit();
