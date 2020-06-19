<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());

$error = null;
$message = null;
if (isset($_POST['inputEmail'])) {
    if ($_POST['inputPassword'] != $_POST['inputConfirm']) {
        $error = 'Désolé, le mot de passe ne correspond pas';
    } else if(isset($_POST['inputPassword']) && isset($_POST['inputEmail'])) {
        $pass_hache = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);
        $user = new User(
            [
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
