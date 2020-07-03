<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../lib/UserManagerPDO.php');
require_once(__DIR__ . '/../entity/User.php');

$method = $_server->method('REQUEST_METHOD');
$userManager = new UserManagerPDO($db->dbConnect(), $session);
$session_user = $userManager->userIsConnect();

$encoder = new Encode();
$message = null;
$errors = null;
$listRoles = User::ROLE_0;
if ($method === 'GET') {
    $user = null;
    $action = $_server->get('action');
    $id = $_server->get('id');

    if (isset($action, $id) && in_array($session_user->role(), User::ROLE_2, true)) {
        switch ($action) {
            case 'modifier':
                $user = $userManager->getUnique((int)$id);
                break;
            case 'supprimer':
                /** To avoid deleting yourself */
                if ($session_user->id() != (int)$id) {
                    $userManager->delete((int)$id);
                    header('Location: admin');
                    return;
                }
                break;
            default:
                $user = null;
                break;
        }
    }
}
if ($method === 'POST' && in_array($session_user->role(), User::ROLE_2, true)) {
    $email = $_server->post('inputEmail');
    $role = $_server->post('selectRole');
    $newPassword = $_server->post('newPassword');

    /** Remove all illegal characters from email */
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && isset($newPassword) && in_array($role, User::ROLE_0, true)) {
        $pass_hache = password_hash($newPassword, PASSWORD_DEFAULT);
        $email = (string)$email;
        $userRole = '';
        $user = $userManager->getUniqueEmail((string)$email);
        if ($user instanceof User)
            $userRole = $user->role();

        if (!(in_array($userRole, User::ROLE_2, true))) {
            if (!($user instanceof User)) {
                $user = new User(
                    [
                        'email' => $email,
                        'password' => $pass_hache,
                    ]
                );
            }
            if ($user->isValid()) {
                /** To avoid lose his role */
                if ($user->isNew() || $session_user->id() != $user->id()) {
                    $user->setRole($role);
                }
                $userManager->save($user);
                $message = $user->isNew() ? 'User a bien été ajoutée !' : 'User a bien été modifiée !';
            } else {
                $errors = $user->erreurs();
            }
        } else {
            $message = "Impossible de modifier un SUPER ADMIN";
        }
    }
}

echo $twig->render('admin/form.twig', [
    'message' => $message,
    'errors' => $errors,
    'user' => $user,
    'listRoles' => $listRoles
]);
