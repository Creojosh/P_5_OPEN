<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');


session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();


header('Location: index');
