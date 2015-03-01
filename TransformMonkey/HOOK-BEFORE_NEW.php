<?php
	
	$post_author = (isset($_SESSION['logined']) && $_SESSION['logined'] == true)
		?	$_SESSION['lark.transform.monkey']['name']	:	$cookie;
