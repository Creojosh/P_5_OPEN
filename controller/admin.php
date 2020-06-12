<?php
session_start();

require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require '../entity/User.php';
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['id']))
{
    $user = $manager->getUniqueEmail((string) $_POST['inputEmailAddress']);
    if ($user == null)
    {
        echo $twig->render('admin/login.twig',[
            'erreur'=> 'Désolé, nous avons rencontrer une erreur',
        ]);
        exit();
    }
    else
    {
        $isPasswordCorrect = password_verify($_POST['inputPassword'], $user->password());

        if ($isPasswordCorrect) {
            $_SESSION['id'] = $user->id();
            $_SESSION['email'] = $user->email();
            header('Location: admin');

        }
        else {
            echo $twig->render('admin/login.twig',[
                'erreur'=> 'Désolé, nous avons rencontrer une erreure',
            ]);
            exit();
        }
    }
}

if (!isset($_SESSION['id'])) {
    echo $twig->render('admin/login.twig');
    return;
}else{
    $user = $manager->getUnique((int)$_SESSION['id']);
    if ($user->role() != 'admin'){
        echo $twig->render('admin/login.twig',[
            'erreur'=> 'Désolé, accès non autorisé',
        ]);
        return;
    }
}


$message = null;
$erreurs  = null;
$user  = null;
$listUser  = null;


$listUser = $manager->getList();

if (isset($_GET['modifier']))
{
    $user = $manager->getUnique((int) $_GET['modifier']);
}

if (isset($_GET['supprimer']))
{
    $manager->delete((int) $_GET['supprimer']);
    $message = 'User a bien été supprimée !';
}

if (isset($_POST['username']))
{
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user = new User(
        [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $pass_hache,
            'role' => 'user',

        ]
    );

    if (isset($_POST['id']))
    {
        $user->setId($_POST['id']);
    }

    if ($user->isValid())
    {
        $manager->save($user);

        $message = $user->isNew() ? 'User a bien été ajoutée !' : 'User a bien été modifiée !';
    }
    else
    {
        $erreurs = $user->erreurs();
    }
}

echo $twig->render('admin/index.twig', [
    'message' => $message,
    'erreurs'=> $erreurs,
    'user'=>$user,
    'listUser'=> $listUser]);
