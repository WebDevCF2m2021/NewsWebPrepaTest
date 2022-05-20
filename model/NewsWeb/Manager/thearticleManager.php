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

    // Récupération de tous les articles d'une section (même champs que thearticleSelectAll() sauf l'affichage de l'utilisateur déjà pris par une autre requête) lorsque l'id de l'utilisateur correspond à $iduser (de 0 à X résultats)
    public function thearticleSelectAllByIdUser(int $iduser): array|string
    {
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate, LEFT(a.thearticletext,800) AS thearticletext,
            u.idtheuser, u.theuserlogin,
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
                # conditions : article validé, utilisateur actif et 
                # se trouver dans la section choisie
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                        AND u.idtheuser = ?
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC;
        ";
        $prepare = $this->connect->prepare($sql);

        try {
            $prepare->execute([$iduser]);
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    // Récupération de tous les articles d'une section
    public function thearticleSelectAllFromSection(int $idthesection): array|string
    {
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            group_concat(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            group_concat(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY TO ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many TO Many mais avec une CONDITION WHERE qui ne permet
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

        try {
            $prepare->execute([$idthesection]);
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération de l'article (idthearticle, thearticletitle, thearticletext, thearticleresume, thearticledate ) avec toutes les rubriques avec le lien, l'auteur et le lien vers celui-ci, via son slug
    public function thearticleSelectOneBySlug(string $slug): array|bool
    {
        $query = $this->connect->prepare("SELECT a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticletext, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            group_concat(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            group_concat(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY TO ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many TO Many sur 2 tables pour garder toutes les rubriques
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                # conditions : article validé, utilisateur actif
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                        AND thearticleslug=?
                GROUP BY a.idthearticle  ");
        try {
            $query->execute([$slug]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    // Récupération de tous les articles du site
    public function thearticleSelectAll(int $limit = 1000000000000000, int $offset = 0): array|string
    {
        $sql = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , LEFT(a.thearticletext,800) AS thearticletext, a.thearticleresume, a.thearticledate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            GROUP_CONCAT(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            GROUP_CONCAT(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                # Jointure MANY TO ONE
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                # Many TO Many sur 2 tables pour garder toutes les rubriques
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                # conditions : article validé, utilisateur actif
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC
                LIMIT ? OFFSET ?;";
        $prepare = $this->connect->prepare($sql);

        try {
            $prepare->bindParam(1, $limit, \PDO::PARAM_INT);
            $prepare->bindParam(2, $offset, \PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}