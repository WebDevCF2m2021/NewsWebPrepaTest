<?php

namespace NewsWeb\Mapping;

class ImageMapping extends \NewsWeb\AbstractMapping
{
    private int $idtheimage;
    private string $theimagename;
    private string $theimagetype;
    private string $theimageurl;
    private string $theimgetext;

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
    public function getIdtheimagename(): string
    {
        return $this->idtheimagename;
    }

    /**
     * @return string
     */
    public function getIdtheimagetype(): string
    {
        return $this->idtheimagetype;
    }

    /**
     * @return string
     */
    public function getIdtheimageurl(): string
    {
        return $this->idtheimageurl;
    }

    /**
     * @return string
     */
    public function getIdtheimagetext(): string
    {
        return $this->idtheimagetext;
    }

    // Setters

    /**
     * @param int $idtheimage
     * @return ImageMapping
     */
    public function setIdtheimage(int $idtheimage): ImageMapping
    {
        $this->idtheimage = $idtheimage;
        return $this;
    }

    /**
     * @param string $theimagename
     * @return ImageMapping
     */
    public function setIdtheimagename(string $theimagename): ImageMapping
    {
        if(strlen($theimagename)>45){
            // affichage de l'erreur
            trigger_error("Le nom de l'image ne doit pas dépasser 45 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->idtheimagename = $theimagename;
            return $this;
        }
    }

    /**
     * @param string $theimagetype
     * @return ImageMapping
     */
    public function setIdtheimagetype(string $theimagetype): ImageMapping
    {
        if(strlen($theimagetype)>5){
            // affichage de l'erreur
            trigger_error("Le type de l'image ne doit pas dépasser 5 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->idtheimagetype = $theimagetype;
            return $this;
        }
    }

    /**
     * @param string $theimageurl
     * @return ImageMapping
     */
    public function setIdtheimageurl(string $theimageurl): ImageMapping
    {
        if(strlen($theimageurl)>100){
            // affichage de l'erreur
            trigger_error("L'URL de l'image ne doit pas dépasser 100 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->idtheimageurl = $theimageurl;
            return $this;
        }
    }

    /**
     * @param string $theimgetext
     * @return ImageMapping
     */
    public function setIdtheimagetext(string $theimgetext): ImageMapping
    {
        if(strlen($theimgetext)>250){
            // affichage de l'erreur
            trigger_error("Le text de l'image ne doit pas dépasser 250 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->idtheimagetext = $theimgetext;
            return $this;
        }
    }
}