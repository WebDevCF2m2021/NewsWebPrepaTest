# NewsWebPrepaTest
Préparation de la base du test sur l'OO dans un modèle MVC en PHP 8

## Arborescence

- Demande du client
- [Installation de Twig](https://github.com/mikhawa/NewsWebPrepaTest#installation-de-twig)

## Voici la demande du client (Pierre) :


    Les news du Web

    Il s’agit de réaliser un site qui affiche des nouvelles concernant le Web ou l’informatique en général.
    Il se présente sous la forme d’un journal.
    Chaque nouvelle, est un résumé d'article qui affiche :
    - le titre
    - la date et heure de publication
    - le nom de l’auteur
    - le début du texte (les 100 premiers caractères) avec possibilité de voir ensuite le texte complet sur
    une autre page
    Il y a un menu de navigation sur chaque page, avec :
    - un lien vers l’accueil
    - un lien vers la page affichant tous les articles
    - un lien vers un espace d’administration avec login/mot de passe
    Il y a :
    - une page d’accueil affichant les 3 dernières news (les 3 plus récentes).
    - une page affichant tous les extraits d'articles classés par date (du plus récent au plus ancien)
    Le client a choisi le graphisme :
    https://www.free-css.com/free-css-templates/page183/sourcexsrt
    Il doit être adapté pour être responsive.

    Version 1
    
    Sur la page d’accueil, la nouvelle la plus récente est mise en évidence (par exemple : en premier ou
    encadrée ou dans une zone plus large, à définir).
    Les articles doivent être lus, ajoutés, modifiés et supprimés via un CRUD

Et voici les liens vers le design frontend et backend qu'il nous a fourni :

https://partage2021.webdev-cf2m.be/WEB/NewsWeb/

https://github.com/WebFormP/NewsWeb

https://github.com/WebFormP/AdminNewsWeb

https://github.com/WebFormP/NewsWeb_PHP

## Installation de Twig

Vérifiez d'abord que vous utilisez PHP 8 et que composer soit installé et à jour:

    composer self-update

Nous utiliserons Twig 3 comme moteur de templates :

    composer require "twig/twig:^3.0"

Et pour l'installer depuis `composer.json` :

    composer update

