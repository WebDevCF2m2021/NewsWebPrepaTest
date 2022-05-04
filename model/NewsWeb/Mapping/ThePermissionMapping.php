<?php

namespace NewsWeb\Mapping;

class ThePermissionMapping extends \NewsWeb\AbstractMapping
{
    // Propriétés
    private int $idpermission;
    private string $permissionname;
    private int $permissionrole;

    // Getters

    /**
     * @return int
     */
    public function getIdpermission(): int
    {
        return $this->idpermission;
    }

    /**
     * @return string
     */
    public function getPermissionname(): string
    {
        return $this->permissionname;
    }

    /**
     * @return int
     */
    public function getPermissionrole(): int
    {
        return $this->permissionrole;
    }

    // Setters

    /**
     * @param int $idpermission
     * @return ThePermissionMapping
     */
    public function setIdpermission(int $idpermission): ThePermissionMapping
    {
        if($idpermission < 0 && $idpermission > 3) {
            trigger_error("L'id permission n'est pas valide", E_USER_NOTICE);
            return $this;
        } else {
            $this->idpermission = $idpermission;
            return $this;
        }
    }

    /**
     * @param string $permissionname
     * @return PermissionMapping
     */
    public function setPermissionname(string $permissionname): PermissionMapping
    {
        // dépasse 45 caractères
        if(strlen($permissionname)>45){
            // affichage de l'erreur
            trigger_error("Le nom de la permission ne doit pas dépasser 45 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->permissionname = $permissionname;
            return $this;
        }
    }

    /**
     * @param int $permissionrole
     * @return ThePermissionMapping
     */
    public function setPermissionrole(int $permissionrole): ThePermissionMapping
    {
        if($permissionrole < 0 && $permissionrole > 2) {
            trigger_error("Ce rôle n'existe pas ! ");
            return $this;
        } else {
            $this->permissionrole = $permissionrole;
            return $this;
        }
    }



}