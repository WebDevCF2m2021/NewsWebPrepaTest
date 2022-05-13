<?php

namespace NewsWeb\Manager;

use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;

class theuserManager implements ManagerInterface
{


    // récupère l'utilisateur via son id - de theuser : idtheuser, theuserlogin,
    // de la table permission en jointure interne : tous
    public function theuserSelectOneById(int $id): array|bool
    {

    }

    // se connecter et vérifier la validité du login/pwd, renvoie un tableau contenant les information de theuser et de permission, (sans mots de passes ni infos dangereuses), ou false
    public function theuserConnectByLoginAndPwd(): array|bool
    {

    }
}