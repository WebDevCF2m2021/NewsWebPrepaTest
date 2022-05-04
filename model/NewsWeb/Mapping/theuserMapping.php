<?php


namespace NewsWeb\Mapping;

use NewsWeb\AbstractMapping;

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
    public function setIdtheuser(int $idtheuser): TheUserMapping
    {
        // dépasse 45 caractères
        if (strlen($idtheuser) > 45) {
            // affichage de l'erreur
            trigger_error("L'ID de l'utilisateur ne peut pas dépasser 9999999999", E_USER_NOTICE);
        } else {
            $this->idtheuser = $idtheuser;
        }
        return $this;
    }

    /**
     * @param string $theuserlogin
     * @return TheUserMapping
     */
    public function setTheuserlogin(string $theuserlogin): TheUserMapping
    {
        if (strlen($theuserlogin) > 50) {
            trigger_error("L'ID de l'utilisateur ne peut pas dépasser 9999999999", E_USER_NOTICE);
            return $this;
        } else {
            $this->theuserlogin = $theuserlogin;
            return $this;
        }
    }

    /**
     * @param string $theuserpwd
     * @return TheUserMapping
     */
    public function setTheuserpwd(string $theuserpwd): TheUserMapping
    {
        if (strlen($theuserpwd) > 255) {
            trigger_error("Le mot de passe est trop long ! ", E_USER_NOTICE);
            return $this;
        } else {
            $this->theuserpwd = $theuserpwd;
            return $this;
        }
    }

    /**
     * @param string $theusermail
     * @return TheUserMapping
     */
    public function setTheusermail(string $theusermail): TheUserMapping
    {
        if (strlen($theusermail) > 255) {
            trigger_error("L'adresse e-mail est trop longue ! ", E_USER_NOTICE);
            return $this;
        } else {
            $this->theusermail = $theusermail;
            return $this;
        }
    }

    /**
     * @param string $theuseruniqid
     */
    public function setTheuseruniqid(string $theuseruniqid): void
    {
        $this->theuseruniqid = $theuseruniqid;
    }

    /**
     * @param int $theuseracivate
     */
    public function setTheuseracivate(int $theuseracivate): void
    {
        $this->theuseracivate = $theuseracivate;
    }

    /**
     * @param int $permission_idpermission
     */
    public function setPermission_idpermission(int $permission_idpermission): void
    {
        $this->permission_idpermission = $permission_idpermission;
    }


}