<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');

$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$session = new SessionObject();
if(!$session->checkUser('id')){
    $session->destroy();
    echo $twig->render('admin/login.twig',[
        'erreur'=> 'Désolé, nous avons rencontrer une erreur',
    ]);
}

if (isset($_POST['inputEmailAddress']) && isset($_POST['inputPassword']))
{
    $user = $manager->getUniqueEmail((string) $_POST['inputEmailAddress']);
    if ($user == null)
    {
        echo $twig->render('admin/login.twig',[
            'erreur'=> 'Désolé, nous avons rencontrer une erreur',
        ]);
    }
    else
    {
        $isPasswordCorrect = false;

        if(isset($_POST['inputPassword'])){
            $isPasswordCorrect = password_verify($_POST['inputPassword'], $user->password());
        }

        if ($isPasswordCorrect) {
            $session->put('id', $user->id());
            $session->put('email', $user->email());
            header('Location: admin');

        }
        else {
            echo $twig->render('admin/login.twig',[
                'erreur'=> 'Désolé, nous avons rencontrer une erreur',
            ]);
            return;
        }
    }
}

if (!(int)$session->get('id')) {
    echo $twig->render('admin/login.twig');
    return;
}else{
    $user = $manager->getUnique((int)$session->get('id'));
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

if (isset($_POST['email']))
{
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = (string) $_POST['email'];
    $user = new User(
        [
            'email' => $email,
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
    'message' => htmlspecialchars((string)$message),
    'erreurs'=> htmlspecialchars((string)$erreurs),
    'user'=>$user,
    'listUser'=> $listUser]);