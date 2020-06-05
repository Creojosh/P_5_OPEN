<?php
require_once('../vendor/autoload.php');
require_once('../loader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $response_array = [];
    $mail = new Mail();
    $name = strip_tags(htmlspecialchars($_POST['name']));
    $surname = strip_tags(htmlspecialchars($_POST['surname']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $message = strip_tags(htmlspecialchars($_POST['message']));
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
        echo 'error';
    }
} else {
    echo 'error';
}
