<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');

$db = new Database();

echo $twig->render('blog/index.twig', ['name' => $db->dbConnect()]);
