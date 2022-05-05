<?php

namespace NewsWeb\Mapping;



class thearticleMapping extends \NewsWeb\Abstract\AbstractMapping {
    
    // Propriétés
    private int $idthearticle;
    private string $thearticletitle;
    private string $thearticleslug;
    private string $thearticleresume;
    private string $thearticletext;
    private string $thearticledate;
    private int $thearticleactivate;

    use \NewsWeb\Trait\SlugifyTrait;

// Getters
    /**
     * @return int
     */
    public function getIdArticle(): int
    {
        return $this->idthearticle;
    }

    /**
     * @return string
     */
    public function getArticleTitle(): string
    {
        return $this->thearticletitle;
    }

    /**
     * @return int
     */
    public function getArticleSlug(): string
    {
        return $this->thearticleslug;
    }


    /**
     * @return string
     */
    public function getArticleResume(): string
    {
        return $this->thearticleresume;
    }

    /**
     * @return int
     */
    public function getArticleText(): string
    {
        return $this->thearticletext;
    }

 /**
     * @return string
     */
    public function getArticleDate(): string
    {
        return $this->thearticledate;
    }

    /**
     * @return int
     */
    public function getArticleActivate(): string
    {
        return $this->thearticleactivate;
    }
    
    // Setters

    /**
     * @param int $idthearticle
     * @return thearticleMapping
     */
    public function setIdarticle(int $idthearticle): thearticleMapping
    {
        $this->idthearticle = $idthearticle;
        return $this;
    }

    /**
     * @param string $thearticletitle
     * @return thearticleMapping
     */
    public function setThearticletitle(string $thearticletitle): thearticleMapping
    {
        // dépasse 120 caractères
        if(strlen($thearticletitle)>120){
            // affichage de l'erreur
            trigger_error("La longueur du titre ne doit pas dépasser 120 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thearticletitle = $thearticletitle;
            return $this;
        }
    }


    /**
     * @param string $thearticleslug
     * @return thearticleMapping
     */
    public function setThearticleslug(string $thearticleslug): thearticleMapping
    {
        // dépasse 120 caractères
        if(strlen($thearticleslug)>120){
            // affichage de l'erreur
            trigger_error("La longueur du slug ne doit pas dépasser 120 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thearticleslug = $thearticleslug;
            return $this;
        }
    }

    /**
     * @param string $thearticleresume
     * @return thearticleMapping
     */
    public function setThearticleresume(string $thearticleresume): thearticleMapping
    {
        // dépasse 120 caractères
        if(strlen($thearticleresume)>250){
            // affichage de l'erreur
            trigger_error("La longueur du résumé ne doit pas dépasser 250 caractères", E_USER_NOTICE);
            return $this;
        }else {
            $this->thearticleresume = $thearticleresume;
            return $this;
        }
    }

    /**
     * @param string $thearticletext
     * @return thearticleMapping
     */
    public function setThearticletext(string $thearticletext): thearticleMapping
    {
        $this->thearticletext = $thearticletext;
        return $this;
    }

    /**
     * @param string $thearticledate
     * @return thearticleMapping
     */
    public function setThearticledate(string $thearticledate): thearticleMapping
    {
        $this->thearticledate = $thearticledate;
        return $this;
    }

    /**
     * @param int $thearticleactivate
     * @return thearticleMapping
     */
    public function setThearticleactivate(int $thearticleactivate): thearticleMapping
    {
        $this->thearticleactivate = $thearticleactivate;
        return $this;
    }

}