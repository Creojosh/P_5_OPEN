<?php
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$session_user = null;
if (isset($ID_Session)) {
    $session_user = $manager->getUnique($ID_Session);
    if (!(in_array($session_user->role(), User::ROLE_1, true))) {
        header('Location: login');
        return;
    }
}else{
    header('Location: login');
    return;
}
