<?php

use NewsWeb\Manager\thesectionManager;

$sectionManager = new thesectionManager($connectMyPDO);
if (isset($_GET["addArticle"])) {
    echo $twig->render("private/articleForm.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        "sections" => $sectionManager->SelectAllThesection(),
    ]);
}
else {
    echo $twig->render("private/homepage.template.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
    ]);
}