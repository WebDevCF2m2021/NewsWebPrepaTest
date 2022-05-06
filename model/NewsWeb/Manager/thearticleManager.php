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

    public function thearticleSelectAllFromSection(int $idthesection): array|string {
        $sql = "SELECT a.idthearticle, a.thearticletitle, a.thearticleslug , a.thearticleresume, a.thearticledate,
            u.idtheuser, u.theuserlogin
                FROM thearticle a
                INNER JOIN theuser u
                    ON u.idtheuser = a.theuser_idtheuser 
                INNER JOIN thesection_has_thearticle sha
                    ON sha.thearticle_idthearticle = a.idthearticle
                # INNER JOIN thesection s
                #    ON sha.thesection_idthesection = s.idthesection
                WHERE a.thearticleactivate=1 
                        AND u.theuseractivate=1 
                        AND sha.thesection_idthesection=?;
        ";
        $prepare = $this->connect->prepare($sql);

        try{
            $prepare->execute([$idthesection]);
            return $prepare->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

}