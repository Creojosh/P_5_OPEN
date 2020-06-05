<?php
require_once('vendor/autoload.php');
require_once('loader.php');

$db = new Database();
$request = $_SERVER['REQUEST_URI'];

echo $twig->render('home/index.twig', ['name' => $request]);
