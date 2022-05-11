<?php

namespace NewsWeb\Manager;

use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;

class thearticleManager implements ManagerInterface
{

    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    // Récupération de tous les articles d'une section
    public function thearticleSelectAllFromSection(int $idthesection): array|string {
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            GROUP_CONCAT(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            GROUP_CONCAT(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY to ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many to Many mais avec une condition where qui ne permet
                # de garder qu'une seule rubrique AND sha.thesection_idthesection=  
                INNER JOIN thesection_has_thearticle sha
                    ON sha.thearticle_idthearticle = a.idthearticle
                # Many to Many sur 2 tables pour garder toutes les rubriques
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                # conditions : article validé, utilisateur actif et 
                # se trouver dans la section choisie
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                        AND sha.thesection_idthesection=?
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC;
        ";
        $prepare = $this->connect->prepare($sql);

        try{
            $prepare->execute([$idthesection]);
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }


    // Récupération de tous les articles du site
    public function thearticleSelectAll(): array|string {
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , LEFT(a.thearticletext,800) AS thearticletext, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            GROUP_CONCAT(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            GROUP_CONCAT(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY to ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many to Many sur 2 tables pour garder toutes les rubriques
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                # conditions : article validé, utilisateur actif
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC;git push
                
        ";
        $prepare = $this->connect->prepare($sql);

        try{
            $prepare->execute();
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

}