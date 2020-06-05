<?php

$request = $_SERVER['REQUEST_URI'];
$url = '/OC_5_PHP/';
switch ($request) {
    case $url :
    case $url.'index' :
        require __DIR__ . '/controller/index.php';
        break;
    case $url.'blog' :
        require __DIR__ . '/controller/blog.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/controller/error.php';
        break;
}