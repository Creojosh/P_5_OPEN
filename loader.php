<?php
/** Autoload class by name */
function autoloadClass($class)
{
    require 'class/'.$class . '.php';
}

spl_autoload_register('autoloadClass');

$loader = new \Twig\Loader\FilesystemLoader('./templates');
$twig = new \Twig\Environment($loader);
/** Add function for implement asset logic */
$twig->addFunction(new \Twig\TwigFunction('asset', function ($asset) {
    return sprintf('%s', ltrim($asset, '/'));
}));
