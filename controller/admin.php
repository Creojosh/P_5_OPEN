<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');
require_once(__DIR__ . '/../lib/userConnect.php');

$listUser  = null;
$listUser = $manager->getList();

echo $twig->render('admin/index.twig', [
    'listUser'=> $listUser]);
