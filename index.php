<?php
require_once('vendor/autoload.php');
require_once('loader.php');

$db = new Database();

echo $twig->render('home/index.twig', ['name' => $db->dbConnect()]);
