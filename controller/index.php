<?php
require_once('vendor/autoload.php');
require_once('loader.php');

echo $twig->render('home/index.twig', ['name' => '']);
