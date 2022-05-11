<?php
// Use Global Manager
use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Mapping\theuserMapping;

// sections

// articles

// gestionnaire de la table thesection
$thesectionManager = new thesectionManager($connectMyPDO);
// gestionnaire de la table thesection
$thearticleManager = new thearticleManager($connectMyPDO);

// sélection de toutes les sections pour le menu
$thesectionMenu = $thesectionManager->SelectAllThesection();

// blog
if (isset($_GET['blog'])):
    $articles = $thearticleManager->thearticleSelectAll();
    echo $twig->render('public/blog.html.twig', [
        'menu' => $thesectionMenu,
        'articles' => $articles,
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
        ]);
    else:

        // Selection des articles de la section
        $articles = $thearticleManager->thearticleSelectAllFromSection($theSectionDatas['idthesection']);

        // affichage de le section
        echo $twig->render('public/section.html.twig', [
            'menu'     => $thesectionMenu,
            'section'  => $theSectionDatas,
            'articles' => $articles,
        ]);

    endif;

// Détail d'un article
elseif (isset($_GET['article'])):
    /* si slug trouvé, contient un tableau associatif
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
        ]);
    else:

        // Selection des articles de la section
        $articles = $thearticleManager->thearticleSelectAllFromSection($theSectionDatas['idthesection']);

        // affichage de le section
        echo $twig->render('public/section.html.twig', [
            'menu'     => $thesectionMenu,
            'section'  => $theSectionDatas,
            'articles' => $articles,
        ]);

    endif;
*/
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
        'menu' => $thesectionMenu,
    ]);
// homepage
else:
    echo $twig->render('public/homepage.html.twig', [
        'menu' => $thesectionMenu,
    ]);
endif;