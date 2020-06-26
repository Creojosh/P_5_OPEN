<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$method = $_server->method('REQUEST_METHOD');
$error = null;
$message = null;
if ($method === 'POST') {
    $email = $_server->post('inputEmail');
    $password = $_server->post('inputPassword');
    $password_confirm = $_server->post('inputConfirm');
    if (isset($email, $password, $password_confirm)) {
        if ($password !== $password_confirm) {
            $error = 'Désolé, le mot de passe ne correspond pas';
        } else {
            $pass_hache = password_hash($password, PASSWORD_DEFAULT);
            $user = new User(
                [
                    'email' => $email,
                    'password' => $pass_hache,
                    'role' => 'user',
                ]
            );

            if ($user->isValid()) {
                $checkMail = $manager->getUniqueEmail((string)$email);
                if ($checkMail == null) {
                    $manager->save($user);
                    $message = 'Votre compte a bien été ajoutée !';
                } else {
                    $error = 'Désolé, nous avons rencontrer une erreur';
                }

            } else {
                $error = 'Désolé, nous avons rencontrer une erreur';
            }
        }
    }

}


echo $twig->render('register/index.twig', ['message' => $message, 'error' => $error]);
