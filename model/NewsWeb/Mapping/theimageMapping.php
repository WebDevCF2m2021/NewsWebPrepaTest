<?php

namespace NewsWeb\Mapping;

class theimageMapping extends \NewsWeb\Abstract\AbstractMapping
{
    private int $idtheimage;
    private string $theimagename;
    private string $theimagetype;
    private string $theimageurl;
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
    public function gettheimagename(): string
    {
        return $this->theimagename;
    }

    /**
     * @return string
     */
    public function gettheimagetype(): string
    {
        return $this->theimagetype;
    }

    /**
     * @return string
     */
    public function gettheimageurl(): string
    {
        return $this->theimageurl;
    }

    /**
     * @return string
     */
    public function gettheimagetext(): string
    {
        return $this->theimagetext;
    }

    // Setters

    /**
     * @param int $idtheimage
     * @return ImageMapping
     */
    public function setIdtheimage(int $idtheimage): theImageMapping
    {
        $this->idtheimage = $idtheimage;
        return $this;
    }

    /**
     * @param string $theimagename
     * @return ImageMapping
     */
    public function settheimagename(string $theimagename): theImageMapping
    {
        if(strlen($theimagename)>45){
            // affichage de l'erreur
            trigger_error("Le nom de l'image ne doit pas dépasser 45 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->theimagename = $theimagename;
            return $this;
        }
    }

    /**
     * @param string $theimagetype
     * @return ImageMapping
     */
    public function settheimagetype(string $theimagetype): theImageMapping
    {
        if(strlen($theimagetype)>5){
            // affichage de l'erreur
            trigger_error("Le type de l'image ne doit pas dépasser 5 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->theimagetype = $theimagetype;
            return $this;
        }
    }

    /**
     * @param string $theimageurl
     * @return ImageMapping
     */
    public function settheimageurl(string $theimageurl): theImageMapping
    {
        if(strlen($theimageurl)>100){
            // affichage de l'erreur
            trigger_error("L'URL de l'image ne doit pas dépasser 100 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->theimageurl = $theimageurl;
            return $this;
        }
    }

    /**
     * @param string $theimgetext
     * @return ImageMapping
     */
    public function settheimagetext(string $theimgetext): theImageMapping
    {
        if(strlen($theimgetext)>250){
            // affichage de l'erreur
            trigger_error("Le text de l'image ne doit pas dépasser 250 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->theimagetext = $theimgetext;
            return $this;
        }
    }
}