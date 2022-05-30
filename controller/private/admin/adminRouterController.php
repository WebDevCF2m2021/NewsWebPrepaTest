<?php

use NewsWeb\Manager\permissionManager;
use NewsWeb\Manager\thearticleManager;
use NewsWeb\Manager\thecommentManager;
use NewsWeb\Manager\thesectionManager;
use NewsWeb\Manager\theuserManager;
use NewsWeb\Mapping\permissionMapping;
use NewsWeb\Mapping\thearticleMapping;
use NewsWeb\Mapping\theuserMapping;
use NewsWeb\Trait\userEntryProtectionTrait;

$sectionManager    = new thesectionManager($connectMyPDO);
$articleManager    = new thearticleManager($connectMyPDO);
$commentManager    = new thecommentManager($connectMyPDO);
$userManager       = new theuserManager($connectMyPDO);
$permissionManager = new permissionManager($connectMyPDO);
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
        break;
    case "viewArticles":
        $articles = $articleManager->thearticleAdminSelectAll();
        echo $twig->render("private/article/articlesList.html.twig", [
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
        echo $twig->render("private/article/articleSearch.html.twig", [
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
        echo $twig->render("private/article/articleView.html.twig", [
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
        $users   = $userManager->theuserSelectAllForAdminArticleUpdate();
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
        echo $twig->render("private/article/articleUpdate.html.twig", [
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
            echo $twig->render("private/article/articleDelete.html.twig", [
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
    case "viewUsers":
        $users = $userManager->theuserSelectAllForAdmin();
        echo $twig->render("private/user/usersList.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
            'users'    => $users,
        ]);
        break;
    case "userActivate":
        $state = $_GET["state"] === "2" ? !(bool) ((int) $_GET["state"] - 2) : !(bool) $_GET["state"];
        $id    = (int) $_GET["userActivate"];
        $userManager->theuserActivate($id, $state);
        header("Location: ./?viewUsers");
        break;
    case "userBan":
        $id = (int) $_GET["userBan"];
        $userManager->theuserBan($id);
        header("Location: ./?viewUsers");
        break;
    case "addUser":
        $permissions = $permissionManager->permissionSelectAll();
        if (isset($_POST["theuserlogin"], $_POST["theusermail"], $_POST["theuserpwd"], $_POST["permission_idpermission"])) {
            $user = new theuserMapping([
                "theuserlogin"            => userEntryProtectionTrait::userEntryProtection($_POST["theuserlogin"]),
                "theuserpwd"              => password_hash($_POST["theuserpwd"], PASSWORD_DEFAULT),
                "theusermail"             => filter_Var(userEntryProtectionTrait::userEntryProtection($_POST["theusermail"]), FILTER_VALIDATE_EMAIL),
                "permission_idpermission" => (int) $_POST["permission_idpermission"] !== 1 ? (int) $_POST["permission_idpermission"] : 3,
            ], true);
            if (!is_string($userManager->addUser($user))) {
                header("Location: ./?viewUsers");
            }
            else {
                echo $twig->render("private/user/userForm.html.twig", [
                    'username'    => $_SESSION['userLogin'],
                    'session'     => $_SESSION,
                    "newUser"     => $user,
                    "permissions" => $permissions,
                    "sections"    => $sectionManager->SelectAllThesection(),
                ]);
            }
        }
        else {
            echo $twig->render("private/user/userForm.html.twig", [
                'username'    => $_SESSION['userLogin'],
                'session'     => $_SESSION,
                "permissions" => $permissions,
                "sections"    => $sectionManager->SelectAllThesection(),
            ]);
        }
        break;
    case "updateUser":
        $permissions = $permissionManager->permissionSelectAll();
        $user        = new theuserMapping($userManager->theuserSelectOneByIdForAdmin((int) $_GET["updateUser"]));
        if ($user->getPermissionIdpermission() !== 1) {
            if (isset($_POST["permission_idpermission"])) {
                $user->setPermissionIdpermission((int) $_POST["permission_idpermission"] !== 1 ? (int) $_POST["permission_idpermission"] : 3);
                if ($userManager->theuserUpdate($user)) {
                    header("Location: ./?viewUsers");
                }
            }
            echo $twig->render("private/user/userUpdate.html.twig", [
                'username'    => $_SESSION['userLogin'],
                'session'     => $_SESSION,
                "user"        => $user,
                "permissions" => $permissions,
                "sections"    => $sectionManager->SelectAllThesection(),
            ]);
        }
        else {
            header("Location: ./?viewUsers");
        }
        break;
    case "user":
        $user       = new theuserMapping($userManager->theuserSelectOneByIdForAdmin((int) $_GET["user"]));
        $permission = new permissionMapping($permissionManager->permissionSelectOneById($user->getPermissionIdpermission()));
        $articles   = $articleManager->thearticleSelectAllByIdUserForAdmin($user->getIdtheuser());
        $comments   = "";
        echo $twig->render("private/user/userView.html.twig", [
            'username'   => $_SESSION['userLogin'],
            'session'    => $_SESSION,
            'user'       => $user,
            "permission" => $permission,
            "articles"   => $articles,
            "comments"   => $comments,
        ]);
        break;
    default:
        echo $twig->render("private/homepage.template.html.twig", [
            'username' => $_SESSION['userLogin'],
            'session'  => $_SESSION,
        ]);
}
