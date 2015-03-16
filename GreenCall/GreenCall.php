<?php
    class GreenCall
    {
        public $config;

        function __construct()
        {
            global $plugin;
            $this->config = $plugin->config['lark.green.call'];
        }
        
        public function call_post($target_id)
        {
            global $database;
            $data_sql = 
            [
                'id',
                'author',
                'content'
            ];
            $where_sql =
            [
                'id[=]'   =>  $target_id
            ];
            $data = $database->select('content', $data_sql, $where_sql);
            
            for ($i = 0; $i < count($data); $i++)
            {
                $data[$i]['content'] =
                    $emotion->phrase(RemoveXSS($Parsedown->text($data[$i]['content'])));
            }

            return $data;
        }
    }
