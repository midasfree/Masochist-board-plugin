<?php
/**
 * Created by PhpStorm.
 * User: Don
 * Date: 3/5/2015
 * Time: 12:08 PM
 */

global $plugin;

if (isset($_POST['get_cookie'])) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $plugin->config['losses.friendly.cookies.businessman']['secret_key'],
        'response' => $_POST['g-recaptcha-response']
    ];

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $result = json_decode(file_get_contents($url, false, $context));

    if ($result['success'] == true) {
        $sweet_cookie_location = $plugin->config['losses.sweet.cookie']['dir_location'] . '\SweetCookie.php';
        if (!is_file($sweet_cookie_location))
            response_message(403, 'please install SweetCookie first');

        require($sweet_cookie_location);
        $sweet_cookie = new SweetCookie();

        $cookie = $sweet_cookie->generate_cookie();

        if ($cookie) {
            response_message(200, "You got a cookie named $cookie");
        } else {
            response_message(403, "Generating failed");
        }
    }

    exit();
}

global $file;

$return = [
    'site_key' => $plugin->config['losses.friendly.cookies.businessman']['site_key'],
    'self-vending_machines' => $plugin->config['losses.friendly.cookies.businessman']['self-vending_machines'],
    'location' => $file
];

echo(json_encode($return));
exit();