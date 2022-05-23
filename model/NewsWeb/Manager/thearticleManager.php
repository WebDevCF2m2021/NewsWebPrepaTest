<?php

namespace NewsWeb\Manager;

use Exception;
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\Mapping\thearticleMapping;
use NewsWeb\MyPDO;
use PDO;

class thearticleManager implements ManagerInterface
{

    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    // Récupération de tous les articles d'une section (même champs que thearticleSelectAll() sauf l'affichage de l'utilisateur déjà pris par une autre requête) lorsque l'id de l'utilisateur correspond à $iduser (de 0 à X résultats)
    public function thearticleSelectAllByIdUser(int $iduser) : array|string
    {
        $sql     = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate, LEFT(a.thearticletext,800) AS thearticletext,
            u.idtheuser, u.theuserlogin,
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
                # conditions : article validé, utilisateur actif et 
                # se trouver dans la SECTION choisie
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                        AND u.idtheuser = ?
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC;
        ";
        $prepare = $this->connect->prepare($sql);

        try {
            $prepare->execute([$iduser]);
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération de tous les articles d'une section
    public function thearticleSelectAllFromSection(int $idthesection) : array|string
    {
        $sql     = "SELECT 
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
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Récupération de l'article (idthearticle, thearticletitle, thearticletext, thearticleresume, thearticledate ) avec toutes les rubriques avec le lien, l'auteur et le lien vers celui-ci, via son slug
    public function thearticleSelectOneBySlug(string $slug) : array|bool
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
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Récupération de tous les articles du site
    public function thearticleSelectAll(int $limit = 1000000000000000, int $offset = 0) : array|string
    {
        $sql     = "SELECT 
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
            $prepare->bindParam(1, $limit, PDO::PARAM_INT);
            $prepare->bindParam(2, $offset, PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertArticle(thearticleMapping $article, array $sections, array $userInfos) : string|bool
    {
        $sql     = "INSERT INTO thearticle
                        (thearticletitle, thearticleslug, thearticleresume, thearticletext,theuser_idtheuser, thearticleactivate) 
                    VALUES 
                        (?,?,?,?,?,?);";
        $prepare = $this->connect->prepare($sql);
        try {
            $this->connect->beginTransaction();
            $prepare->bindValue(1, $article->getArticleTitle());
            $prepare->bindValue(2, $article->getArticleSLug());
            $prepare->bindValue(3, $article->getArticleResume());
            $prepare->bindValue(4, $article->getArticleText());
            $prepare->bindParam(5, $userInfos["idUser"]);
            $prepare->bindValue(6, ($userInfos["permissionRole"] === "0" ? 1 : 0), PDO::PARAM_STR);
            $prepare->execute();
            $lastId = $this->connect->lastInsertId();
            foreach ($sections as $section) {
                $prepare = $this->connect->prepare("INSERT INTO thesection_has_thearticle
                                            (thearticle_idthearticle, thesection_idthesection) 
                                         VALUES
                                            (?,?);");
                $prepare->bindParam(1, $lastId, PDO::PARAM_INT);
                $prepare->bindParam(2, $section, PDO::PARAM_INT);
                $prepare->execute();
            }
            $result = $this->connect->commit();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function thearticleAdminSelectAll(array $user, int $limit = 1000000000000000, int $offset = 0) : array|string
    {
        $sql     = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , LEFT(a.thearticletext,800) AS thearticletext, a.thearticleresume, a.thearticledate, a.thearticleactivate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            GROUP_CONCAT(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            GROUP_CONCAT(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                WHERE a.thearticleactivate = 1 OR (a.theuser_idtheuser = ? && a.thearticleactivate != 2)
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC
                LIMIT ? OFFSET ?;";
        $prepare = $this->connect->prepare($sql);

        try {
            $prepare->bindParam(1, $user["idUser"], PDO::PARAM_INT);
            $prepare->bindParam(2, $limit, PDO::PARAM_INT);
            $prepare->bindParam(3, $offset, PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function thearticleActivate(string $slug, bool $state) : ?string
    {
        $sql     = "UPDATE thearticle SET thearticleactivate = ? WHERE thearticleslug = ?";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindParam(1, $state, PDO::PARAM_INT);
            $prepare->bindParam(2, $slug, PDO::PARAM_STR);
            $prepare->execute();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result ?? null;
    }

    public function thearticleSelectAllByMod(string $type, string|int $mod, array $user, int $limit = 1000000000000000, int $offset = 0) : array|string
    {
        $sql     = "SELECT 
            a.idthearticle, a.thearticletitle, a.thearticleslug , LEFT(a.thearticletext,800) AS thearticletext, a.thearticleresume, a.thearticledate, a.thearticleactivate,
            u.idtheuser, u.theuserlogin,
            (SELECT COUNT(thecomment_idthecomment) FROM thearticle_has_thecomment WHERE thearticle_idthearticle = a.idthearticle) AS nbcomment,
            GROUP_CONCAT(s.thesectiontitle SEPARATOR '|||') AS thesectiontitle, 
            GROUP_CONCAT(s.thesectionslug SEPARATOR '|||') AS thesectionslug
                FROM thearticle a
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                INNER JOIN thesection_has_thearticle sha2
                    ON sha2.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s
                    ON sha2.thesection_idthesection = s.idthesection
                       " . ($type === "s" ? "
                INNER JOIN thesection_has_thearticle sha
                    ON sha.thearticle_idthearticle = a.idthearticle
                INNER JOIN thesection s2
                    ON sha.thesection_idthesection = s2.idthesection" : "") . "
                WHERE (" . ($type === "s" ? "s2.thesectionslug = ?" : "u.idtheuser = ?") . ") AND (a.thearticleactivate = 1 OR (a.theuser_idtheuser = ? && a.thearticleactivate != 2))
                GROUP BY a.idthearticle
                ORDER BY a.thearticledate DESC
                LIMIT ? OFFSET ?;";
        $prepare = $this->connect->prepare($sql);

        try {
            if ($type === "s") {
                $prepare->bindParam(1, $mod, PDO::PARAM_STR);
            }
            else {
                $prepare->bindParam(1, $mod, PDO::PARAM_INT);
            }
            $prepare->bindParam(2, $user["idUser"], PDO::PARAM_INT);
            $prepare->bindParam(3, $limit, PDO::PARAM_INT);
            $prepare->bindParam(4, $offset, PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}