<?php

namespace NewsWeb\Manager;

// utilisation de l'interface des Manager
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;

class thesectionManager implements ManagerInterface
{

    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    public function SelectAllThesection(){
        $prepare = $this->connect->prepare("SELECT idthesection, thesectiontitle, thesectionslug FROM thesection  ORDER BY idthesection ASC;");
        $prepare->execute();
        return $prepare->fetchAll(\PDO::FETCH_ASSOC);
    }

}