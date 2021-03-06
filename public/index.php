<?php

$req = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
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
            require __DIR__ . '/../controller/login.php';
            break;
        case $url . 'user' :
            require __DIR__ . '/../controller/user.php';
            break;
        case $url . 'post' :
            require __DIR__ . '/../controller/post.php';
            break;
        case $url . 'adminAdvance' :
            require __DIR__ . '/../controller/userAdvance.php';
            break;
        case $url . 'postAdvance' :
            require __DIR__ . '/../controller/postAdvance.php';
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
    $id = filter_input(INPUT_GET, 'id');
    $action = filter_input(INPUT_GET, 'action');
    if(isset($id) && isset($action)){
        switch ($req) {
            case $url . 'userAdvance?action=' .$action .'&id='.$id:
                require __DIR__ . '/../controller/userAdvance.php';
                break;
            case $url . 'postAdvance?action=' .$action .'&id='.$id:
                require __DIR__ . '/../controller/postAdvance.php';
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


