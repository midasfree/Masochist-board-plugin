<?php

    class ColorfulMonkey
    {
        private $config;

        function __construct()
        {
            global $plugin;

            $this->config = $plugin->config["lark.colorful.monkey"];
        }

        public function color_select($author)
        {
            $color_base =
            [
                'c62828',
                'ad1457',
                '6a1b9a',
                '4527a0',
                '283593',
                '1565c0',
                '0277bd',
                '00838f',
                '00695c',
                '2e7d32',
                '558b2f',
                '9e9d24',
                'f9a825',
                'ff8f00',
                'ef6c00'
            ];
            $md5_author = md5(substr($author, 1));
            $color_num =
                (int)substr(base_convert($md5_author[1], 36, 15), 0, 1);
            $color_author = $color_base[$color_num];

            return $color_author;
        }


        public function color_change($data)
        {
            $result_data = [];

            foreach ($data as $result)
            {
                $author = $result['author'];
                if ($author[0] == '$')
                {
                    $real_author = substr($author, 1);
                    $color = $this->color_select($author);
                    $result['author'] =
                    "<span style='color:#$color'>$real_author</span>";
                }
                elseif ($author == 'Admin')
                {
                    $result['author'] =
                    "<span style='color:#c62828'>Admin</span>";
                }
                array_push($result_data, $result);
            }

            $data = $result_data;

            return $data;
        }
    }
