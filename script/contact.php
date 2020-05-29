<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $mail = new PHPMailer(true);

    $name = strip_tags(htmlspecialchars($_POST['name']));
    $surname = strip_tags(htmlspecialchars($_POST['surname']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $message = strip_tags(htmlspecialchars($_POST['message']));
    if(isset($email))
        $response_array['status'] = 'error';

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp1.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'user@example.com';
        $mail->Password = 'secret';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('etheve.joshua@gmail.com', 'Josh');
        $mail->addAddress($email, 'Joe User');


        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau message';
        $mail->Body = $message;

        $mail->send();
        $response_array['status'] = 'success';
    } catch (Exception $e) {
        $response_array['status'] = 'error';
    }
} else {
    $response_array['status'] = 'error';
}
