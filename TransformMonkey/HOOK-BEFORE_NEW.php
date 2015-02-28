<?php

	require_once ('TransformMonkey.php');

	$transform_monkey = new TransformMonkey();
	
	if (isset($_POST['password']))
	{
		if (!isset($_SESSION['key']))
		{
			response_message(403, 'You need a key!');
			exit();
		}
		else
		{
			$islogined = $transform_monkey->logined_confirm();
			
			if ($islogined == true)
			{
				response_message(200, '兽人永不为奴!');
			}
			else
			{
				response_message(403, 'UCCU输错密码的样子，真是丑陋!');
			}
			exit();
		}
	}
	
	$post_author = (isset($_SESSION['logined']) && $_SESSION['logined'] == true)
		?	$_SESSION['lark.transform.monkey']['name']	:	$cookie;
