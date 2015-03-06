<?php
	require_once ('TransformMonkey.php');

	$transform_monkey = new TransformMonkey();
	
	$post_author = (isset($_SESSION['logined']) && $_SESSION['logined'] == true)
		?	$transform_monkey->config['TM_MONKEY_PREFIX'].$_SESSION['lark.transform.monkey']['name']	:	$cookie;
