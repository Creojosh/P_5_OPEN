<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');

$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$session = new SessionObject();
$enc = new Encode();

if (isset($_POST['inputEmailAddress']) && isset($_POST['inputPassword'])) {
    $user = $manager->getUniqueEmail((string) $enc->encoder($_POST['inputEmailAddress']));
    if ($user == null) {
        echo $twig->render('admin/login.twig',[
            'erreur'=> 'Désolé, accès non autorisé',
        ]);
        exit();
    } else {
        $isPasswordCorrect = false;

        if (isset($_POST['inputPassword'])) {
            $isPasswordCorrect = password_verify($_POST['inputPassword'], $user->password());
        }

        if ($isPasswordCorrect) {
            $session->put('id', $user->id());
            $session->put('email', $user->email());
            header('Location: admin');
            return;
        } else {
            echo $twig->render('admin/login.twig',[
                'erreur'=> 'Désolé, accès non autorisé',
            ]);
            exit();
        }
    }
} else {
    echo $twig->render('admin/login.twig');
}

