# NewsWebPrepaTest
Préparation de la base du test sur l'OO dans un modèle MVC en PHP 8

## Arborescence

- [Demande du client](https://github.com/mikhawa/NewsWebPrepaTest#voici-la-demande-du-client-pierre-)
- [Installation de Twig](https://github.com/mikhawa/NewsWebPrepaTest#installation-de-twig)
- [Création du système de fichier MVC](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-du-syst%C3%A8me-de-fichier-mvc)
- [Le fichier config.php](https://github.com/mikhawa/NewsWebPrepaTest#le-fichier-configphp)
- [La base de données](https://github.com/mikhawa/NewsWebPrepaTest#la-base-de-donn%C3%A9es)
- Le contrôleur frontal
- Le design par défaut du client

## Voici la demande du client (Pierre) :

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

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

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Vérifiez d'abord que vous utilisez PHP 8 et que composer soit installé et à jour :

    composer self-update

Nous utiliserons Twig 3 comme moteur de templates :

    composer require "twig/twig:^3.0"

Et pour l'installer depuis `composer.json` :

    composer update

## Création du système de fichier MVC

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

- `public` Le dossier où se trouveront le contrôleur frontal et les fichiers publics (css, js, images etc ...)
- `controller` Le dossier contenant nos contrôleurs
- `model` Le dossier contenant nos classes personnelles
- `view` Le dossier contenant nos vues `twig`
- `data` Le dossier contenant les fichiers utiles pour la création du site, les fichiers sql seront modifiés lors de la mise en production pour éviter le piratage du site.

La racine contiendra les fichiers de configurations.

## Le fichier config.php

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Le fichier `config.php` devra être récréé à la racine en copiant et en renommant `config.php.ini`.

Ce fichier contient des données sensibles et ne sera pas mis sur github pour des raisons de sécurité.

## La base de données

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

## Le contrôleur frontal

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

## Le design par défaut du client

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

