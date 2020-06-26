<?php
$db = new DBFactory();
$manager = new UserManagerPDO($db->dbConnect());
$session = new SessionObject();
$role = array("admin", "super_admin");
$ID_Session = $session->get('id');
if (isset($ID_Session)) {
    $user = $manager->getUnique($ID_Session);
    if (!(in_array($user->role(), $role, true))) {
        header('Location: login');
        return;
    }
}else{
    header('Location: login');
    return;
}
