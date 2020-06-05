<?php

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = strip_tags(htmlspecialchars($_POST['name']));
    $surname = strip_tags(htmlspecialchars($_POST['surname']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $message = strip_tags(htmlspecialchars($_POST['message']));
    if (isset($email))
        $response_array['status'] = 'error';

    try {
        $transport = (new Swift_SmtpTransport('smtp.example.org', 25))
            ->setUsername('your username')
            ->setPassword('your password');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['etheve.joshua@gmail.com' => 'ETHEVE Joshua'])
            ->setTo(['etheve.joshua@gmail.com' => 'ETHEVE Joshua'])
            ->setBody('Here is the message');

        $result = $mailer->send($message);
        $response_array['status'] = 'success';
    } catch (Exception $e) {
        $response_array['status'] = 'error';
    }
} else {
    $response_array['status'] = 'error';
}
