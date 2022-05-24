<?php

use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thecommentManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Mapping\thearticleMapping;
use NewsWeb\Trait\userEntryProtectionTrait;

$sectionManager = new thesectionManager($connectMyPDO);
$articleManager = new thearticleManager($connectMyPDO);
$commentManager = new thecommentManager($connectMyPDO);
if (isset($_GET["addArticle"])) {
    if (isset($_POST["thearticletitle"], $_POST["thearticletext"], $_POST["sections"])) {
        $article = new thearticleMapping([
            'thearticletitle' => userEntryProtectionTrait::userEntryProtection($_POST["thearticletitle"]),
            'thearticletext'  => userEntryProtectionTrait::userEntryProtection($_POST["thearticletext"]),
            'thesections'     => $_POST["sections"],
        ], true);
        $articleManager->insertArticle($article, $_POST["sections"], $_SESSION);
        header("Location: ./?viewArticles");
    }
    echo $twig->render("private/articleForm.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        "sections" => $sectionManager->SelectAllThesection(),
    ]);
}
elseif (isset($_GET["viewArticles"])) {
    $articles = $articleManager->thearticleAdminSelectAll($_SESSION);
    echo $twig->render("private/articlesList.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        'articles' => $articles,
    ]);
}
elseif (isset($_GET["article"])) {
    $slug     = userEntryProtectionTrait::userEntryProtection($_GET["article"]);
    $article  = $articleManager->thearticleforAdminSelectOneBySlug($slug);
    $comments = $commentManager->thecommentSelectAllByIdArticle($article["idthearticle"]);
    echo $twig->render("private/articleView.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        'article'  => $article,
        "comments" => $comments,
    ]);
}
elseif (isset($_GET["articleSearch"])) {
    $type = $_GET["articleSearch"] === "thesection" ? "s" : "u";
    if ($type === "s") {
        $mod = $_GET["section"] ?? "";
        $mod = userEntryProtectionTrait::userEntryProtection($mod);
    }
    else {
        $mod = (int) ($_GET["user"] ?? null);
    }
    $articles = $articleManager->thearticleSelectAllByMod($type, $mod, $_SESSION);
    echo $twig->render("private/articleSearch.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        'articles' => $articles,
        "type"     => $type,
        "mod"      => $mod,
    ]);
}
elseif (isset($_GET["articleActivate"])) {
    $state = !(bool) $_GET["state"];
    $slug  = userEntryProtectionTrait::userEntryProtection($_GET["articleActivate"]);
    $articleManager->thearticleActivate($slug, $state);
    header("Location: ./?viewArticles");
}
else {
    echo $twig->render("private/homepage.template.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
    ]);
}