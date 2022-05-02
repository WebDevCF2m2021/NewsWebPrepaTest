c<?php

if(isset($_GET['blog'])){
    echo $twig->render('public/blog.html.twig');
}elseif(isset($_GET['contact'])){
    echo $twig->render('public/contact.html.twig');
}else{
    echo $twig->render('public/homepage.html.twig');
}