<?php

/**
 * Created by PhpStorm.
 * User: Don
 * Date: 3/4/2015
 * Time: 6:06 PM
 */
class AmnesicSession
{
    private $database;

    public function open($sessionSavePath, $sessionName)
    {
        global $plugin;
        $this->database = new medoo
        (
            [
                'database_type' => 'mysql',
                'database_name' => DB_NAME,
                'server' => DB_HOST,
                'username' => DB_USER,
                'password' => DB_PASSWORD,
                'port' => DB_PORT,
                'charset' => 'utf8',
                'option' => [PDO::ATTR_CASE => PDO::CASE_NATURAL]
            ]
        );

        $amnesic_session = $this
            ->database
            ->query("CREATE TABLE IF NOT EXISTS `amnesicsession` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `session_id` MEDIUMTEXT NULL,
                    `session_content` MEDIUMTEXT NULL,
                    `action_time` MEDIUMTEXT NULL,
                    PRIMARY KEY (`id`));")
            ->fetchAll();

        $this->config = $plugin->config['losses.amnesic.session'];

        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($session_id)
    {
        global $database;

        $session_content = NULL;
        $session_id = trim($session_id);

        $data = $this->database->select('amnesicsession', '*', [
            'session_id' => $session_id
        ]);

        if (isset($data[0]))
            $session_content = $data[0]['session_content'];

        return $session_content;
    }

    public function write($session_id, $session_content)
    {
        global $database;
        global $current_time;

        $data = false;
        $session_id = trim($session_id);
        $session_content = trim($session_content);

        $sql_action = [
            'session_id' => $session_id,
            'session_content' => $session_content,
            'action_time' => $current_time
        ];
        if (!empty($session_content)) {
            $session_record = $this->database->select('amnesicsession', 'id', [
                'session_id' => $session_id
            ]);
            if (isset($session_record[0])) {
                $data = $this->database->update('amnesicsession', [
                    'session_id' => $session_id
                ], $sql_action);
            } else {
                $data = $this->database->insert('amnesicsession', $sql_action);
            }
        }
        return $data;
    }

    public function destroy($session_id)
    {
        global $database;

        $result = $this->database->delete('amnesicsession', [
            'session_id' => $session_id
        ]);

        return $result;
    }

    public function gc($max_lifetime)
    {
        global $database;
        global $current_time;

        $result = false;
        $expire_time = $current_time - $max_lifetime;

        $result = $this->database->delete('amnesicsession', [
            'action_time[<]' => $expire_time
        ]);

        return $result;
    }
}