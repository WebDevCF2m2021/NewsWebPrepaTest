<?php

namespace NewsWeb\Manager;

use Exception;
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;

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

    // se connecter et vérifier la validité du login/pwd, renvoie un tableau contenant les information de theuser et de permission, (sans mots de passes ni infos dangereuses), ou false

    public function theuserSelectOneById(int $id) : array|bool
    {

    }

    public function theuserConnectByLoginAndPwd($login, $pwd) : bool
    {
        $query   = "SELECT u.idtheuser, u.theuserlogin, u.theuserpwd, u.theusermail,
                    p.permissionname, p.permissionrole
                    FROM theuser u
                    INNER JOIN permission p
                    ON u.permission_idpermission = p.idpermission
                    WHERE u.theuserlogin = ?";
        $prepare = $this->connect->prepare($query);
        $prepare->bindParam(1, $login, MyPDO::PARAM_STR);
        $prepare->execute();
        try {
            $result = $prepare->fetch(MyPDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e);
        }
        return $result ? $this->userLogin($result, $pwd) : false;
    }

    private function userLogin($userInfo, $pwd) : bool
    {
        if (password_verify($pwd, $userInfo["theuserpwd"])) {
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
}