<?php
require_once(__DIR__ .'/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');


//$db = new Database();
//
//
//$pass_hache = password_hash('123456', PASSWORD_DEFAULT);
//
//$request = $db->dbConnect()
//    ->prepare
//    ('INSERT INTO user(username, email, password, role, isActive, active_token, create_at)
//VALUES(:username, :email, :password, :role, :isActive, :active_token, :create_at)');
//$request->execute(array(
//        'username' => 'josh',
//        'email' => 'etheve.joshua@gmail.com',
//        'password' => $pass_hache,
//        'role' => 'user',
//        'isActive' => null,
//        'active_token' => null,
//        'create_at' => date("Y-m-d H:i:s")
//    )
//);



echo $twig->render('login/index.twig');
