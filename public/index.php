<?php
session_start();

// use NewsWeb MyPDO class
use NewsWeb\MyPDO;
// use composer dependencies
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\String\StringExtension;
use Twig\Loader\FilesystemLoader;

// Symfony mailer namespaces

// Twig namespaces

// Twig string extension

// dependencies
require_once "../config.php";


// Composer autoload
require_once '../vendor/autoload.php';

// Twig loader
$loader = new FilesystemLoader('../view');
$twig   = new Environment($loader, [
    //'cache' => '../view/cache',
    // utilisation du débogage: dump()
    'debug' => true,
]);
// activation du débogage (dump())
$twig->addExtension(new DebugExtension());
// activation de l'extension u. (traitement du texte)
$twig->addExtension(new StringExtension());

//instanciation de mailer avec ce que retourne la fonction fromDsn de la class Transport avec la constante
//SMTP définie dans le config
$mailer = new Mailer(Transport::fromDsn('smtp://' . SMTP . ":" . SMTP_PORT));
//instanciation de la classe Email pour l'admin
$mailToAdmin    = (new Email())->to(ADMIN_MAIL);
$mailToCustomer = (new Email())->from(ADMIN_MAIL);

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../model/' . str_replace('\\', '/', $class) . '.php';
});

// connect with MyPDO
try {
    $connectMyPDO = new MyPDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET . ';port=' . DB_PORT, DB_LOGIN, DB_PWD, null, PROD);
} catch (Exception $e) {
    die($e->getMessage());
}

// Call the router
// Si on est connecté
if (isset($_SESSION["idSession"]) && $_SESSION["idSession"] === session_id()) {
    // Si nous sommes un simple utilisateur, nous restons sur la partie publique du site, mais avec la permission d'écrire des commentaires
    if ($_SESSION['permissionRole'] == 2) {

        require_once "../controller/routerController.php";
        // nous sommes admin ou rédacteurs
    }
    else {
        // Nous allons sur l'administration
        require_once "../controller/private/privateRouterController.php";
    }
} // Si nous ne sommes pas connectés
else {
    require_once "../controller/routerController.php";
}
// close connection (portabilité hors MySQL, mettre en commentaire en cas de connexion permanente)
$connectMyPDO = null;