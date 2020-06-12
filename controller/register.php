<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require '../entity/User.php';
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());

$error = null;
$message = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['inputPassword'] != $_POST['inputConfirm']) {
        $error = 'Désolé, le mot de passe ne correspond pas';
    } else {
        $pass_hache = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
        $user = new User(
            [
                'username' => $_POST['inputUsername'],
                'email' => $_POST['inputEmail'],
                'password' => $pass_hache,
                'role' => 'user',
            ]
        );

        if ($user->isValid()) {
            $checkMail = $manager->getUniqueEmail((string) $_POST['inputEmail']);
            if ($checkMail == null)
            {
                $manager->save($user);
                $message = 'Votre compte a bien été ajoutée !';
            }
            else
            {
                $error = 'Désolé, nous avons rencontrer une erreur';
            }

        } else {
            $error = 'Désolé, nous avons rencontrer une erreur';
        }
    }
}

echo $twig->render('register/index.twig', ['message' => $message, 'error' => $error]);
