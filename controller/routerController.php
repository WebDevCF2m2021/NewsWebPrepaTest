<?php

if(isset($_GET['blog'])):
    echo $twig->render('public/blog.html.twig');
//elseif():

else:
    echo $twig->render('public/homepage.html.twig');
endif;