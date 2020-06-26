<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../entity/User.php');
require_once(__DIR__ . '/../lib/UserConnect.php');

$method = $_server->method('REQUEST_METHOD');

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
                $user = $manager->getUnique((int)$id);
                break;
            case 'supprimer':
                /** To avoid deleting yourself */
                if ($session_user->id() != (int)$id) {
                    $manager->delete((int)$id);
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
    if (isset($email, $newPassword) && in_array($role, User::ROLE_0, true)) {
        $pass_hache = password_hash($newPassword, PASSWORD_DEFAULT);
        $email = (string)$email;
        $userRole = '';
        $user = $manager->getUniqueEmail((string)$email);
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
                $manager->save($user);
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
