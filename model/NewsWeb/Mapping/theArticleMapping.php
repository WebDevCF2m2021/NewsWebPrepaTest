<?php

namespace NewsWeb\Mapping;

class ArticleMapping extends \NewsWeb\AbstractMapping {
    
    // Propriétés
    private int $idthearticle;
    private string $thearticletitle;
    private string $thearticleslug;
    private string $thearticleresume;
    private string $thearticletext;
    private string $thearticledate;
    private int $thearticleactivate;

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
     * @return ArticleMapping
     */
    public function setIdArticle(int $idthearticle): ArticleMapping
    {
        $this->idthearticle = $idthearticle;
        return $this;
    }

    /**
     * @param string $thearticletitle
     * @return ArticleMapping
     */
    public function setArticleTitle(string $thearticletitle): ArticleMapping
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
     * @return ArticleMapping
     */
    public function setArticleSlug(string $thearticleslug): ArticleMapping
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
     * @return ArticleMapping
     */
    public function setArticleResume(string $thearticleresume): ArticleMapping
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
     * @return ArticleMapping
     */
    public function setArticleText(string $thearticletext): ArticleMapping
    {
        $this->thearticletext = $thearticletext;
        return $this;
    }

    /**
     * @param string $thearticledate
     * @return ArticleMapping
     */
    public function setArticleDate(string $thearticledate): ArticleMapping
    {
        $this->thearticledate = $thearticledate;
        return $this;
    }

    /**
     * @param int $thearticleactivate
     * @return ArticleMapping
     */
    public function setArticleActivate(int $thearticleactivate): ArticleMapping
    {
        $this->thearticleactivate = $thearticleactivate;
        return $this;
    }

}