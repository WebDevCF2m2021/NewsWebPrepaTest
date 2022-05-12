<?php

namespace NewsWeb;

use \Exception;
use \PDO;

class MyPDO extends PDO
{
    // surcharge du constructeur avec l'ajout de l'argument $production
    public function __construct(string $dsn, string|null $username, string|null $password, array|null $options, bool $production = true)
    {
        // chargement du constructeur parent (qui vient de PDO)
        parent::__construct($dsn, $username, $password, $options);

        // si nous sommes en production
        if ($production) {
            // nous désactivons l'affichage d'erreur
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        }
    }

    // écrasement du query venant du parent (PDO)

    /**
     * @throws Exception
     */
    public function query($statement, $mode = PDO::ATTR_DEFAULT_FETCH_MODE, ...$fetch_mode_args): Exception
    {
        // affichage de l'erreur
        throw new Exception("Query est désactivé dans MyPDO, veuillez utiliser une requête préparée");

    }
}