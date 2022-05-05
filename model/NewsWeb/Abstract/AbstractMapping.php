<?php

namespace NewsWeb\Abstract;

class AbstractMapping
{
// constructeur - Appelé lors de l'instanciation
    public function __construct(array $tab)
    {
        // tentative d'hydration des données de Personnage
        $this->hydrate($tab);
    }

    // création de notre hydratation, en partant d'un tableau associatif et de ses clefs, on va régénérer le nom des setters existants
    protected function hydrate(array $assoc)
    {
        // tant qu'on a des éléments dans le tableau
        foreach ($assoc as $clef => $valeur) {
            // création du nom de la méthode
            $methodeName = "set" . ucfirst($clef);
            // si la méthode existe
            if (method_exists($this, $methodeName)) {
                $this->$methodeName($valeur);
            }
        }
    }
}