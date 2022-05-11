# NewsWebPrepaTest
Préparation de la base du test sur l'OO dans un modèle MVC en PHP 8

### Gestion du projet:

https://github.com/WebDevCF2m2021/NewsWebPrepaTest/projects/1

## Arborescence

- [Demande du client](https://github.com/mikhawa/NewsWebPrepaTest#voici-la-demande-du-client-pierre-)
- [Installation de Twig](https://github.com/mikhawa/NewsWebPrepaTest#installation-de-twig)
- [Création du système de fichier MVC](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-du-syst%C3%A8me-de-fichier-mvc)
- [Le fichier config.php](https://github.com/mikhawa/NewsWebPrepaTest#le-fichier-configphp)
- [La base de données](https://github.com/mikhawa/NewsWebPrepaTest#la-base-de-donn%C3%A9es)
- [Le contrôleur frontal](https://github.com/mikhawa/NewsWebPrepaTest#le-contr%C3%B4leur-frontal)
- [Le design par défaut du client](https://github.com/mikhawa/NewsWebPrepaTest#le-design-par-d%C3%A9faut-du-client)
- [Les vues pour le design par défaut du client](https://github.com/mikhawa/NewsWebPrepaTest#les-vues-pour-le-design-par-d%C3%A9faut-du-client)
  - [La vue publique pour la homepage](https://github.com/mikhawa/NewsWebPrepaTest#la-vue-publique-pour-la-homepage) 
  - [La vue publique de la page blog](https://github.com/mikhawa/NewsWebPrepaTest#la-vue-publique-de-la-page-blog)
- [Création de notre autoload sur le dossier model](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-de-notre-autoload-sur-le-dossier-model)
- [Création de notre connexion PDO](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-de-notre-connexion-pdo)
- [Création du routeur](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-du-routeur)
- [Création des modèles de mapping de tables](https://github.com/mikhawa/NewsWebPrepaTest#cr%C3%A9ation-des-mod%C3%A8les-de-mapping-de-tables)
    - [La classe abstraite du mapping](https://github.com/mikhawa/NewsWebPrepaTest#la-classe-abstraite-du-mapping)

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
    - Le client souhaiterait que ces articles aient un flux RSS
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

- `public` Le dossier où se trouveront le contrôleur frontal et les fichiers publics dans des sous-dossiers (css, js, images etc ...)
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

Importons en MariaDB la base de données avec les datas depuis

`data/newsweb_v1_structure_datas.sql`

![Structure de la base de donnée](https://github.com/mikhawa/NewsWebPrepaTest/raw/main/data/newswebv1.png "EN")

## Le contrôleur frontal

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Ne contient au départ que l'appel des dépendances et l'instanciation de l'environement `Twig`

    // dependencies
    require_once "../config.php";
    
    // Composer autoload
    require_once '../vendor/autoload.php';
    
    // Twig loader
    $loader = new \Twig\Loader\FilesystemLoader('../view');
    $twig = new \Twig\Environment($loader, [
        //'cache' => '../view/cache',
    ]);



## Le design par défaut du client

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Dans `data` nous avons mis le zip contenant le template par défaut proposé par le client.

Nous allons ensuite mettre les fichiers dans les dossiers `css`, `fonts`, `js` et `images` de ce design dans le dossier `public`, car c'est le seul accès frontend au site.

On va ensuite dézipper ces données dans data pour pouvoir tester le fonctionnement du template par défaut dans

`data/test-default-template`

Nous constatons que celui-ci diffère du modèle donné par le client consultable à cette adresse :

https://partage2021.webdev-cf2m.be/WEB/NewsWeb/sources/

Nous allons donc prendre la source du client et la mettre dans le dossier : 

`data/sources`

Nous allons utiliser la base de `index.html` se trouvant dans ce dossier pour structurer notre vue de l'accueil public.

## Les vues pour le design par défaut du client

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Pour tester le fonctionnement de Twig, nous allons d'abord créer dans `view` la base de toutes nos pages de template :

`view/base.html.twig`

Contenant, en partant de la base nécessaire à toutes les pages du modèle :

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        {% block meta %}
        <meta charset="UTF-8">
        {% endblock %}
        <title>{% block title %}NewsWeb | {% endblock %}</title>
        {% block stylesheets %}{% endblock %}
    </head>
    <body id="{% block pagetype %}{% endblock %}">
    {% block body %}{% endblock %}
    {% block javascripts %}{% endblock %}
    </body>
    </html>

Puis un appel de `render` sur ce fichier depuis `public/index.php` :

    ...
    // test render Twig
    echo $twig->render('base.html.twig');

Nous allons l'étendre pour toutes nos vues publiques dans un autre fichier de template:

`view/public/public.template.html.twig`

Nous allons y charger les dépendances dans les blocs existants (js, css etc... ) et créer les bloques nécessaires pour les pages enfants

    {% extends 'base.html.twig' %}
    ...
    {% block body %}
      <div id="wrapper">
        {# On va créer les différentes zones modifiables du template dans le bloc body #}
        {% block logo %}{% endblock %}
        {% block nav %}{% endblock %}
        {% block slider %}{% endblock %}
        {% block main %}{% endblock %}
        {% block footer %}Ici le footer qui
        restera le même pour tous{% endblock %}
      </div>
    {% endblock %}

Puis un appel de `render` sur ce fichier pour le tester depuis `public/index.php` :

    ...
    // test render Twig
    echo $twig->render('public/public.template.html.twig');


### La vue publique pour la homepage

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Création de la vue homepage :

`view/public/homepage.html.twig`

Contenant les tags `Twig` et le code `html` venant du template de Pierre, tout en mettant le slider en commentaire pour ne pas le voir :

    {% extends 'public/public.template.html.twig' %}
    {% block title %}{{ parent() }} Accueil {% endblock %}
    {% block pagetype %}home{% endblock %}
    ...
    
    {# On va remplir les différentes zones modifiables du template dans le bloc body #}
        {% block logo %}ici{% endblock %}
        {% block nav %}et{% endblock %}
        {% block slider %}<!--aussi-->{% endblock %}
        {% block main %}ici{% endblock %}

Puis un appel de `render` sur ce fichier depuis `public/index.php` :

    ...
    // test render Twig
    echo $twig->render('public/homepage.html.twig');

### La vue publique de la page blog

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Création de la vue blog :

`view/public/blog.html.twig`

contenant le reste de la page :

    {% extends 'public/public.template.html.twig' %}

    {% block title %}{{ parent() }} Liste de nos articles {% endblock %}

    {% block pagetype %}blog{% endblock %}
    ...


## Création de notre autoload sur le dossier model

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Dans `public/index.php` nous allons créer un autoload permettant de charger nos classes qui se trouveront dans `model`

    spl_autoload_register(function($class){
      include_once  '../model/'.$class . '.php';
    });

## Création de notre connexion PDO

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Nous allons créer une connexion PDO personnalisée sous le nom de `MyPDO` dans notre dossier `model`

#### ! Nous donnerons un namespace à nos modèles : `NewsWeb` , et nous l'utiliserons comme nom de dossier pour que l'autoload reste fonctionnel !

`model/NewsWeb/MyPDO.php`

contiendra

    namespace NewsWeb;

    use Exception;
    use PDO;
    
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
        public function query($statement, $mode = PDO::ATTR_DEFAULT_FETCH_MODE, ...$fetch_mode_args): Exception
        {
            // affichage de l'erreur
            throw new Exception("Query est désactivé dans MyPDO, veuillez utiliser une requête préparée");
    
        }
    }

Puis sera appelé depuis le contrôleur frontal :

    ...
    // use NewsWeb MyPDO class
    use NewsWeb\MyPDO;
    ...
    // tentative de connexion à notre DB avec notre classe étendue de PDO : MyPDO
    try {
      $connectMyPDO = new MyPDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET . ';port=' . DB_PORT, DB_LOGIN, DB_PWD, null, PROD);
    } catch (Exception $e) {
      die($e->getMessage());
    }



## Création du routeur

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Nous allons créer un routeur pour pouvoir passer d'une page à l'autre et le charger depuis le contrôleur frontal

`public/index.php`

    ...
    // blog
    if(isset($_GET['blog'])):
      echo $twig->render('public/blog.html.twig');

    // contact
    elseif(isset($_GET['contact'])):
    
        echo $twig->render('public/contact.html.twig');
    // homepage
    else:
      echo $twig->render('public/homepage.html.twig');
    endif;

## Création des modèles de mapping de tables

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

Dans le dossier `model/NewsWeb/`

### La classe abstraite du mapping

[Retour au menu](https://github.com/mikhawa/NewsWebPrepaTest#arborescence)

`model/NewsWeb/AbstractMapping.php`

        namespace NewsWeb;

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

twig extension

    composer require twig/string-extra