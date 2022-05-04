<?php

namespace NewsWeb\Mapping;

class TheimageMapping extends \NewsWeb\AbstractMapping
{
    // Paramètres

    private int $idtheimage;
    private string $theimagename;
    private string $theimagetype;
    private string $thimageurl;
    private string $theimagetext;

    // Getters

    /**
     * @return int
     */
    public function getIdtheimage(): int
    {
        return $this->idtheimage;
    }

    /**
     * @return string
     */
    public function getTheimagename(): string
    {
        return $this->theimagename;
    }

    /**
     * @return string
     */
    public function getTheimagetype(): string
    {
        return $this->theimagetype;
    }

    /**
     * @return string
     */
    public function getThimageurl(): string
    {
        return $this->thimageurl;
    }

    /**
     * @return string
     */
    public function getTheimagetext(): string
    {
        return $this->theimagetext;
    }

    // Setters

    /**
     * @param int $idtheimage
     * @return TheImageMapping
     */
    public function setIdtheimage(int $idtheimage): TheimageMapping
    {
        if(strlen($idtheimage) > 100) {
            trigger_error("L'id de l'image dépasse la capacité de la base de données.");
            return $this;
        } else {
            $this->idtheimage = $idtheimage;
            return $this;
        }
    }

    /**
     * @param string $theimagename
     * @return TheimageMapping
     */
    public function setTheimagename(string $theimagename): TheimageMapping
    {
        if(strlen($theimagename) > 45){
            trigger_error("Ce nom est trop long.", E_USER_NOTICE);
            return $this;
        } else {
            $this->theimagename = $theimagename;
            return $this;
        }
    }

    /**
     * @param string $theimagetype
     */
    public function setTheimagetype(string $theimagetype): void
    {
        $this->theimagetype = $theimagetype;
    }

    /**
     * @param string $thimageurl
     */
    public function setThimageurl(string $thimageurl): void
    {
        $this->thimageurl = $thimageurl;
    }

    /**
     * @param string $theimagetext
     */
    public function setTheimagetext(string $theimagetext): void
    {
        $this->theimagetext = $theimagetext;
    }



}