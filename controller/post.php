<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../lib/UserManagerPDO.php');
require_once(__DIR__ . '/../entity/User.php');
require_once(__DIR__ . '/../entity/Post.php');

$userManager = new UserManagerPDO($db->dbConnect(), $session);
$session_user = $userManager->userIsConnect();

$postManager = new PostManagerPDO($db->dbConnect());
$listPost  = null;
$listPost = $postManager->getList();

echo $twig->render('post/index.twig', [
    'listPost'=> $listPost
]);
