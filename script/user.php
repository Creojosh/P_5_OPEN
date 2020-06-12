<?php
require_once('../vendor/autoload.php');
require_once('../loader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user = new UserAction();
    switch ($_GET['action']) {
        case 'register' :
            echo $user->createUser($_POST['inputUsername'], $_POST['inputEmail'], $_POST['inputPassword']);
            break;
        default:
            http_response_code(404);
            break;
    }

} else {
    http_response_code(500);
    echo 'error';
}
