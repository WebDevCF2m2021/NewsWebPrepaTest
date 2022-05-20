<?php

use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Mapping\thearticleMapping;

$sectionManager = new thesectionManager($connectMyPDO);
$articleManager = new thearticleManager($connectMyPDO);
if (isset($_GET["addArticle"])) {
    if (isset($_POST["thearticletitle"], $_POST["thearticletext"], $_POST["sections"])) {
        $article = new thearticleMapping([
            'thearticletitle' => \NewsWeb\Trait\userEntryProtectionTrait::userEntryProtection($_POST["thearticletitle"]),
            'thearticletext'  => \NewsWeb\Trait\userEntryProtectionTrait::userEntryProtection($_POST["thearticletext"]),
            'thesections'     => $_POST["sections"],
        ], true);
        echo $articleManager->insertArticle($article, $_POST["sections"], $_SESSION);
    }
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