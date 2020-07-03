<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');

$manager = new UserManagerPDO($db->dbConnect(), $session);
$enc = new Encode();

$method = $_server->method('REQUEST_METHOD');

if ($method === 'POST') {
    $email = $_server->post('inputEmailAddress');
    $password = $_server->post('inputPassword');
    if (isset($email) && isset($password)) {
        /** Get User by email */
        $user = $manager->getUniqueEmail((string)$_server->post('inputEmailAddress'));
        if ($user === null || !(in_array($user->role(), User::ROLE_1, true))) {
            echo $twig->render('admin/login.twig', [
                'erreur' => 'Désolé, accès non autorisé',
            ]);
        } else {

            /** Check if the password of user is correct */
            $isPasswordCorrect = password_verify($password, $user->password());

            if ($isPasswordCorrect) {
                /** Create session with info of user is password is correct */
                $session->put('id', $user->id());
                $session->put('email', $user->email());
                header('Location: admin');
                return;
            } else {
                echo $twig->render('admin/login.twig', [
                    'erreur' => 'Désolé, accès non autorisé',
                ]);
            }
        }
    }
} else {
    echo $twig->render('admin/login.twig');
}


