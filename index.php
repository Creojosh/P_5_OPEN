<?php
require_once('vendor/autoload.php');
require_once('twig.php');

$db = new Database();

echo $twig->render('home/index.twig', ['name' => $db->dbConnect()]);
