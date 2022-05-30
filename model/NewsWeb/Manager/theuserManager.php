<?php

namespace NewsWeb\Manager;

use Exception;
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\Mapping\theuserMapping;
use NewsWeb\MyPDO;
use PDO;

class theuserManager implements ManagerInterface
{
    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    // récupère l'utilisateur via son id - de theuser : idtheuser, theuserlogin,
    // de la table permission en jointure interne : tous

    public static function disconnect() : void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public function theuserSelectOneById(int $id) : array|bool
    {
        $query   = "SELECT u.idtheuser, u.theuserlogin
                    FROM theuser u
                    WHERE u.idtheuser = ?;";
        $prepare = $this->connect->prepare($query);
        try {
            $prepare->execute([$id]);
            return $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function theuserSelectOneByIdForAdmin(int $id) : array|bool
    {
        $query   = "SELECT u.idtheuser, u.theuserlogin, u.theusermail, u.theuseractivate, u.permission_idpermission
                    FROM theuser u
                    WHERE u.idtheuser = ?;";
        $prepare = $this->connect->prepare($query);
        try {
            $prepare->execute([$id]);
            return $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // se connecter et vérifier la validité du login/pwd, renvoie un tableau contenant les information de theuser et de permission, (sans mots de passes ni infos dangereuses), ou false

    public function theuserConnectByLoginAndPwd(theuserMapping $user) : bool
    {
        $query   = "SELECT u.idtheuser, u.theuserlogin, u.theuserpwd, u.theusermail, u.theuseractivate,
                    p.permissionname, p.permissionrole
                    FROM theuser u
                    INNER JOIN permission p
                    ON u.permission_idpermission = p.idpermission
                    WHERE u.theuserlogin = ?";
        $prepare = $this->connect->prepare($query);
        $prepare->bindValue(1, $user->getTheuserlogin(), PDO::PARAM_STR);
        $prepare->execute();
        try {
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e);
        }
        return $result && $this->userLogin($result, $user->getTheuserpwd());
    }

    private function userLogin($userInfo, $pwd) : bool
    {
        if ($userInfo["theuseractivate"] === "1" && password_verify($pwd, $userInfo["theuserpwd"])) {
            $_SESSION["idSession"]      = session_id();
            $_SESSION["idUser"]         = $userInfo["idtheuser"];
            $_SESSION["userLogin"]      = $userInfo["theuserlogin"];
            $_SESSION["userMail"]       = $userInfo["theusermail"];
            $_SESSION["permissionName"] = $userInfo["permissionname"];
            $_SESSION["permissionRole"] = $userInfo["permissionrole"];
            $result                     = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    public function theuserSelectAllForAdminArticleUpdate() : array|string
    {
        $sql     = "SELECT idtheuser, theuserlogin
                    FROM theuser
                    WHERE theuseractivate = 1";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->execute();
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function theuserSelectAllForAdmin() : array|string
    {
        $sql     = "SELECT u.idtheuser, u.theuserlogin, u.theusermail, u.theuseractivate, p.permissionname, p.permissionrole, c.nbcomments, a.nbarticles
                    FROM theuser u
                    INNER JOIN permission p 
                    ON u.permission_idpermission = p.idpermission
                    LEFT JOIN (SELECT theuser_idtheuser, COUNT(*) AS nbcomments FROM thecomment GROUP BY theuser_idtheuser) AS c
                    ON c.theuser_idtheuser = u.idtheuser
                    LEFT JOIN (SELECT theuser_idtheuser, COUNT(*) AS nbarticles FROM thearticle GROUP BY theuser_idtheuser) AS a
                    ON a.theuser_idtheuser = u.idtheuser;";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->execute();
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function theuserActivate(int $id, bool $state) : ?string
    {
        $sql     = "UPDATE theuser SET theuseractivate = ? WHERE idtheuser = ? AND permission_idpermission != 1;";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindParam(1, $state, PDO::PARAM_BOOL);
            $prepare->bindParam(2, $id, PDO::PARAM_INT);
            $prepare->execute();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result ?? null;
    }

    public function theuserBan(int $id) : ?string
    {
        $sql     = "UPDATE theuser SET theuseractivate = 2 WHERE idtheuser = ? AND permission_idpermission != 1;";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindParam(1, $id, PDO::PARAM_INT);
            $prepare->execute();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result ?? null;
    }

    public function addUser(theuserMapping $user) : bool|string
    {
        $sql     = "INSERT INTO theuser(theuserlogin, theuserpwd, theusermail, theuseruniqid, theuseractivate, permission_idpermission) VALUES (?,?,?,?,?,?)";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindValue(1, $user->getTheuserlogin());
            $prepare->bindValue(2, $user->getTheuserpwd());
            $prepare->bindValue(3, $user->getTheusermail());
            $prepare->bindValue(4, $user->getTheuseruniqid());
            $prepare->bindValue(5, $user->getTheuseracivate());
            $prepare->bindValue(6, $user->getPermissionIdpermission());
            $result = $prepare->execute();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function theuserUpdate(theuserMapping $user) : bool|string
    {
        $sql     = "UPDATE theuser SET permission_idpermission=? WHERE idtheuser = ?";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindValue(1, $user->getPermissionIdpermission());
            $prepare->bindValue(2, $user->getIdtheuser());
            $result = $prepare->execute();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}