<?php
// dependencies
require_once "../config.php";

// Composer autoload
require_once '../vendor/autoload.php';

// Twig loader
$loader = new \Twig\Loader\FilesystemLoader('../view');
$twig = new \Twig\Environment($loader, [
    //'cache' => '../view/cache',
]);

// test render Twig
echo $twig->render('public/public.template.html.twig');