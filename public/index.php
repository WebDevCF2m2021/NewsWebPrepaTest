<?php
// use NewsWeb MyPDO class
use NewsWeb\MyPDO;

// dependencies
require_once "../config.php";

// Composer autoload
require_once '../vendor/autoload.php';

// Twig loader
$loader = new \Twig\Loader\FilesystemLoader('../view');
$twig = new \Twig\Environment($loader, [
    //'cache' => '../view/cache',
]);

// Personnal autoload
spl_autoload_register(function ($class) {
    include_once '../model/' . $class . '.php';
});

// connect with MyPDO
try {
    $connectMyPDO = new MyPDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET . ';port=' . DB_PORT, DB_LOGIN, DB_PWD, null, PROD);
} catch (Exception $e) {
    die($e->getMessage());
}

// Call the router
require_once "../controller/routerController.php";

// close connection
$connectMyPDO = null;