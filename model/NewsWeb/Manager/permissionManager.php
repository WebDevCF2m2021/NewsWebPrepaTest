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
}