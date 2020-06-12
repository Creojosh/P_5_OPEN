<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../loader.php');

echo $twig->render('home/index.twig', ['name' => '']);
