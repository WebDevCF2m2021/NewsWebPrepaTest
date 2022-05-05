<?php

use NewsWeb\Mapping\theuserMapping;
// blog
if (isset($_GET['blog'])):
    echo $twig->render('public/blog.html.twig');

// contact
elseif (isset($_GET['contact'])):
    if (isset($_POST["name"], $_POST["email"], $_POST["message"])) {
        $name    = theuserMapping::userEntryProtection($_POST["name"]);
        $email   = theuserMapping::userEntryProtection($_POST["email"]);
        $message = theuserMapping::userEntryProtection($_POST["message"]);
        if (!empty($name) && !empty($email) && !empty($message)) {
            $mailToAdmin->from($email)->subject("Message de l'utilisateur $name")->text($message);
            $mailToCustomer->to($email)->subject("Merci $name pour votre message!")->text("Merci pour votre message sur notre site!
Nous vous répondrons dans les plus bref délai.");
            try {
                $mailer->send($mailToAdmin);
                $mailer->send($mailToCustomer);
            } catch (Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                if (!PROD) {
                    echo "<script>alert('Une erreur est survenue! Veuillez réessayer')</script>";
                }
                else {
                    throw new Error($e);
                }
            }
        }
    }
    if (isset($name, $email, $message)) {
        $twig->addGlobal("name", $name);
        $twig->addGlobal("email", $email);
        $twig->addGlobal("message", $message);
    }
    echo $twig->render('public/contact.html.twig');
// homepage
else:
    echo $twig->render('public/homepage.html.twig');
endif;