<?php
    require_once('GreenCall.php');
    
    $green_call = new GreenCall();
    
    if (isset($_POST['target_id']))
    {
        echo json_encode($green_call->call_post($_POST['target_id']));
    }
