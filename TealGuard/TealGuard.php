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

        $user_ip = get_ip_address();

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
            'value[=]' => $user_ip,
            'type[=]' => 'ip'
        ];

        $guard_blacklist = $database->select('tealguard', ['type'], $query_condition);

        if ($this->config['CHAIN_MODE']) {
            $if_have_ip = false;

            for ($i = 0; $i < count($guard_blacklist); $i++) {
                if ($guard_blacklist[$i] ['type'] == 'ip') {
                    $if_have_ip = true;
                    break;
                }
            }

            if ($if_have_ip) {
                $database->insert('tealguard', [
                    'value' => $user_ip->get_ip_address(),
                    'type' => 'ip'
                ]);
            }
        }
        return (count($guard_blacklist) != 0);
    }

    public function ip_guard()
    {
        global $database;

        $ip = get_ip_address();
        $additional_sql = '';

        if (count($this->config['config.php']) != 0) {
            foreach ($this->config['config.php'] as $key => $value) {
                $additional_sql .= " AND `$key` = `$value`";
            }
        }

        $ip_guard = $database
            ->query("SELECT TIMESTAMPDIFF(MINUTE,`time`,NOW()) AS LOSSES
                     FROM content WHERE `ip` = '$ip' $additional_sql
                     ORDER BY `time` DESC LIMIT 1;")
            ->fetchAll();

        if (isset($ip_guard[0]['LOSSES'])
            AND ((int)$ip_guard[0]['LOSSES'] < $this->config['GUARD_TICKER'])
        ) {
            return true;
        } else {
            return false;
        }
    }
}