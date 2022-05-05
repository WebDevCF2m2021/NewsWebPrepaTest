<?php

namespace NewsWeb\Mapping;

class thesectionMapping extends \NewsWeb\Abstract\AbstractMapping
{
    // Propriétés
    private int $idthesection;
    private string $thesectiontitle;
    private string $thesectionslug;
    private string $thesectiondesc;

    // Getters
    /**
     * @return int
     */
    public function getidthesection(): int
    {
        return $this->idthesection;
    }

    /**
     * @return string
     */
    public function getthesectiontitle(): string
    {
        return $this->thesectiontitle;
    }

    /**
     * @return string
     */
    public function getthesectionslug(): string
    {
        return $this->thesectionslug;
    }

     /**
     * @return string
     */
    public function getthesectiondesc(): string
    {
        return $this->thesectiondesc;
    }


    // Setters

    /**
     * @param int $idthesection
     * @return thesectionMapping
     */
    public function setidthesection(int $idthesection): thesectionMapping
    {
        $this->idthesection = $idthesection;
        return $this;
    }

    /**
     * @param string $thesectiontitle
     * @return thesectionMapping
     */
    public function setthesectiontitle(string $thesectiontitle): thesectionMapping
    {
        // dépasse 60 caractères
        if(strlen($thesectiontitle)>60){
            // affichage de l'erreur
            trigger_error("Le nom de la permission ne doit pas dépasser 60 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thesectiontitle = $thesectiontitle;
            return $this;
        }
    }

    /**
     * @param string $thesectionslug
     * @return thesectionMapping
     */
    public function setthesectionslug(string $thesectionslug): thesectionMapping
    {
        // dépasse 60 caractères
        if(strlen($thesectionslug)>60){
            // affichage de l'erreur
            trigger_error("Le nom de la permission ne doit pas dépasser 60 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thesectionslug = $thesectionslug;
            return $this;
        }
    }

     /**
     * @param string $thesectiondesc
     * @return thesectionMapping
     */
    public function setthesectiondesc(string $thesectiondesc): thesectionMapping
    {
        // dépasse 300 caractères
        if(strlen($thesectiondesc)>300){
            // affichage de l'erreur
            trigger_error("Le nom de la permission ne doit pas dépasser 300 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thesectiondesc = $thesectiondesc;
            return $this;
        }
    }

}