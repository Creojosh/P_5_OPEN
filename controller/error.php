<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');


echo $twig->render('error/index.twig', ['error' =>  http_response_code()]);
