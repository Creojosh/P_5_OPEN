<?php

$req = $_SERVER['REQUEST_URI'];
$req_param = strtok($req, '?');
$url = '/OC_5_PHP/public/';
if ($req == $req_param) {
    switch ($req) {
        case $url :
        case $url . 'index' :
            require __DIR__ . '/../controller/index.php';
            break;
        case $url . 'blog' :
            require __DIR__ . '/../controller/blog.php';
            break;
        case $url . 'register' :
            require __DIR__ . '/../controller/register.php';
            break;
        case $url . 'login' :
        case $url . 'admin' :
            require __DIR__ . '/../controller/admin.php';
            break;
        case $url . 'logout' :
            require __DIR__ . '/../controller/logout.php';
            break;
        case $url . 'contact' :
            require __DIR__ . '/../script/contact.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/../controller/error.php';
            break;
    }
} else {
    if(isset($_GET['id']) && isset($_GET['action'])){
        $id = (int) $_GET['id'];
        $action = (string) $_GET['action'];
        switch ($req) {
            case $url . 'admin?action=' .$action .'&id='.$id:
                require __DIR__ . '/../controller/admin.php';
                break;
            default:
                http_response_code(404);
                require __DIR__ . '/../controller/error.php';
                break;
        }
    }else{
        http_response_code(404);
        require __DIR__ . '/../controller/error.php';
    }

}


