<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 2/24/2015
 * Time: 12:55 PM
 */
class TealGuard
{
    public $config;

    function __construct()
    {
        global $plugin;

        $this->config = $plugin->config['losses.teal.guard'];
        $this->checkConnection();
    }

    private function checkConnection()
    {
        global $database;

        $database
            ->query("CREATE TABLE IF NOT EXISTS `tealguard` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `value` MEDIUMTEXT NOT NULL,
                              `type` MEDIUMTEXT NOT NULL,
                              PRIMARY KEY (`id`));
                              ")
            ->fetchAll();

    }

    public function guard_activation()
    {
        global $database;

        require_once('ip.php');

        $user_ip = new user_ip();

        for ($i = 0; $i < count($this->config['GUARD_CONTENT']); $i++) {
            $guard_condition = explode('.', $this->config['GUARD_CONTENT'][$i]);

            $query_condition = [];
            $guard_content = [];

            for ($j = 0; $j < count($guard_condition); $j++) {
                if ($j == 0) {
                    switch ($guard_condition[0]) {
                        case 'session':
                            $guard_content = isset($_SESSION) ? $_SESSION : false;
                            break;
                        case 'cookie':
                            $guard_content = isset($_COOKIE) ? $_COOKIE : false;
                            break;
                        case 'post':
                            $guard_content = isset($_POST) ? $_POST : false;
                            break;
                        case 'get':
                            $guard_content = isset($_GET) ? $_GET : false;
                    }
                } else {
                    if (isset($guard_content[$guard_condition[$j]])) {
                        $guard_content = $guard_content[$guard_condition[$j]];
                    } else {
                        $guard_content = '';
                        break;
                    }
                }
            }

            if ($guard_content != '') {
                $query_condition['OR']["AND#$guard_content"] = [
                    'value[=]' => $guard_content,
                    'type[=]' => $this->config['GUARD_CONTENT'][$i]
                ];
            }
        }

        $query_condition['OR']['AND#LOSSESIP'] = [
            'value[=]' => $user_ip->get_ip_address(),
            'type[=]' => 'ip'
        ];

        $guard_blacklist = $database->select('tealguard', ['id'], $query_condition);

        return (count($guard_blacklist) != 0);
    }

}