<?php

$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$session = new SessionObject();
if ((int)$session->get('id')) {
    $user = $manager->getUnique((int)$session->get('id'));
    if ($user->role() === 'admin'){
        echo $twig->render('admin/index.twig');
        return;
    }else{
        header('Location: login');
        return;
    }
}else{
    header('Location: login');
    return;
}