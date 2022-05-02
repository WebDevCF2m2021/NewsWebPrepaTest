<?php
// blog
if(isset($_GET['blog'])):
    echo $twig->render('public/blog.html.twig');

// contact
elseif(isset($_GET['contact'])):

    echo $twig->render('public/contact.html.twig');
// homepage
else:
    echo $twig->render('public/homepage.html.twig');
endif;