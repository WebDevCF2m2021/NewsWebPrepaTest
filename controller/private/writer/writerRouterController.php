<?php

if ($_GET) {
    echo $twig->render("private/articleForm.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
    ]);
}
else {
    echo $twig->render("private/homepage.template.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
    ]);
}