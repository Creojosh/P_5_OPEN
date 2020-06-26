<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');

$method = $_server->method('REQUEST_METHOD');

if ($method === 'POST') {

    $enc = new Encode();

    $mail = new Mail();
    $name = $enc->encoder($_server->post('name'));
    $surname = $enc->encoder($_server->post('surname'));
    $email = $enc->encoder($_server->post('email'));
    $message = $enc->encoder($_server->post('message'));

    try {
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername($mail->getUsername())
            ->setPassword($mail->getPassword());

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Nouveau Message'))
            ->setFrom([$email => $name . ' ' . $surname])
            ->setTo([$mail->getFrom() => 'Admin'])
            ->setBody($message);

        $result = $mailer->send($message);
        if ($result)
            echo 'success';
        else
            echo 'error';
    } catch (Exception $e) {
        http_response_code(500);
        echo 'error';
    }
} else {
    http_response_code(500);
    echo 'error';
}
