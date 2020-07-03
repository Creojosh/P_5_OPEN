<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../lib/UserManagerPDO.php');
require_once(__DIR__ . '/../entity/User.php');

$userManager = new UserManagerPDO($db->dbConnect(), $session);
$session_user = $userManager->userIsConnect();
$listUser  = null;
$listUser = $userManager->getList();

echo $twig->render('admin/index.twig', [
    'listUser'=> $listUser
]);
