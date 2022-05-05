<?php

namespace NewsWeb\Mapping;

// utilisation de classes externes
// classe abstraite
use NewsWeb\Abstract\AbstractMapping;
// trait renommé en protection, on doit utiliser le 'use protection' dans la classe
use NewsWeb\Trait\userEntryProtectionTrait AS protection;

class theuserMapping extends AbstractMapping
{

    // Propriétés

    private int $idtheuser;
    private string $theuserlogin;
    private string $theuserpwd;
    private string $theusermail;
    private string $theuseruniqid;
    private int $theuseracivate;
    private int $permission_idpermission;

    // importation de la méthode du trait
    use protection;

    // Getters

    /**
     * @return int
     */
    public function getIdtheuser(): int
    {
        return $this->idtheuser;
    }

    /**
     * @return string
     */
    public function getTheuserlogin(): string
    {
        return $this->theuserlogin;
    }

    /**
     * @return string
     */
    public function getTheuserpwd(): string
    {
        return $this->theuserpwd;
    }

    /**
     * @return string
     */
    public function getTheusermail(): string
    {
        return $this->theusermail;
    }

    /**
     * @return string
     */
    public function getTheuseruniqid(): string
    {
        return $this->theuseruniqid;
    }

    /**
     * @return int
     */
    public function getTheuseracivate(): int
    {
        return $this->theuseracivate;
    }

    /**
     * @return int
     */
    public function getPermission_idpermission(): int
    {
        return $this->permission_idpermission;
    }

    // Setters

    /**
     * @param int $idtheuser
     * @return TheUserMapping
     */
    public function setIdtheuser(int $idtheuser): TheuserMapping
    {
        // dépasse 45 caractères
        if(strlen($idtheuser)>45){
            // affichage de l'erreur
            trigger_error("L'ID de l'utilisateur ne peut pas dépasser 9999999999", E_USER_NOTICE);
        }else {
            $this->idtheuser = $idtheuser;
        }
        return $this;

    }

    /**
     * @param string $theuserlogin
     * @return TheUserMapping
     */
    public function setTheuserlogin(string $theuserlogin): TheuserMapping
    {
        if(strlen($theuserlogin) > 50)
        {
            trigger_error("L'ID de l'utilisateur ne peut pas dépasser 9999999999", E_USER_NOTICE);
        } else {
            $this->theuserlogin = $theuserlogin;
        }
        return $this;
    }

    /**
     * @param string $theuserpwd
     * @return TheUserMapping
     */
    public function setTheuserpwd(string $theuserpwd): TheuserMapping
    {
        if(strlen($theuserpwd) > 255){
            trigger_error("Le mot de passe est trop long ! ", E_USER_NOTICE);
        } else {
            $this->theuserpwd = $theuserpwd;
        }
        return $this;
    }

    /**
     * @param string $theusermail
     * @return TheUserMapping
     */
    public function setTheusermail(string $theusermail): TheuserMapping
    {

        if((strlen($theusermail) > 255) && (!filter_var(trim($theusermail), FILTER_VALIDATE_EMAIL))){
            trigger_error("L'adresse e-mail est trop longue  ou le format est invalide ! ", E_USER_NOTICE);
        } else {
            $this->theusermail = $theusermail;
        }
        return $this;
    }

    /**
     * @param string $theuseruniqid
     * @return TheuserMapping
     */
    public function setTheuseruniqid(string $theuseruniqid): TheuserMapping
    {
        if(strlen($theuseruniqid) > 255) {
            trigger_error("La clef unique est trop longue ! ");
        } else {
            $this->theuseruniqid = $theuseruniqid;
        }
        return $this;
    }

    /**
     * @param int $theuseracivate
     * @return TheuserMapping
     */
    public function setTheuseractivate(int $theuseractivate): TheuserMapping
    {
        if(!($theuseractivate >= 0 && $theuseractivate < 3) || (!$theuseractivate)){
            trigger_error("Identifiant de l'état d'activité invalide !");
        } else {
            $this->theuseracivate = $theuseractivate;
        }
        return $this;
    }

    /**
     * @param int $permission_idpermission
     * @return TheuserMapping
     */
    public function setPermission_idpermission(int $permission_idpermission): TheuserMapping
    {
        if($permission_idpermission < 1 || $permission_idpermission > 3) {
            trigger_error("La permission introduite n'existe pas !", E_USER_NOTICE);
        } else {
            $this->permission_idpermission = $permission_idpermission;
        }
        return $this;
    }
}