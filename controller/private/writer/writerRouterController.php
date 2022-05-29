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
    if (isset($_POST["thearticletitle"], $_POST["thearticletext"])) {
        $article = new thearticleMapping([
            'thearticletitle' => userEntryProtectionTrait::userEntryProtection($_POST["thearticletitle"]),
            'thearticletext'  => userEntryProtectionTrait::userEntryProtection($_POST["thearticletext"], allowed_tags: ["<pre>", "</pre>", "</br>", "<br/>"]),
        ], true);
        if (isset($_POST["sections"])) {
            $articleManager->insertArticle($article, $_POST["sections"], $_SESSION);
            header("Location: ./?viewArticles");
        }
        else {
            echo $twig->render("private/article/articleForm.html.twig", [
                'username' => $_SESSION['userLogin'],
                'session'  => $_SESSION,
                "article"  => $article,
                "alert"    => true,
                "sections" => $sectionManager->SelectAllThesection(),
            ]);
        }
    }
    else {
        echo $twig->render("private/article/articleForm.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            "sections" => $sectionManager->SelectAllThesection(),
        ]);
    }
}
elseif (isset($_GET["viewArticles"])) {
    $articles = $articleManager->thearticleWriterSelectAll($_SESSION);
    echo $twig->render("private/article/articlesList.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
        'articles' => $articles,
    ]);
}
elseif (isset($_GET["article"])) {
    $slug     = userEntryProtectionTrait::userEntryProtection($_GET["article"]);
    $article  = $articleManager->thearticleforAdminSelectOneBySlug($slug);
    $comments = $commentManager->thecommentSelectAllByIdArticle($article["idthearticle"]);
    if (isset($_POST["userComment"])) {

    }
    echo $twig->render("private/article/articleView.html.twig", [
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
    echo $twig->render("private/article/articleSearch.html.twig", [
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
    $articleManager->thearticleActivate($slug, $state, $_SESSION);
    header("Location: ./?viewArticles");
}
elseif (isset($_GET["updateArticle"])) {
    $slug    = userEntryProtectionTrait::userEntryProtection($_GET["updateArticle"]);
    $article = $articleManager->thearticleForAdminSelectOneBySlug($slug);
    if (isset($_POST["thearticletitle"], $_POST["thearticletext"], $_POST["sections"])) {
        $articleUpdate = new thearticleMapping([
            "idthearticle"    => (int) $_POST["idthearticle"],
            'thearticletitle' => userEntryProtectionTrait::userEntryProtection($_POST["thearticletitle"]),
            'thearticletext'  => userEntryProtectionTrait::userEntryProtection($_POST["thearticletext"], allowed_tags: ["<pre>", "</pre>", "</br>", "<br/>"]),
        ], true);
        if ((int) $article["idthearticle"] === $articleUpdate->getIdthearticle() && $articleManager->updateArticle($articleUpdate, $_POST["sections"], $_SESSION)) {
            header("Location: ./?viewArticles");
        }
    }
    if ($article["idtheuser"] === $_SESSION["idUser"]) {
        echo $twig->render("private/article/articleUpdate.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            "article"  => $article,
            "sections" => $sectionManager->SelectAllThesection(),
        ]);
    }
    else {
        header("Location: ./?viewArticles");
    }
}
elseif (isset($_GET["deleteArticle"])) {
    $slug     = userEntryProtectionTrait::userEntryProtection($_GET["deleteArticle"]);
    $article  = $articleManager->thearticleForAdminSelectOneBySlug($slug);
    $comments = $commentManager->thecommentSelectAllByIdArticle($article["idthearticle"]);
    if (isset($_GET["confirm"])) {
        $articleDelete = new thearticleMapping($article);
        if ($articleManager->deleteArticle($articleDelete, $_SESSION)) {
            header("Location: ./?viewArticles");
        }
    }
    if ($article["idtheuser"] === $_SESSION["idUser"]) {
        echo $twig->render("private/article/articleDelete.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            'article'  => $article,
            "comments" => $comments,
        ]);
    }
    else {
        header("Location: ./?viewArticles");
    }
}
else {
    echo $twig->render("private/homepage.template.html.twig", [
        'username' => $_SESSION['userLogin'],
        'session'  => $_SESSION,
    ]);
}