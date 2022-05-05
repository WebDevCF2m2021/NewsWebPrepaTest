<?php

namespace NewsWeb\Mapping;

class permissionMapping extends \NewsWeb\Abstract\AbstractMapping
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
     * @return PermissionMapping
     */
    public function setIdpermission(int $idpermission): PermissionMapping
    {
        $this->idpermission = $idpermission;
        return $this;
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
     * @return PermissionMapping
     */
    public function setPermissionrole(int $permissionrole): PermissionMapping
    {
        $this->permissionrole = $permissionrole;
        return $this;
    }



}