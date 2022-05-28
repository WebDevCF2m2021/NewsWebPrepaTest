<?php

// système d'upload d'images
/*
 * https://packagist.org/packages/verot/class.upload.php
 * https://github.com/verot/class.upload.php/blob/master/README.md
 * https://www.verot.net/php_class_upload_samples.htm
 */

use Verot\Upload\Upload;
use NewsWeb\Manager\theuserManager;

if (isset($_GET["disconnect"]) || $_SESSION["idSession"] !== session_id()) {
    theuserManager::disconnect();
    header("Location: ./");
    die();
} else {
    if ($_SESSION["permissionRole"] === "1") {
        require_once "../controller/private/writer/writerRouterController.php";
    } else {
        echo $twig->render("private/homepage.template.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session' => $_SESSION,
        ]);
    }
}