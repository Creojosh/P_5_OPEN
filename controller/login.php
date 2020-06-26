<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');

$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$enc = new Encode();

$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'POST') {
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
    if (isset($email) && isset($password)) {
        /** Get User by email */
        $user = $manager->getUniqueEmail((string)$enc->encoder($_POST['inputEmailAddress']));
        $role = array("admin", "super_admin");
        if ($user === null || !(in_array($user->role(), $role, true))) {
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


