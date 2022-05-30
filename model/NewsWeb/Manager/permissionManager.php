<?php

namespace NewsWeb\Manager;

use Exception;
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;
use PDO;

class permissionManager implements ManagerInterface
{
    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    public function permissionSelectAll() : array|string
    {
        $sql     = "SELECT * FROM permission";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->execute();
            $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function permissionSelectOneById(int $id) : array|string
    {
        $sql     = "SELECT * FROM permission WHERE idpermission = ?";
        $prepare = $this->connect->prepare($sql);
        try {
            $prepare->bindParam(1, $id, PDO::PARAM_INT);
            $prepare->execute();
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}