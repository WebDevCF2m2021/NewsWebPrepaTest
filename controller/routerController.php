<?php
// blog
if(isset($_GET['blog'])):
    echo $twig->render('public/blog.html.twig');

// contact
elseif(isset($_GET['contact'])):
    if(isset($_POST["name"],$_POST["email"], $_POST["message"])){
       $name =  userEntryProtection($_POST["name"]);
       $email =  userEntryProtection($_POST["email"]);
       $message =  userEntryProtection($_POST["message"]);
       if(!empty($name)&&!empty($email)&&!empty($message)){
            $mailToAdmin->from($email)->subject("Message de l'utilisateur $name")->text($message);
            $mailToCustomer->to($email)->subject("Merci $name pour votre message!")->text("Merci pour votre message sur notre site!
Nous vous répondrons dans les plus bref délai.");
            $mailer->send($mailToAdmin);
            $mailer->send($mailToCustomer);
       }
    }
    echo $twig->render('public/contact.html.twig');
// homepage
else:
    echo $twig->render('public/homepage.html.twig');
endif;