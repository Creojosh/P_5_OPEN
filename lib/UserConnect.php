<?php
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
if (isset($ID_Session)) {
    $user = $manager->getUnique($ID_Session);
    if (!(in_array($user->role(), $ROLE_2, true))) {
        header('Location: login');
        return;
    }
}else{
    header('Location: login');
    return;
}
