<?php

use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thecommentManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Manager\theuserManager;
use NewsWeb\Mapping\thearticleMapping;
use NewsWeb\Trait\userEntryProtectionTrait;

$sectionManager = new thesectionManager($connectMyPDO);
$articleManager = new thearticleManager($connectMyPDO);
$commentManager = new thecommentManager($connectMyPDO);
$userManager    = new theuserManager($connectMyPDO);
switch (key($_GET)) {
    case "addArticle":
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
                echo $twig->render("private/articleForm.html.twig", [
                    'username' => $_SESSION['userLogin'],
                    'session'  => $_SESSION,
                    "article"  => $article,
                    "alert"    => true,
                    "sections" => $sectionManager->SelectAllThesection(),
                ]);
            }
        }
        else {
            echo $twig->render("private/articleForm.html.twig", [
                'username' => $_SESSION['userLogin'],
                'session'  => $_SESSION,
                "sections" => $sectionManager->SelectAllThesection(),
            ]);
        }
        break;
    case "viewArticles":
        $articles = $articleManager->thearticleAdminSelectAll();
        echo $twig->render("private/articlesList.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            'articles' => $articles,
        ]);
        break;
    case "articleSearch":
        $type = $_GET["articleSearch"] === "thesection" ? "s" : "u";
        if ($type === "s") {
            $mod = $_GET["section"] ?? "";
            $mod = userEntryProtectionTrait::userEntryProtection($mod);
        }
        else {
            $mod = (int) ($_GET["user"] ?? null);
        }
        $articles = $articleManager->thearticleAdminSelectAllByMod($type, $mod);
        echo $twig->render("private/articleSearch.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            'articles' => $articles,
            "type"     => $type,
            "mod"      => $mod,
        ]);
        break;
    case "article":
        $slug     = userEntryProtectionTrait::userEntryProtection($_GET["article"]);
        $article  = $articleManager->thearticleforAdminSelectOneBySlug($slug);
        $comments = $commentManager->thecommentSelectAllByIdArticle($article["idthearticle"]);
        if (isset($_POST["userComment"])) {

        }
        echo $twig->render("private/articleView.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            'article'  => $article,
            "comments" => $comments,
        ]);
        break;
    case "articleActivate":
        $state = $_GET["state"] == "2" ? !(bool) ((int) $_GET["state"] - 2) : !(bool) $_GET["state"];
        $slug  = userEntryProtectionTrait::userEntryProtection($_GET["articleActivate"]);
        $articleManager->thearticleActivate($slug, $state, $_SESSION);
        header("Location: ./?viewArticles");
        break;
    case "updateArticle":
        $slug    = userEntryProtectionTrait::userEntryProtection($_GET["updateArticle"]);
        $article = $articleManager->thearticleForAdminSelectOneBySlug($slug);
        $users   = $userManager->theuserSelectAllForAdmin();
        if (isset($_POST["thearticletitle"], $_POST["idtheuser"], $_POST["thearticletext"], $_POST["sections"])) {
            $articleUpdate = new thearticleMapping([
                "idthearticle"      => (int) $_POST["idthearticle"],
                "theuser_idtheuser" => (int) $_POST["idtheuser"],
                'thearticletitle'   => userEntryProtectionTrait::userEntryProtection($_POST["thearticletitle"]),
                'thearticletext'    => userEntryProtectionTrait::userEntryProtection($_POST["thearticletext"], allowed_tags: ["<pre>", "</pre>", "</br>", "<br/>"]),
            ], true);
            if ((int) $article["idthearticle"] === $articleUpdate->getIdthearticle() && $articleManager->updateForAdminArticle($articleUpdate, $_POST["sections"])) {
                header("Location: ./?viewArticles");
            }
        }
        echo $twig->render("private/articleUpdate.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            "article"  => $article,
            "users"    => $users,
            "sections" => $sectionManager->SelectAllThesection(),
        ]);
        break;
    case "deleteArticle":
        $slug     = userEntryProtectionTrait::userEntryProtection($_GET["deleteArticle"]);
        $article  = $articleManager->thearticleForAdminSelectOneBySlug($slug);
        $comments = $commentManager->thecommentSelectAllByIdArticle($article["idthearticle"]);
        if (isset($_GET["confirm"])) {
            $articleDelete = new thearticleMapping($article);
            if ($articleManager->deleteArticle($articleDelete, $_SESSION)) {
                header("Location: ./?viewArticles");
            }
        }
        if ($article["thearticleactivate"] !== "2") {
            echo $twig->render("private/articleDelete.html.twig", [
                'username' => $_SESSION['userLogin'],
                'session'  => $_SESSION,
                'article'  => $article,
                "comments" => $comments,
            ]);
        }
        else {
            header("location: ./?viewArticles");
        }
        break;
    default:
        echo $twig->render("private/homepage.template.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
        ]);
}
