<?php
/** Autoload class by name */
function autoloadClass($class)
{
    require __DIR__ . '/' .$class . '.php';
}

spl_autoload_register('autoloadClass');


/** Session */
$session = new SessionObject();
$_server = new ServerObject();
$ID_Session = $session->get('id');

/** Twig */
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);
/** Add function for implement asset logic */
$twig->addFunction(new \Twig\TwigFunction('asset', function ($asset) {
    return sprintf('%s', ltrim($asset, '/'));
}));
$twig->addGlobal('session', $ID_Session);

