<?php

namespace NewsWeb\Manager;

use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;

class thecommentManager implements ManagerInterface
{
    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    public function thecommentSelectAllByIdArticle($id) : array|string
    {
        $sql     = "SELECT c.idthecomment, c.thecommenttext, c.thecommentdate, u.theuserlogin, u.idtheuser
                    FROM thecomment c
                    INNER JOIN theuser u
                    ON c.theuser_idtheuser = u.idtheuser
                    INNER JOIN thearticle_has_thecomment hac
                    ON c.idthecomment = hac.thecomment_idthecomment 
                    INNER JOIN thearticle a 
                    ON hac.thearticle_idthearticle = a.idthearticle
                    WHERE a.idthearticle = ? AND c.thecommentactive = 1
                    ORDER BY c.thecommentdate DESC;";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindParam(1, $id, \PDO::PARAM_INT);
            $prepare->execute();
            $result = $prepare->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}