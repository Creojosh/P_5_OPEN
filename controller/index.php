<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');


echo $twig->render('home/index.twig', ['name' => '']);
