<?php

namespace NewsWeb\Manager;

// utilisation de l'interface des Manager
use NewsWeb\Interface\ManagerInterface;
use NewsWeb\MyPDO;
use NewsWeb\Trait\userEntryProtectionTrait;


class thesectionManager implements ManagerInterface
{

    private MyPDO $connect;

    public function __construct(MyPDO $db)
    {
        $this->connect = $db;
    }

    public function SelectAllThesection(): array{
        $prepare = $this->connect->prepare("SELECT idthesection, thesectiontitle, thesectionslug FROM thesection  ORDER BY idthesection ASC;");
        $prepare->execute();
        return $prepare->fetchAll(\PDO::FETCH_ASSOC);
    }


    // ICI



    public function SelectOneThesectionBySlug(string $slug): array|string
    {
        // utilisation du trait de protection
        $slug = userEntryProtectionTrait::userEntryProtection($slug);
        $sql = "SELECT * FROM thesection WHERE thesectionslug=?";
        $prepare = $this->connect->prepare($sql);
        try{
            $prepare->execute([$slug]);
            return $prepare->fetch(\PDO::FETCH_ASSOC);
        }catch(\Exception $e){
            return $e->getMessage();
        }

    }


}