<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../lib/loader.php');
require_once(__DIR__ . '/../lib/UserManagerPDO.php');
require_once(__DIR__ . '/../entity/User.php');
require_once(__DIR__ . '/../entity/Post.php');

$method = $_server->method('REQUEST_METHOD');
$userManager = new UserManagerPDO($db->dbConnect(), $session);
$session_user = $userManager->userIsConnect();

$postManager = new PostManagerPDO($db->dbConnect());

$encoder = new Encode();
$message = null;
$errors = null;
$post = null;

if ($method === 'GET') {
    $action = $_server->get('action');
    $id = $_server->get('id');

    if (isset($action, $id) && in_array($session_user->role(), User::ROLE_1, true)) {
        switch ($action) {
            case 'modifier':
                $post = $postManager->getUnique((int)$id);
                break;
            case 'supprimer':
                /** To avoid deleting yourself */
                $postManager->delete((int)$id);
                header('Location: post');
                return;
                break;
            default:
                $post = null;
                break;
        }
    }
}
if ($method === 'POST' && in_array($session_user->role(), User::ROLE_1, true)) {
    $id = $_server->post('id');
    $title = $encoder->encoder($_server->post('inputTitle'));
    $chapo = $encoder->encoder($_server->post('inputChapo'));
    $content = $encoder->encoder($_server->post('inputContent'));
    $post = $postManager->getUnique($id);
    if (!($post instanceof Post)) {
        $date = new DateTime();
        $post = new Post(
            [
                'title' => $title,
                'chapo' => $chapo,
                'content' => $content,
                'userid' => $session_user->id(),
                'updateat' => $date,
                'createat' => $date,
            ]
        );
    }else{
        $post->setTitle($title);
        $post->setChapo($chapo);
        $post->setContent($content);
    }

    if ($post->isValid()) {

        $postManager->save($post);
        $message = $post->isNew() ? 'Post a bien été ajoutée !' : 'Post a bien été modifiée !';
    } else {
        $errors = $post->erreurs();
    }
}

echo $twig->render('post/form.twig', [
    'message' => $message,
    'errors' => $errors,
    'post' => $post,
]);
