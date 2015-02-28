<?php

	class TransformMonkey
	{
		private $config;
		
		function __construct()
		{
			global $plugin;

			$this->config = $plugin->config['lark.transform.monkey'];
		}
		
		public function logined_confirm()
		{
			require_once ('monkey.php');
			
			foreach ($monkey as $result)
			{	
				if (md5(md5($result['password']) . $_SESSION['key']) == $_POST['password'])
				{
					$_SESSION['logined'] = true;
					$_SESSION['lark.transform.monkey']['name'] = $result['monkeyName'];
					break;
				}
				else
				{
					$_SESSION['logined'] = false;
				}
			}
			return $_SESSION['logined'];
		}
		
	}
