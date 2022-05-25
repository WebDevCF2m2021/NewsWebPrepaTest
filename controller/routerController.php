<?php
// Use Global Manager
use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Manager\theuserManager;
use NewsWeb\Mapping\theuserMapping;

// sections

// articles

// gestionnaire de la table thesection
$thesectionManager = new thesectionManager($connectMyPDO);
// gestionnaire de la table thesection
$thearticleManager = new thearticleManager($connectMyPDO);
// gestionnaire de la table theuser
$theuserManager = new theuserManager($connectMyPDO);
// sélection de toutes les sections pour le menu
$thesectionMenu = $thesectionManager->SelectAllThesection();
// si nous sommes membres, nous devons pouvoir nous déconnecter
if (isset($_GET["disconnect"])) :
    theuserManager::disconnect();
    header("Location: ./");
    die();

// page blog
elseif (isset($_GET['blog'])):
    $articles = $thearticleManager->thearticleSelectAll();
    echo $twig->render('public/blog.html.twig', [
        'menu'     => $thesectionMenu,
        'articles' => $articles,
        'membre'   => $_SESSION,
    ]);

// section
elseif (isset($_GET['section'])):
    // si slug trouvé, contient un tableau associatif
    $theSectionDatas = $thesectionManager->SelectOneThesectionBySlug($_GET['section']);

    // sinon le résultat est un string
    if (is_string($theSectionDatas)):

        // si elle est vide (pas de section ou PROD est à true)
        if (empty($theSectionDatas)) {
            $theSectionDatas = "Rubrique inexistante";
        }

        // appel de l'erreur 404
        echo $twig->render('public/error404.html.twig', [
            'menu'    => $thesectionMenu,
            'message' => $theSectionDatas,
            'membre'  => $_SESSION,
        ]);
    else:

        // Selection des articles de la section
        $articles = $thearticleManager->thearticleSelectAllFromSection($theSectionDatas['idthesection']);

        // affichage de le section
        echo $twig->render('public/section.html.twig', [
            'menu'     => $thesectionMenu,
            'section'  => $theSectionDatas,
            'articles' => $articles,
            'membre'   => $_SESSION,
        ]);

    endif;

// Détail d'un article
elseif (isset($_GET['article'])):
    // si slug trouvé, contient un tableau associatif
    $theArticleDatas = $thearticleManager->thearticleSelectOneBySlug($_GET['article']);
    //var_dump($theArticleDatas);
    // si on reçoit false (pas d'article)
    if (!$theArticleDatas):
        // appel de l'erreur 404
        echo $twig->render('public/error404.html.twig', [
            'menu'    => $thesectionMenu,
            'message' => "Cet article n'existe plus !",
            'membre'  => $_SESSION,
        ]);
    // on a récupéré un article
    else:
        echo $twig->render('public/article.html.twig', [
            'menu'    => $thesectionMenu,
            'article' => $theArticleDatas,
            'membre'  => $_SESSION,
        ]);

    endif;

// Articles par utilisateur    
elseif (isset($_GET['user']) && ctype_digit($_GET['user'])):
    $idUser = (int) $_GET['user'];

    $theArticleDatas = $thearticleManager->thearticleSelectAllByIdUser($idUser);
    $theUserDatas = $theuserManager->theuserSelectOneById($idUser);

    if (!$theArticleDatas):
        echo $twig->render('public/error404.html.twig', [
            'menu'    => $thesectionMenu,
            'message' => "Cet utilisateur n'existe pas !",
            'membre'  => $_SESSION,
        ]);
    else:
        echo $twig->render('public/user.html.twig', [
            'menu' => $thesectionMenu,

            'articles' => $theArticleDatas,

            'utilisateur' => $theUserDatas,

            'membre' => $_SESSION,

        ]);

    endif;

// contact
elseif (isset($_GET['contact'])):
    if (isset($_POST["name"], $_POST["email"], $_POST["message"])) {
        $name    = theuserMapping::userEntryProtection($_POST["name"]);
        $email   = filter_var(theuserMapping::userEntryProtection($_POST["email"]), FILTER_VALIDATE_EMAIL);
        $message = theuserMapping::userEntryProtection($_POST["message"]);
        if (!empty($name) && !empty($email) && !empty($message)) {
            $mailToAdmin->from($email)->subject("Message de l'utilisateur $name")->text($message);
            $mailToCustomer->to($email)->subject("Merci $name pour votre message!")->text("Merci pour votre message sur notre site!
Nous vous répondrons dans les plus bref délai.");
            try {
                $mailer->send($mailToAdmin);
                $mailer->send($mailToCustomer);
            } catch (Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                $twig->addGlobal("name", $name);
                $twig->addGlobal("email", $email);
                $twig->addGlobal("message", $message);
                if (PROD) {
                    echo "<script>alert('Une erreur est survenue! Veuillez réessayer')</script>";
                }
                else {
                    throw new Error($e);
                }
            }
        }
        else {
            $twig->addGlobal("name", $name);
            $twig->addGlobal("email", $email);
            $twig->addGlobal("message", $message);
        }
    }
    echo $twig->render('public/contact.html.twig', [
        'menu'   => $thesectionMenu,
        'membre' => $_SESSION,
    ]);
elseif (isset($_GET['connect']) && !isset($_SESSION["idSession"])):

    if (isset($_POST["theuserlogin"], $_POST["theuserpwd"])) {
        $instanceTheuser = new theuserMapping($_POST);

        if ($theuserManager->theuserConnectByLoginAndPwd($instanceTheuser)) {
            header("Location: ./");
        }
        else {
            echo $twig->render("public/connexion.html.twig", [
                'menu'   => $thesectionMenu,
                "error"  => "Wrong Login or Password!",
                'membre' => $_SESSION,
            ]);
        }
    }
    else {
        echo $twig->render("public/connexion.html.twig", ['menu' => $thesectionMenu, 'membre' => $_SESSION,]);
    }
else:
    $lastArticles = $thearticleManager->thearticleSelectAll(3, 0);
    echo $twig->render('public/homepage.html.twig', [
        'menu'         => $thesectionMenu,
        "lastArticles" => $lastArticles,
        'membre'       => $_SESSION,
    ]);
endif;