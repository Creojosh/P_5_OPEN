<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');

$session = new SessionObject();

$session->destroy();

header('Location: index');
