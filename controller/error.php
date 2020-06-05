<?php
require_once('vendor/autoload.php');
require_once('loader.php');


echo $twig->render('error/index.twig', ['error' =>  http_response_code()]);
