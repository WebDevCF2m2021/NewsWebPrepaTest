-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : dim. 29 mai 2022 à 06:45
-- Version du serveur : 10.5.13-MariaDB
-- Version de PHP : 8.0.13

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `newsweb`
--
DROP DATABASE IF EXISTS `newsweb`;
CREATE DATABASE IF NOT EXISTS `newsweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `newsweb`;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission`
(
    `idpermission`   tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    `permissionname` varchar(45)         NOT NULL,
    `permissionrole` tinyint(3) UNSIGNED NOT NULL COMMENT '0 => admin\n1 => contributor\n2 => commentator',
    PRIMARY KEY (`idpermission`),
    UNIQUE KEY `permissionname_UNIQUE` (`permissionname`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idpermission`, `permissionname`, `permissionrole`)
VALUES (1, 'Administrateur', 0),
       (2, 'Rédacteur', 1),
       (3, 'Membre', 2);

-- --------------------------------------------------------

--
-- Structure de la table `thearticle`
--

DROP TABLE IF EXISTS `thearticle`;
CREATE TABLE IF NOT EXISTS `thearticle`
(
    `idthearticle`       int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `thearticletitle`    varchar(120)     NOT NULL,
    `thearticleslug`     varchar(120)     NOT NULL,
    `thearticleresume`   varchar(250)     NOT NULL,
    `thearticletext`     text             NOT NULL,
    `thearticledate`     datetime         DEFAULT current_timestamp(),
    `thearticleactivate` tinyint(4)       DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
    `theuser_idtheuser`  int(10) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`idthearticle`),
    UNIQUE KEY `thearticleslug_UNIQUE` (`thearticleslug`),
    KEY `fk_thearticle_theuser1_idx` (`theuser_idtheuser`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `thearticle`
--

INSERT INTO `thearticle` (`idthearticle`, `thearticletitle`, `thearticleslug`, `thearticleresume`, `thearticletext`,
                          `thearticledate`, `thearticleactivate`, `theuser_idtheuser`)
VALUES (1, 'Quoi de neuf dans PHP 8.1 : Fonctionnalités, changements, améliorations et plus encore',
        'quoi-de-neuf-dans-php-8-1-fonctionnalites-changements-ameliorations-et-plus-encore',
        'Types d’intersection purs\r\nPHP 8.1 ajoute la prise en charge des types d’intersection. C’est similaire aux types d’union introduits dans PHP 8.0, mais leur utilisation prévue est exactement l’inverse.\r\n\r\nPour mieux comprendre son utilisati',
        'Types d’intersection purs\r\nPHP 8.1 ajoute la prise en charge des types d’intersection. C’est similaire aux types d’union introduits dans PHP 8.0, mais leur utilisation prévue est exactement l’inverse.\r\n\r\nPour mieux comprendre son utilisation, rafraîchissons la façon dont les déclarations de type fonctionnent en PHP.\r\n\r\nEssentiellement, vous pouvez ajouter des déclarations de type aux arguments des fonctions, aux valeurs de retour et aux propriétés des classes. Cette affectation est appelée indication de type et garantit que la valeur est du bon type au moment de l’appel. Sinon, une TypeError est immédiatement émise. En retour, cela vous aide à mieux déboguer le code.\r\n\r\nCependant, la déclaration d’un type uniques a ses limites. Les types d’union vous aident à surmonter cela en vous permettant de déclarer une valeur avec plusieurs types, et l’entrée doit satisfaire au moins un des types déclarés.\r\n\r\nD’autre part, la RFC décrit les types d’intersection comme ceci :\r\n\r\nUn « type d’intersection » exige qu’une valeur satisfasse plusieurs contraintes de type au lieu d’une seule.\r\n\r\n…les types d’intersection purs sont spécifiés à l’aide de la syntaxe T1&amp;T2&amp;… et peuvent être utilisés dans toutes les positions où les types sont actuellement acceptés…\r\n\r\nNotez l’utilisation de l’opérateur &amp; (AND) pour déclarer les types d’intersection. En revanche, nous utilisons l’opérateur | (OR) pour déclarer les types d’union.\r\n\r\nL’utilisation de la plupart des types standard dans un type d’intersection donnera un type qui ne pourra jamais être rempli (par exemple, integer et string). Par conséquent, les types d’intersection ne peuvent inclure que des types de classe (c’est-à-dire des interfaces et des noms de classe).\r\n\r\nVoici un exemple de code montrant comment vous pouvez utiliser les types d’intersection :\r\n&lt;pre&gt;\r\nclasse A {\r\n    private Traversable&amp;Countable $countableIterator;\r\n \r\n    public function setIterator(Traversable&amp;Countable $countableIterator) : void {\r\n        $this-&gt;countableIterator = $countableIterator;\r\n    }\r\n \r\n    public function getIterator() : Traversable&amp;Countable {\r\n        retourne $this-&gt;countableIterator;\r\n    }\r\n}&lt;/pre&gt;\r\nDans le code ci-dessus, nous avons défini une variable countableIterator comme une intersection de deux types : Traversable et Countable. Dans ce cas, les deux types déclarés sont des interfaces.\r\n\r\nLes types d’intersection sont également conformes aux règles standard de variance PHP déjà utilisées pour la vérification des types et l’héritage. Mais il existe deux règles supplémentaires concernant la façon dont les types d’intersection interagissent avec le sous-typage. Vous pouvez en savoir plus sur les règles de variance des types d’intersection dans sa RFC.\r\n\r\nDans certains langages de programmation, vous pouvez combiner les types Union et les types Intersection dans la même déclaration. Mais PHP 8.1 l’interdit. C’est pourquoi sa mise en œuvre est appelée types d’intersection « purs ». Cependant, la RFC mentionne que c’est « laissé comme une scope future »\r\n\r\nEnums\r\nPHP 8.1 ajoute enfin la prise en charge des enums (également appelés énumérations ou types énumérés). Il s’agit d’un type de données défini par l’utilisateur, composé d’un ensemble de valeurs possibles.\r\n\r\nL’exemple d’énumération le plus courant dans les langages de programmation est le type booléen, avec true et false comme deux valeurs possibles. C’est tellement courant qu’il est intégré dans de nombreux langages de programmation modernes.\r\n\r\nConformément à la RFC, les énumérations en PHP seront limitées aux « énumérations d’unités » au départ :\r\n\r\nLa portée de cette RFC est limitée aux « énumérations d’unités », c’est-à-dire aux énumérations qui sont elles-mêmes une valeur, plutôt qu’une simple syntaxe fantaisiste pour une constante primitive, et qui n’incluent pas d’informations associées supplémentaires. Cette capacité offre une prise en charge considérablement élargie pour la modélisation des données, les définitions de types personnalisées et le comportement de style monade. Les Enums permettent la technique de modélisation consistant à « rendre les états non valides irreprésentables », ce qui conduit à un code plus robuste nécessitant moins de tests exhaustifs.\r\n\r\nPour arriver à ce stade, l’équipe PHP a étudié de nombreux langages qui prennent déjà en charge les énumérations. Leur étude a révélé que l’on peut classer les énumérations en trois groupes généraux : Constantes fantaisistes, objets fantaisistes et types de données algébriques (ADT) complets. C’est une lecture intéressante !\r\n\r\nPHP implémente les énumérations « Fancy Objects », et prévoit de les étendre aux ADT complets à l’avenir. Il est conceptuellement et sémantiquement modelé sur les types énumérés de Swift, Rust et Kotlin, bien qu’il ne soit pas directement modelé sur aucun d’entre eux.\r\n\r\nLa RFC utilise la célèbre analogie des couleurs dans un jeu de cartes pour expliquer son fonctionnement :\r\n&lt;pre&gt;\r\nenum Suit {\r\ncase Hearts;\r\ncase Diamonds;\r\ncase Clubs;\r\ncase Spades;&lt;/pre&gt;\r\n\r\nIci, l’enum Suit définit quatre valeurs possibles : Hearts, Diamonds, Clubs et Spades. Vous pouvez accéder directement à ces valeurs en utilisant la syntaxe : Suit::Hearts, Suit::Diamonds, Suit::Clubs, et Suit::Spades.\r\n\r\nCette utilisation peut vous sembler familière, car les enums sont construits au-dessus des classes et des objets. Ils se comportent de manière similaire et ont presque les mêmes exigences. Les enums partagent les mêmes espaces de noms que les classes, les interfaces et les traits.\r\n\r\nLes enums mentionnés ci-dessus sont appelés Pure Enums.\r\n\r\nVous pouvez aussi définir des Enums Backed si vous voulez donner une valeur scalaire équivalente à n’importe quel cas. Cependant, les backed enums ne peuvent avoir qu’un seul type, soit int soit string (jamais les deux).\r\n&lt;pre&gt;\r\nenum Suit: string {\r\ncase Hearts = &#039;H&#039;;\r\ncase Diamonds = &#039;D&#039;;\r\ncase Clubs = &#039;C&#039;;\r\ncase Spades = &#039;S&#039;;\r\n}&lt;/pre&gt;\r\nDe plus, tous les différents cas d’un backed enum doivent avoir une valeur unique. Et vous ne pouvez jamais mélanger les enums purs et backed.\r\n\r\nLa RFC approfondit les méthodes d’énumération, les méthodes statiques, les constantes, les expressions constantes et bien plus encore. Les couvrir tous dépasse le cadre de cet article. Vous pouvez vous référer à la documentation pour vous familiariser avec toutes ses qualités.\r\n\r\nLe type de retour never\r\nPHP 8.1 ajoute un nouvel indice de type de retour appelé never. C’est très utile pour les fonctions throw ou exit.\r\n\r\nSelon la RFC, les fonctions de redirection d’URL exit (explicitement ou implicitement) sont un bon exemple de son utilisation :\r\n&lt;pre&gt;\r\nfunction redirect(string $uri) : never {\r\n    header(&#039;Location : &#039; . $uri) ;\r\n    exit() ;\r\n}\r\n \r\nfonction redirectToLoginPage() : never {\r\n    redirect(&#039;/login&#039;);\r\n}&lt;/pre&gt;\r\n\r\nUne fonction déclarée never doit satisfaire trois conditions :\r\n\r\nL’instruction return ne doit pas être définie explicitement.\r\nL’instruction return ne doit pas être définie implicitement (par exemple, les instructions if-else).\r\nElle doit terminer son exécution avec une déclaration exit (explicitement ou implicitement).\r\nL’exemple de redirection d’URL ci-dessus montre une utilisation à la fois explicite et implicite du type de retour never.\r\n\r\nLe type never return partage de nombreuses similitudes avec le type void return. Ils garantissent tous deux que la fonction ou la méthode ne renvoie pas de valeur. Cependant, il diffère en appliquant des règles plus strictes. Par exemple, une fonction déclarée void peut toujours return sans valeur explicite, mais vous ne pouvez pas faire la même chose avec une fonction déclarée never.\r\n\r\nEn règle générale, utilisez void lorsque vous voulez que PHP continue à s’exécuter après l’appel de la fonction. Choisissez never lorsque vous voulez le contraire.\r\n\r\nDe plus, never est défini comme un type « inférieur ». Par conséquent, toute méthode de classe déclarée never ne peut « jamais » changer son type de retour en quelque chose d’autre. Cependant, vous pouvez étendre une méthode déclarée void avec une méthode déclarée never.\r\n\r\nInfo\r\nLa RFC originale indique le type de retour never comme noreturn, qui était un type de retour déjà pris en charge par deux outils d’analyse statique de PHP, à savoir Psalm et PHPStan. Comme il a été proposé par les auteurs de Psalm et PHPStan eux-mêmes, ils ont conservé sa terminologie. Cependant, en raison des conventions de nommage, l’équipe PHP a réalisé un sondage sur noreturn vs never, dont never est sorti vainqueur. Par conséquent, pour les versions PHP 8.1+, remplace toujours noreturn par never.',
        '2022-05-06 14:29:57', 1, 2),
       (2, 'Javascript : Héritage et chaîne de prototype', 'javascript-heritage-et-chaine-de-prototype',
        'JavaScript peut prêter à confusion lorsqu\'on est habitué à manipuler des langages de programmation manipulant les classes (tels que Java ou C++).',
        'JavaScript peut prêter à confusion lorsqu\'on est habitué à manipuler des langages de programmation manipulant les classes (tels que Java ou C++).\r\n\r\nEn effet, JavaScript est un langage dynamique et ne possède pas de concept de classe à part entière (le mot-clé class a certes été ajouté avec ES2015 mais il s\'agit uniquement de sucre syntaxique, JavaScript continue de reposer sur l\'héritage prototypique).\r\n\r\nEn ce qui concerne l\'héritage, JavaScript n\'utilise qu\'une seule structure : les objets. Chaque objet possède une propriété privée qui contient un lien vers un autre objet appelé le prototype. \r\n\r\nCe prototype possède également son prototype et ainsi de suite, jusqu\'à ce qu\'un objet ait null comme prototype. Par définition, null ne possède pas de prototype et est ainsi le dernier maillon de la chaîne de prototype.\r\n\r\nLa majorité des objets JavaScript sont des instances de Object qui est l\'avant dernier maillon de la chaîne de prototype.\r\n\r\nBien que cette confusion (entre classe et prototype) soit souvent avancée comme l\'une des faiblesses de JavaScript, le modèle prototypique est plus puissant que le modèle classique et il est notamment possible de construire un modèle classique à partir d\'un modèle prototypique.\r\n\r\n<h3>Héritage et chaîne de prototype</h3>\r\n<h4>Propriété héritées</h4>\r\nLes objets JavaScript sont des ensembles dynamiques de propriétés (les propriétés directement rattachées à un objet sont appelées propriétés en propre (own properties)). \r\n\r\nLes objets JavaScript possèdent également un lien vers un objet qui est leur prototype. Lorsqu\'on tente d\'accéder aux propriétés d\'un objet, la propriété sera recherchée d\'abord sur l\'objet même, puis sur son prototype, puis sur le prototype du prototype et ainsi de suite jusqu\'à ce qu\'elle soit trouvée ou que la fin de la chaîne de prototype ait été atteinte.\r\n\r\n<pre>let f = function () {\r\n   this.a = 1;\r\n   this.b = 2;\r\n}\r\nlet o = new f(); // {a: 1, b: 2}\r\n\r\n// on ajoute des propriétés au prototype de la fonction\r\n// f\r\nf.prototype.b = 3;\r\nf.prototype.c = 4;</pre>',
        '2022-05-09 15:30:50', 1, 2),
       (3, 'Programmation orientée objet', 'programmation-orientee-objet',
        'La programmation orientée objet (POO), ou programmation par objet, est un paradigme de programmation informatique.',
        'La programmation orientée objet (POO), ou programmation par objet, est un paradigme de programmation informatique. \r\n\r\nElle consiste en la définition et l\'interaction de briques logicielles appelées objets ; un objet représente un concept, une idée ou toute entité du monde physique, comme une voiture, une personne ou encore une page d\'un livre. \r\n\r\nIl possède une structure interne et un comportement, et il sait interagir avec ses pairs. Il s\'agit donc de représenter ces objets et leurs relations ; l\'interaction entre les objets via leurs relations permet de concevoir et réaliser les fonctionnalités attendues, de mieux résoudre le ou les problèmes. \r\n\r\nDès lors, l\'étape de modélisation revêt une importance majeure et nécessaire pour la POO. C\'est elle qui permet de transcrire les éléments du réel sous forme virtuelle.\r\n\r\nLa programmation par objet consiste à utiliser des techniques de programmation pour mettre en œuvre une conception basée sur les objets. \r\n\r\nCelle-ci peut être élaborée en utilisant des méthodologies de développement logiciel objet, dont la plus connue est le processus unifié (« Unified Software Development Process » en anglais), et exprimée à l\'aide de langages de modélisation tels que le Unified Modeling Language (UML).\r\n\r\nLa programmation orientée objet est facilitée par un ensemble de technologies dédiés :\r\n\r\nles langages de programmation (chronologiquement : Simula, LOGO, Smalltalk, Ada, C++, Objective C, Eiffel, Python, PHP, Java, Ruby, AS3, C#, VB.NET, Fortran 2003, Vala, Haxe, Swift) ;\r\nles outils de modélisation qui permettent de concevoir sous forme de schémas semi-formels la structure d\'un programme (Objecteering, UMLDraw, Rhapsody, DBDesigner…) ;\r\nles bus distribués (DCOM, CORBA, RMI, Pyro…) ;\r\n\r\nles ateliers de génie logiciel ou AGL (Visual Studio pour des langages Dotnet, NetBeans ou Eclipse pour le langage Java).\r\nIl existe actuellement deux grandes catégories de langages à objets :\r\n\r\nles langages à classes, que ceux-ci soient sous forme fonctionnelle (Common Lisp Object System), impérative (C++, Java) ou les deux (Python, OCaml) ;\r\nles langages à prototypes (JavaScript, Lua).\r\n\r\nEn implantant les Record Class de Hoare, le langage Simula 67 pose les constructions qui seront celles des langages orientés objet à classes : classe, polymorphisme, héritage, etc. Mais c\'est réellement par et avec Smalltalk 71 puis Smalltalk 80, inspiré en grande partie par Simula 67 et Lisp, que les principes de la programmation par objets, résultat des travaux d\'Alan Kay, sont véhiculés : objet, encapsulation, messages, typage et polymorphisme (via la sous-classification) ; les autres principes, comme l\'héritage, sont soit dérivés de ceux-ci ou une implantation. Dans Smalltalk, tout est objet, même les classes. Il est aussi plus qu\'un langage à objets, c\'est un environnement graphique interactif complet.\r\n\r\nÀ partir des années 1980, commence l\'effervescence des langages à objets : C++ (1983), Objective-C (1984), Eiffel (1986), Common Lisp Object System (1988), etc. Les années 1990 voient l\'âge d\'or de l\'extension de la programmation par objets dans les différents secteurs du développement logiciel.\r\n\r\nDepuis, la programmation par objets n\'a cessé d\'évoluer aussi bien dans son aspect théorique que pratique et différents métiers et discours mercatiques à son sujet ont vu le jour :\r\n\r\nl\'analyse objet (AOO ou OOA en anglais) ;\r\nla conception objet (COO ou OOD en anglais) ;\r\nles bases de données objet (SGBDOO) ;\r\nles langages objets avec les langages à prototypes ;\r\nou encore la méthodologie avec MDA (Model Driven Architecture).\r\nAujourd\'hui, la programmation par objets est vue davantage comme un paradigme, le paradigme objet, que comme une simple technique de programmation. C\'est pourquoi, lorsque l\'on parle de nos jours de programmation par objets, on désigne avant tout la partie codage d\'un modèle à objets obtenu par AOO et COO.\r\n\r\nLa programmation orientée objet a été introduite par Alan Kay avec Smalltalk. Toutefois, ses principes n\'ont été formalisés que pendant les années 1980 et, surtout, 1990. Par exemple le typage de second ordre, qui qualifie le typage de la programmation orientée objet (appelé aussi duck typing), n\'a été formulé qu\'en 1995 par Cook.\r\n\r\nConcrètement, un objet est une structure de données qui répond à un ensemble de messages. Cette structure de données définit son état tandis que l\'ensemble des messages qu\'il comprend décrit son comportement :\r\n\r\nles données, ou champs, qui décrivent sa structure interne sont appelées ses attributs ;\r\nl\'ensemble des messages forme ce que l\'on appelle l\'interface de l\'objet ; c\'est seulement au travers de celle-ci que les objets interagissent entre eux. La réponse à la réception d\'un message par un objet est appelée une méthode (méthode de mise en œuvre du message) ; elle décrit quelle réponse doit être donnée au message.\r\nCertains attributs et/ou méthodes (ou plus exactement leur représentation informatique) sont cachés : c\'est le principe d\'encapsulation. Ainsi, le programme peut modifier la structure interne des objets ou leurs méthodes associées sans avoir d\'impact sur les utilisateurs de l\'objet.\r\n\r\nUn exemple avec un objet représentant un nombre complexe : celui-ci peut être représenté sous différentes formes (cartésienne (réel, imaginaire), trigonométrique, exponentielle (module, angle)). Cette représentation reste cachée et est interne à l\'objet. L\'objet propose des messages permettant de lire une représentation différente du nombre complexe. En utilisant les seuls messages que comprend notre nombre complexe, les objets appelants sont assurés de ne pas être affectés lors d\'un changement de sa structure interne. Cette dernière n\'est accessible que par les méthodes des messages.\r\n\r\nDans la programmation par objets, chaque objet est typé. Le type définit la syntaxe (« Comment l\'appeler ? ») et la sémantique des messages (« Que fait-il ? ») auxquels peut répondre un objet. Il correspond donc, à peu de chose près, à l\'interface de l\'objet. Toutefois, la plupart des langages objets ne proposent que la définition syntaxique d\'un type (C++, Java, C#…) et rares sont ceux qui fournissent aussi la possibilité de définir formellement sa sémantique (comme dans le langage Eiffel avec sa conception par contrats).\r\n\r\nUn objet peut appartenir à plus d\'un type : c\'est le polymorphisme ; cela permet d\'utiliser des objets de types différents là où est attendu un objet d\'un certain type. Une façon de réaliser le polymorphisme est le sous-typage (appelé aussi héritage de type) : on raffine un type-parent en un autre type (le sous-type) par des restrictions sur les valeurs possibles des attributs. Ainsi, les objets de ce sous-type sont conformes au type parent. De ceci découle le principe de substitution de Liskov. Toutefois, le sous-typage est limité et ne permet pas de résoudre le problème des types récursifs (un message qui prend comme paramètre un objet du type de l\'appelant). Pour résoudre ce problème, Cook définit en 1995 la sous-classification et le typage du second ordre qui régit la programmation orientée objet : le type est membre d\'une famille polymorphique à point fixe de types (appelée classe). Les traits sont une façon de représenter explicitement les classes de types. (La représentation peut aussi être implicite comme avec Smalltalk, Ruby, etc.).\r\n\r\nOn distingue dans les langages objets deux mécanismes du typage :\r\n\r\nle typage dynamique : le type des objets est déterminé à l\'exécution lors de la création desdits objets (Smalltalk, Common Lisp, Python, PHP…) ;\r\nle typage statique : le type des objets est vérifié à la compilation et est soit explicitement indiqué par le développeur lors de leur déclaration (C++, Java, C#, Pascal…), soit déterminé par le compilateur à partir du contexte (Scala, OCaml…).\r\nDe même, deux mécanismes de sous-typage existent : l\'héritage simple (Smalltalk, Java, C#) et l\'héritage multiple (C++, Python, Common Lisp, Eiffel, WLangage).\r\n\r\nLe polymorphisme ne doit pas être confondu avec le sous-typage ou avec l\'attachement dynamique (dynamic binding en anglais).\r\n\r\nLa programmation objet permet à un objet de raffiner la mise en œuvre d\'un message défini pour des objets d\'un type parent, autrement dit de redéfinir la méthode associée au message : c\'est le principe de redéfinition des messages (ou overriding en anglais).\r\n\r\nOr, dans une définition stricte du typage (typage du premier ordre), l\'opération résultant d\'un appel de message doit être la même quel que soit le type exact de l\'objet référé. Ceci signifie donc que, dans le cas où l\'objet référé est de type exact un sous-type du type considéré dans l\'appel, seule la méthode du type père est exécutée :\r\n\r\nSoit un type Reel contenant une méthode * faisant la multiplication de deux nombres réels, soient Entier un sous-type de Reel, i un Entier et r un Reel, alors l\'instruction i * r va exécuter la méthode * de Reel. On pourrait appeler celle de Entier grâce à une redéfinition.\r\n\r\nPour réaliser alors la redéfinition, deux solutions existent :\r\n\r\nle typage du premier ordre associé à l\'attachement dynamique (c\'est le cas de C++, Java, C#…). Cette solution induit une faiblesse dans le typage et peut conduire à des erreurs. Les relations entre type sont définies par le sous-typage (théorie de Liskov) ;\r\nle typage du second ordre (duquel découlent naturellement le polymorphisme et l\'appel de la bonne méthode en fonction du type exact de l\'objet). Ceci est possible avec Smalltalk et Eiffel. Les relations entre types sont définies par la sous-classification (théorie F-Bound de Cook).\r\n\r\nLa structure interne des objets et les messages auxquels ils répondent sont définis par des modules logiciels. Ces mêmes modules créent les objets via des opérations dédiées. Deux représentations existent de ces modules : la classe et le prototype.\r\n\r\nLa classe est une structure informatique particulière dans le langage objet. Elle décrit la structure interne des données et elle définit les méthodes qui s\'appliqueront aux objets de même famille (même classe) ou type. Elle propose des méthodes de création des objets dont la représentation sera donc celle donnée par la classe génératrice. Les objets sont dits alors instances de la classe. C\'est pourquoi les attributs d\'un objet sont aussi appelés variables d\'instance et les messages opérations d\'instance ou encore méthodes d\'instance. L\'interface de la classe (l\'ensemble des opérations visibles) forme les types des objets. Selon le langage de programmation, une classe est soit considérée comme une structure particulière du langage, soit elle-même comme un objet (objet non-terminal). Dans le premier cas, la classe est définie dans le runtime ; dans l\'autre, la classe a besoin elle aussi d\'être créée et définie par une classe : ce sont les méta-classes. L\'introspection des objets (ou « méta-programmation ») est définie dans ces méta-classes.\r\n\r\nLa classe peut être décrite par des attributs et des messages. Ces derniers sont alors appelés, par opposition aux attributs et messages d\'un objet, variables de classe et opérations de classe ou méthodes de classe. Parmi les langages à classes on retrouve Smalltalk, C++, C#, Java, etc.\r\n\r\nLe prototype est un objet à part entière qui sert de prototype de définition de la structure interne et des messages. Les autres objets de mêmes types sont créés par clonage. Dans le prototype, il n\'y a plus de distinction entre attributs et messages : ce sont tous des slots. Un slot est un label de l\'objet, privé ou public, auquel est attachée une définition (ce peut être une valeur ou une opération). Cet attachement peut être modifié à l\'exécution. Chaque ajout d\'un slot influence l\'objet et l\'ensemble de ses clones. Chaque modification d\'un slot est locale à l\'objet concerné et n\'affecte pas ses clones.\r\n\r\nLe concept de trait permet de modifier un slot sur un ensemble de clones. Un trait est un ensemble d\'opérations de même catégorie (clonage, persistance, etc.) transverse aux objets. Il peut être représenté soit comme une structure particulière du langage, comme un slot dédié ou encore comme un prototype. L\'association d\'un objet à un trait fait que l\'objet et ses clones sont capables de répondre à toutes les opérations du trait. Un objet est toujours associé à au moins un trait, et les traits sont les parents des objets (selon une relation d\'héritage). Un trait est donc un mixin doté d\'une parenté. Parmi les langages à prototype on trouve Javascript, Self, Io, Slater, Lisaac, etc.\r\n\r\nDifférents langages utilisent la programmation orientée objet, par exemple PHP, Python, etc.\r\n\r\nEn PHP la programmation orientée objet est souvent utilisée pour mettre en place une architecture MVC (Modèle Vue Contrôleur), où les modèles représentent des objets.\r\n\r\nLa modélisation objet consiste à créer un modèle du système informatique à réaliser. Ce modèle représente aussi bien des objets du monde réel que des concepts abstraits propres au métier ou au domaine dans lequel le système sera utilisé.\r\n\r\nLa modélisation objet commence par la qualification de ces objets sous forme de types ou de classes sous l\'angle de la compréhension des besoins et indépendamment de la manière dont ces classes seront mises en œuvre. C\'est ce que l\'on appelle l\'analyse orientée objet ou OOA (acronyme de « Object-Oriented Analysis »). Ces éléments sont alors enrichis et adaptés pour représenter les éléments de la solution technique nécessaires à la réalisation du système informatique. C\'est ce que l\'on appelle la conception orientée objet ou OOD (acronyme de « Object-Oriented Design »). À un modèle d\'analyse peuvent correspondre plusieurs modèles de conception. L\'analyse et la conception étant fortement interdépendants, on parle également d\'analyse et de conception orientée objet (OOAD). Une fois un modèle de conception établi, il est possible aux développeurs de lui donner corps dans un langage de programmation. C\'est ce que l\'on appelle la programmation orientée objet ou OOP (en anglais « Object-Oriented Programming »).\r\n\r\nPour écrire ces différents modèles, plusieurs langages et méthodes ont été mis au point. Ces langages sont pour la plupart graphiques. Les trois principaux à s\'imposer sont OMT de James Rumbaugh, la méthode Booch de Grady Booch et OOSE de Ivar Jacobson. Toutefois, ces méthodes ont des sémantiques différentes et ont chacune des particularités qui les rendent particulièrement aptes à certains types de problèmes. \r\n\r\nOMT offre ainsi une modélisation de la structure de classes très élaborée. Booch a des facilités pour la représentation des interactions entre les objects. OOSE innove avec les cas d\'utilisation pour représenter le système dans son environnement. La méthode OMT prévaut sur l\'ensemble des autres méthodes au cours de la première partie de la décennie 1990.\r\n\r\nÀ partir de 1994, Booch et Jacobson, rapidement rejoints par Rumbaugh, décident d\'unifier leurs approches au sein d\'une nouvelle méthode qui soit suffisamment générique pour pouvoir s\'appliquer à la plupart des contextes applicatifs. Ils commencent par définir le langage de modélisation UML (Unified Modeling Language) appelé à devenir un standard de l\'industrie. Le processus de normalisation est confié à l\'Object Management Group (OMG), un organisme destiné à standardiser des technologies orientées objet comme CORBA (acronyme de « Common Object Request Broker Architecture »), un intergiciel (« middleware » en anglais) objet réparti.\r\n\r\n Rumbaugh, Booch et Jacobson s\'affairent également à mettre au point une méthode permettant d\'une manière systématique et répétable d\'analyser les exigences et de concevoir et mettre en œuvre une solution logicielle à l\'aide de modèles UML. Cette méthode générique de développement orienté objet devient le processus unifié (également connu sous l\'appellation anglo-saxonne de « Unified Software Development Process »). Elle est itérative et incrémentale, centrée sur l\'architecture et guidée par les cas d\'utilisation et la réduction des risques. Le processus unifié est de plus adaptable par les équipes de développement pour prendre en compte au mieux les particularités du contexte.\r\n\r\nNéanmoins pour un certain nombre de concepteurs objet, dont Bertrand Meyer, l\'inventeur du langage orienté objet Eiffel, guider une modélisation objet par des cas d\'utilisations est une erreur de méthode qui n\'a rien d\'objet et qui est plus proche d\'une méthode fonctionnelle. Pour eux, les cas d\'utilisations sont relégués à des utilisations plutôt annexes comme la validation d\'un modèle par exemple.',
        '2022-05-09 15:38:03', 1, 2),
       (4, 'Tuto : appeler une API en PHP (réponses en JSON)', 'tuto-appeler-une-api-en-php-reponses-en-json',
        'Dans ce petit tutoriel, je vais vous montrer comment développer une application en PHP appelant une API qui va récupérer le résultat de la requête en JSON',
        'Les API sur Internet\r\n\r\nLes API sont un moyen d’accéder aux données d’un site sans avoir l’autorisation d’accéder directement à la base de données. Il y a beaucoup de portails sécurisés permettant à vos applications web de manipuler les données renvoyées par ces sites.\r\n\r\nL’exemple parfait est Twitter, c’est d’ailleurs l’API de Twitter que nous allons utiliser dans ce tuto. Elle permet de lire la timeline d’une personne en particulier, de rechercher des statuts à partir d’un mot clé, de modifier les paramètres de votre compte, etc. Nous nous limiterons à la partie la plus simple et facile à mettre en place pour introduire les API.\r\n\r\nPourquoi choisir JSON ?\r\n\r\nVous pouvez utiliser les API avec de nombreux langages et retourner les données de plusieurs façons. L’une d’elles est le JSON (JavaScript Object Notation). C’est un format de données léger, facile à lire et à écrire et compatible avec pas mal de langages de développement. Sa structure est composée d’objets et de tableaux. Sa flexibilité fait de JSON le parfait candidat pour retourner des données.\r\n\r\nStructure du projet\r\n\r\nNotre application web va afficher les Tweets contenant le mot clé de votre choix. La limite est de 10 tweets mais elle est paramétrable lors de l’appel de l’API.\r\n\r\nLe projet va tourner autour de 2 fichiers : index.php dans lequel il y aura le formulaire de recherche et resultat.php dans lequel plusieurs actions seront effectuées. Nous y reviendrons un peu plus tard. Il y a également un dossier nommé cache qui contiendra les fichiers .json contenant les résultats des recherches. C’est un système de cache très simple basé sur des fichiers. Il existe bien d’autres méthodes de mise en cache (base de données). A vous de voir ce qui vous convient le mieux.',
        '2022-05-13 11:51:21', 1, 1),
       (5, 'PHP 8.2 apportera de nouvelles fonctionnalités et les améliorations de performances',
        'php-8-2-apportera-de-nouvelles-fonctionnalites-et-les-ameliorations-de-performances',
        'PHP 8.2 sera probablement publié à la fin de 2022, mais aucune date n&#039;a encore été fixée. De nouvelles fonctionnalités, les améliorations de performances, les modifications et les dépréciations sont attendues.\r\n\r\nLes techniquement null ',
        'PHP 8.2 sera probablement publié à la fin de 2022, mais aucune date n&#039;a encore été fixée. De nouvelles fonctionnalités, les améliorations de performances, les modifications et les dépréciations sont attendues.\r\n\r\nLes techniquement null et false pourraient être considérés comme des types valides par eux-mêmes. Les exemples courants sont les fonctions intégrées de PHP, où false est utilisé comme type de retour en cas d&#039;erreur. Par exemple, dans file_get_contents :\r\n\r\nCode :\r\n\r\nfile_get_contents(/* … */): string|false\r\n\r\nNotons que l&#039;utilisation de false dans un type union était déjà possible ; mais en PHP 8.2, il peut être utilisé comme un type autonome :\r\n\r\nCode :\r\n\r\nfunction alwaysFalse(): false\r\n{\r\n    return false;\r\n}\r\n\r\nSelon Brent Roose, de nombreux développeurs, dont lui-même, sont un peu méfiants en regardant la RFC qui traite de True et False. « Elle ne prend pas en charge true en tant que type autonome, et les types ne devraient-ils pas représenter des catégories plutôt que des valeurs individuelles ? », s’interroge-t-il. « Il s&#039;avère qu&#039;il existe un concept appelé type unitaire dans les systèmes de types, qui sont des types qui ne permettent qu&#039;une seule valeur. Mais est-ce vraiment utile, et est-ce que cela encourage la conception de logiciels propres ? Peut-être, peut-être pas. », ajoute-til. Un type null autonome est un peu plus logique : null peut être considéré comme une catégorie en soi et pas seulement comme une valeur dans une catégorie. \r\n\r\nModèle d&#039;objet null\r\n\r\nCode :	\r\n\r\nclass Post \r\n{\r\n    public function getAuthor(): ?string { /* … */ }\r\n}\r\n \r\nclass NullPost extends Post\r\n{\r\n    public function getAuthor(): null { /* … */ }\r\n}\r\n\r\nIl est logique que NullPost::getAuthor() puisse dire qu&#039;il ne retournera jamais que null, au lieu de null ou string, ce qui n&#039;était pas possible auparavant.\r\n\r\nBrent Roose recommande d’éviter d&#039;utiliser false comme un type autonome pour transmettre un état d&#039;erreur « je pense qu&#039;il y a de meilleures solutions pour résoudre de tels problèmes. » \r\n\r\nDépréciation des propriétés dynamiques \r\n\r\nLes propriétés dynamiques sont dépréciées en PHP 8.2, et lèveront une ErrorException en PHP 9.0. Rappelons que les propriétés dynamiques sont des propriétés qui ne sont pas présentes sur un objet, mais qui sont néanmoins définies ou obtenues :\r\n\r\nCode :	\r\n\r\nclass Post\r\n{\r\n    public string $title;\r\n}\r\n \r\n// …\r\n \r\n$post-&gt;name = &#039;Name&#039;;\r\n\r\nLes classes implémentant __get et __set fonctionneront toujours comme prévu :\r\n\r\nCode :	\r\n\r\nclass Post\r\n{\r\n    private array $properties = [];\r\n \r\n    public function __set(string $name, mixed $value): void\r\n    {\r\n        $this-&gt;properties[$name] = $value;\r\n    }\r\n}\r\n \r\n// …\r\n \r\n$post-&gt;name = &#039;Name&#039;;\r\n\r\nPour Brent Roose, le PHP était autrefois un langage très dynamique, mais il s&#039;est éloigné de cet état d&#039;esprit depuis un certain temps déjà. Ce dernier pense que c&#039;est une bonne chose d&#039;adopter des règles plus strictes et de s&#039;appuyer sur l&#039;analyse statique partout où cela est possible, car cela permet aux développeurs d&#039;écrire un meilleur code.\r\n\r\nRedact les paramètres dans les traces \r\n\r\nUne pratique courante dans toute base de code est d&#039;envoyer les erreurs de production à un service qui en garde la trace et notifie les développeurs lorsque quelque chose ne va pas. Cette pratique implique souvent l&#039;envoi de traces de pile par câble à un service tiers. Il y a cependant des cas où ces traces de pile peuvent inclure des informations sensibles telles que des variables d&#039;environnement, des mots de passe ou des noms d&#039;utilisateur.\r\n\r\nPHP 8.2 permet de marquer ces « paramètres sensibles » avec un attribut, de sorte que l&#039;utilisateur n&#039;ait pas à se soucier de leur présence dans les piles de traces lorsque quelque chose ne va pas. Voici un exemple tiré de la RFC :\r\n\r\nCode :	\r\n\r\nfunction test(\r\n    $foo,\r\n    #[SensitiveParameter] $bar,\r\n    $baz\r\n) {\r\n    throw new Exception(&#039;Error&#039;);\r\n}\r\n \r\ntest(&#039;foo&#039;, &#039;bar&#039;, &#039;baz&#039;);\r\nFatal error: Uncaught Exception: Error in test.php:8\r\nStack trace:\r\n#0 test.php(11): test(&#039;foo&#039;, Object(SensitiveParameterValue), &#039;baz&#039;)\r\n#1 {main}\r\nthrown in test.php on line 8\r\n\r\nDépréciation partielle supportée par les callables \r\n\r\nUn autre changement, bien qu&#039;ayant un impact légèrement plus faible, est que les callablespartiellement supportés sont maintenant dépréciés également. Les callables partiellement supportés sont des callables qui peuvent être appelés en utilisant call_user_func($callable), mais pas en appelant $callable() directement. La liste de ces types de callablesest assez courte, d&#039;ailleurs :\r\n&quot;self::method&quot;\r\n&quot;parent::method&quot;\r\n&quot;static::method&quot;\r\n[&quot;self&quot;, &quot;method&quot;]\r\n[&quot;parent&quot;, &quot;method&quot;]\r\n[&quot;static&quot;, &quot;method&quot;]\r\n[&quot;Foo&quot;, &quot;Bar::method&quot;]\r\n[new Foo, &quot;Bar::method&quot;]\r\n\r\n\r\nLa raison de ce choix ? Pour certains programmeurs, il s&#039;agit là d&#039;un pas dans la bonne direction vers la possibilité d&#039;utiliser callable pour les propriétés typées. C&#039;est bien expliqué dans la RFC :\r\n\r\n« tous ces callables sont dépendants du contexte. La méthode à laquelle self::method fait référence dépend de la classe à partir de laquelle l&#039;appel ou la vérification de callability est effectué. En pratique, cela vaut également pour les deux derniers cas, lorsqu&#039;ils sont utilisés sous la forme [new Foo, &quot;parent::method&quot;].\r\n\r\nLa réduction de la dépendance contextuelle des callables est l&#039;objectif secondaire de ce RFC. Après cette RFC, la seule dépendance de portée qui reste est la visibilité de la méthode : Foo::bar peut être visible dans une portée, mais pas dans une autre. Si les callables devaient être limités aux méthodes publiques à l&#039;avenir (tandis que les méthodes privées devraient utiliser des callables de première classe ou Closure::fromCallable() pour être rendues indépendantes de la portée), alors le type callable deviendrait bien défini et pourrait être utilisé comme un type de propriété. Cependant, les modifications de la gestion de la visibilité ne sont pas proposées dans le cadre de ce RFC. »',
        '2022-05-28 12:21:32', 1, 4),
       (6, 'La première version EAP de RubyMine 2022.2 est disponible',
        'la-premiere-version-eap-de-rubymine-2022-2-est-disponible',
        'A la mi-avril, JetBrains a annoncé la sortie de RubyMine 2022.1, la première mise à jour majeure de cette année pour son EDI pour le développement Web avec Ruby et Ruby on Rails. Au cas où vous l&#039;aurez manquée, cette version a apporté un',
        'A la mi-avril, JetBrains a annoncé la sortie de RubyMine 2022.1, la première mise à jour majeure de cette année pour son EDI pour le développement Web avec Ruby et Ruby on Rails. Au cas où vous l&#039;aurez manquée, cette version a apporté un bon lot de nouveautés et améliorations, y compris la prise en charge des nouvelles fonctionnalités Ruby et RBS, de nouvelles inspections et correctifs rapides, des améliorations de l&#039;expérience utilisateur et bien plus.\r\n\r\nUn peu plus d&#039;un mois après, JetBrains ouvre le programme d&#039;accès anticipé (EAP) à RubyMine 2022.2. Comme toujours, vous êtes invités à essayer les nouvelles fonctionnalités et faire des retours à JetBrains avant la sortie officielle. Mais avant, nous vous présentons ici les principaux changements dans cette première version EAP.\r\n\r\nDébogueur\r\n\r\nJetBrains a amélioré le débogueur de RubyMine pour le rendre plus robuste pour Ruby 3 et les versions ultérieures du langage. À partir de cette version EAP, vous devriez être en mesure de déboguer votre code Ruby 3 et d&#039;une version supérieure sans aucun problème majeur tout en utilisant toutes les fonctionnalités sophistiquées fournies dans l&#039;interface graphique. L&#039;éditeur de logiciels pour développeurs a également corrigé des problèmes dans les implémentations précédentes du débogueur. Ainsi, si vous utilisez une ancienne version de Ruby (inférieure à 3.0), vous devriez également pouvoir déboguer votre code dans RubyMine sans problème. Aucune action supplémentaire n&#039;est requise, car l&#039;EDI proposera automatiquement une implémentation de débogueur appropriée.\r\n\r\nJetBrains a effectué des tests internes pour déterminer les performances du nouveau débogueur RubyMine lors de l&#039;exécution d&#039;un simple script Rails en mode débogage. Et l&#039;entreprise a découvert que ses performances sont proches du débogueur natif Ruby 3, sur lequel son nouveau débogueur est basé. Les résultats varient de manière insignifiante en fonction du système d&#039;exploitation, du processeur de la machine et du nombre de points d&#039;arrêt définis.\r\n\r\nL&#039;important est que, lors du débogage de configurations qui ont deux points d&#039;arrêt ou plus, le nouveau débogueur RubyMine est environ 5 fois plus rapide que le précédent pour Ruby 3, qui utilisait une implémentation open source .\r\n\r\nSelon les statistiques et enquêtes de JetBrains, le débogueur de RubyMine est l&#039;une des fonctionnalités les plus utilisées par les utilisateurs expérimentés. Ces améliorations devraient donc être très appréciées. \r\n\r\nRBS\r\n\r\nDans cette version, JetBrains a continué à améliorer son support du langage RBS (Ruby Signature). À partir de cette version, les fonctionnalités de code insight de RubyMine vérifient désormais les modificateurs de visibilité public et private inline pour déterminer la visibilité des déclarations d&#039;attributs et de méthodes. JetBrains a également ajouté des modificateurs de visibilité par méthode à la vue Structure .',
        '2022-05-28 12:30:13', 1, 4),
       (7, '5 mistakes that makes you a noob in PHP', '5-mistakes-that-makes-you-a-noob-in-php',
        'Web Development is a huge industry itself in IT, And most of the time people start with PHP as a web developer. Teachers in colleges teach in a way such that students can understand the code and basics of scripting that how things work?\r\n\r\nBut as we ',
        'Web Development is a huge industry itself in IT, And most of the time people start with PHP as a web developer. Teachers in colleges teach in a way such that students can understand the code and basics of scripting that how things work?\r\n\r\nBut as we grow, most of us not trying to learn the design pattern in PHP language, which makes the code base sucks! So, today I am going to show you what people think and what actually should happen while writing and managing code.\r\n\r\n#1 Using Lower Version of PHP\r\n\r\nThe first version was available sometime in early 1995 and was known as the Personal Home Page Tools. Later on 1st July 2004, PHP 5 was released. With this update, a lot of changes have been introduced. A lot of websites started to teach coding of PHP and features as well. But the most important thing in the history of programming is NULL safety, which destroyed and made a loss of millions of dollars.\r\n\r\nAs many developers were just newbies and never tried to figure out the other way + web development changes are being ignored due to high maintenance work, so these kinds of problems made developers switch to new projects without taking a break or upskilling, which cause a lot of outdated code in the world!\r\n\r\nPHP 8 has been introduced, but people still using lower versions like PHP 5. There are two reasons here:-\r\n\r\nPeople are lazy enough to upgrade the skills\r\nThey’re kind of stuck with the legacy codebase\r\nBut trust me PHP 7 introduced a lot of cool features, from PHP 7.3 (??) has introduced null safety through which we can avoid a lot of boilerplate conditions.\r\n\r\nFun Fact: MySql has been changed to Mysqli from PHP 5 and if(isset()) is changed to (??) for null safety in PHP 7, but people are still living in an imaginary world\r\n\r\n#2 No MVC Pattern in Core PHP\r\n\r\nPeople often have a complaint that they’re not able to structure Design Pattern out of the box and many articles and documentation don’t promote it. This makes confusion in the community about how to write code, which creates unstable code and creates conflicts.\r\n\r\nPeople include the connection.php file in every file and write queries on top of the PHP tag. Then starts while loop in HTML by opening and closing PHP tags in between. This is the traditional approach to writing code in PHP but can be improved by introducing class and object.\r\n\r\n#3 Handling Form Submission\r\n\r\nif(isset()) is used every time when we submit a form using the POST method. This is used to validate if the form really submitted or not, but this can be improved as well.\r\n\r\n#4 Using old syntax in newer versions\r\n\r\nNull safety is provided by almost every programming language nowadays, but people are not aware of it. They still use the old syntax of language which makes them write a lot of boilerplate code. This can be easily improved by following trends in working programming language and by referring latest answers in StackOverflow instead of the accepted ones.\r\n\r\nWe can use traits, constants, Inheritance, and Elvis Operator for null safety (??).\r\n\r\n#5 Not Using Laravel Framework\r\n\r\nIf you often feel stuck with core PHP, then it’s time to move to a new Powerful Framework called Laravel. It provides a lot of cool libraries and features out of the box. The framework makes life a lot easy and teaches us how to write well-maintained code.\r\n\r\n# Using Nested MySQL queries in PHP Loop ~ Very Dangerous (Bonus Mistake)\r\n\r\nSuppose we have to fetch the result from the database and according to that result we fetch the child results using a while loop using a nested MySQL query.\r\n\r\nTrust me this practice is very harmful.\r\n\r\nHere I touched the point in more detail and in a very interesting way.\r\n\r\nSo, these were my observations and point of view regarding the subject. I have literally seen people repeating the same thing again and again, without even thinking about why I am doing a lot of stuff. They don’t even think about how to improve the code and make it work in a few lines in a debug-friendly way.\r\n\r\nTest-Driven Development is also very popular, but with core PHP it’s difficult to implement. So, as a developer, our duty is to write maintainable code and choose the right framework so that in the future the project can be well maintained. People already following the rat race, so be upgraded.\r\n\r\nThanks!',
        '2022-05-29 08:27:00', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `thearticle_has_thecomment`
--

DROP TABLE IF EXISTS `thearticle_has_thecomment`;
CREATE TABLE IF NOT EXISTS `thearticle_has_thecomment`
(
    `thearticle_idthearticle` int(10) UNSIGNED NOT NULL,
    `thecomment_idthecomment` int(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`thearticle_idthearticle`, `thecomment_idthecomment`),
    KEY `fk_thearticle_has_thecomment_thecomment1_idx` (`thecomment_idthecomment`),
    KEY `fk_thearticle_has_thecomment_thearticle1_idx` (`thearticle_idthearticle`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `thearticle_has_thecomment`
--

INSERT INTO `thearticle_has_thecomment` (`thearticle_idthearticle`, `thecomment_idthecomment`)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `thecomment`
--

DROP TABLE IF EXISTS `thecomment`;
CREATE TABLE IF NOT EXISTS `thecomment`
(
    `idthecomment`      int(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `theuser_idtheuser` int(10) UNSIGNED             DEFAULT NULL,
    `thecommenttext`    varchar(850)        NOT NULL,
    `thecommentdate`    datetime                     DEFAULT current_timestamp(),
    `thecommentactive`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
    PRIMARY KEY (`idthecomment`),
    KEY `fk_thecomment_theuser1_idx` (`theuser_idtheuser`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `thecomment`
--

INSERT INTO `thecomment` (`idthecomment`, `theuser_idtheuser`, `thecommenttext`, `thecommentdate`, `thecommentactive`)
VALUES (1, 1, 'PHP c\'est de la merde, vive Python !!!', '2022-05-06 16:23:10', 1),
       (2, 2, 'Espèce de Troll va....', '2022-05-06 16:23:39', 1),
       (3, 1, 'Mais non, même JS est plus lisible!', '2022-05-06 16:24:46', 1),
       (4, 5, 'Je ne vois pas trop l\'intérêt', '2022-05-28 12:23:26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `theimage`
--

DROP TABLE IF EXISTS `theimage`;
CREATE TABLE IF NOT EXISTS `theimage`
(
    `idtheimage`   int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `theimagename` varchar(45)      NOT NULL,
    `theimagetype` varchar(5)       NOT NULL,
    `theimageurl`  varchar(100)     NOT NULL,
    `theimagetext` varchar(250) DEFAULT NULL,
    PRIMARY KEY (`idtheimage`),
    UNIQUE KEY `theimagename_UNIQUE` (`theimagename`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theimage_has_thearticle`
--

DROP TABLE IF EXISTS `theimage_has_thearticle`;
CREATE TABLE IF NOT EXISTS `theimage_has_thearticle`
(
    `theimage_idtheimage`     int(10) UNSIGNED NOT NULL,
    `thearticle_idthearticle` int(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`theimage_idtheimage`, `thearticle_idthearticle`),
    KEY `fk_theimage_has_thearticle_thearticle1_idx` (`thearticle_idthearticle`),
    KEY `fk_theimage_has_thearticle_theimage1_idx` (`theimage_idtheimage`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Structure de la table `thesection`
--

DROP TABLE IF EXISTS `thesection`;
CREATE TABLE IF NOT EXISTS `thesection`
(
    `idthesection`    smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `thesectiontitle` varchar(60)          NOT NULL,
    `thesectionslug`  varchar(60)          NOT NULL,
    `thesectiondesc`  varchar(300) DEFAULT NULL,
    PRIMARY KEY (`idthesection`),
    UNIQUE KEY `thesectionslug_UNIQUE` (`thesectionslug`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 17
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `thesection`
--

INSERT INTO `thesection` (`idthesection`, `thesectiontitle`, `thesectionslug`, `thesectiondesc`)
VALUES (9, 'HTML', 'html',
        'HTML signifie « HyperText Markup Language » qu\'on peut traduire par « langage de balises pour l\'hypertexte ». Il est utilisé afin de créer et de représenter le contenu d\'une page web et sa structure.'),
       (10, 'CSS', 'css', 'CSS est l\'un des langages principaux du Web ouvert et a été standardisé par le W3C.'),
       (11, 'Javascript', 'javascript',
        'JavaScript est au cœur des langages utilisés par les développeurs web. Une grande majorité des sites web l\'utilisent, et la majorité des navigateurs web disposent d\'un moteur JavaScript5 pour l\'interpréter.'),
       (12, 'PHP', 'php',
        'PHP: Hypertext Preprocessor, plus connu sous son sigle PHP, est un langage de programmation libre, principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP.'),
       (13, 'SQL', 'sql',
        'SQL est un langage informatique normalisé servant à exploiter des bases de données relationnelles. La partie langage de manipulation des données de SQL permet de rechercher, d\'ajouter, de modifier ou de supprimer des données dans les bases de données relationnelles.'),
       (14, 'Algorithmie Générale', 'algorithmie-generale',
        'L\'algorithmique est l\'étude et la production de règles et techniques qui sont impliquées dans la définition et la conception d\'algorithmes, c\'est-à-dire de processus systématiques de résolution d\'un problème permettant de décrire précisément des étapes pour résoudre un problème algorithmique'),
       (15, 'Programmation', 'programmation',
        'La programmation, appelée aussi codage dans le domaine informatique, désigne l\'ensemble des activités qui permettent l\'écriture des programmes informatiques. C\'est une étape importante du développement de logiciels.'),
       (16, 'Autre', 'autre', 'A propos du développement web');

-- --------------------------------------------------------

--
-- Structure de la table `thesection_has_thearticle`
--

DROP TABLE IF EXISTS `thesection_has_thearticle`;
CREATE TABLE IF NOT EXISTS `thesection_has_thearticle`
(
    `thesection_idthesection` smallint(5) UNSIGNED NOT NULL,
    `thearticle_idthearticle` int(10) UNSIGNED     NOT NULL,
    PRIMARY KEY (`thesection_idthesection`, `thearticle_idthearticle`),
    KEY `fk_thesection_has_thearticle_thearticle1_idx` (`thearticle_idthearticle`),
    KEY `fk_thesection_has_thearticle_thesection1_idx` (`thesection_idthesection`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `thesection_has_thearticle`
--

INSERT INTO `thesection_has_thearticle` (`thesection_idthesection`, `thearticle_idthearticle`)
VALUES (9, 4),
       (11, 2),
       (11, 3),
       (11, 4),
       (12, 1),
       (12, 3),
       (12, 4),
       (12, 5),
       (12, 7),
       (14, 3),
       (14, 7),
       (15, 1),
       (15, 2),
       (15, 3),
       (15, 4),
       (15, 5),
       (15, 6),
       (15, 7),
       (16, 6);

-- --------------------------------------------------------

--
-- Structure de la table `theuser`
--

DROP TABLE IF EXISTS `theuser`;
CREATE TABLE IF NOT EXISTS `theuser`
(
    `idtheuser`               int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `theuserlogin`            varchar(60)      NOT NULL,
    `theuserpwd`              varchar(255)     NOT NULL,
    `theusermail`             varchar(255)     NOT NULL,
    `theuseruniqid`           varchar(255)     NOT NULL,
    `theuseractivate`         tinyint(3) UNSIGNED DEFAULT 0 COMMENT '0 => inactive\n1 => active\n2 => ban',
    `permission_idpermission` tinyint(3) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`idtheuser`),
    UNIQUE KEY `theuserlogin_UNIQUE` (`theuserlogin`),
    UNIQUE KEY `theusermail_UNIQUE` (`theusermail`),
    UNIQUE KEY `theuseruniqid_UNIQUE` (`theuseruniqid`),
    KEY `fk_theuser_permission_idx` (`permission_idpermission`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  DEFAULT CHARSET = utf8;

--
-- Déchargement des données de la table `theuser`
--

INSERT INTO `theuser` (`idtheuser`, `theuserlogin`, `theuserpwd`, `theusermail`, `theuseruniqid`, `theuseractivate`,
                       `permission_idpermission`)
VALUES (1, 'admin', '$2y$10$vBhjRuKwxfK1AXnTzMUHXOP2KMhwdkWd1N3VflFJTCvoG7AUZh4r6', 'michaeljpitz@gmail.com',
        '626fa6578dd31', 1, 1),
       (2, 'Pierre', '$2y$10$.08wH0aufWao2s0D2yn1d.tJyH1rYpK/o5KKb538/SZNj8S3m/n0C', 'pierre.sandron@cf2m.be',
        '626fa6bf4f026', 1, 2),
       (3, 'util1', '$2y$10$2YZpDKfAbRN0F.UE/I5hweERIN3CyWmSpo.W6p.rfM/yzuOurYSri', 'onsenfout@cahit.com',
        '628744bece71e5.27321545', 1, 3),
       (4, 'Mike', '$2y$10$OWDAzKOK3oQiwGR.Ot8ow.lVRx/nKNNnpc1ZerbOyXwJ36SAMYQPm', 'michael.j.pitz@gmail.com',
        '6291f5c4096111.90314462', 1, 2),
       (5, 'util2', '$2y$10$SBKYMAohvOI.rvL7bA6j8..MUZkfW3sZChPXbbq.QMVXcEMcHcXRC', 'm.ichaeljpitz@gmail.com',
        '6291f63a9b35c9.57282812', 1, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `thearticle`
--
ALTER TABLE `thearticle`
    ADD CONSTRAINT `fk_thearticle_theuser1` FOREIGN KEY (`theuser_idtheuser`) REFERENCES `theuser` (`idtheuser`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `thearticle_has_thecomment`
--
ALTER TABLE `thearticle_has_thecomment`
    ADD CONSTRAINT `fk_thearticle_has_thecomment_thearticle1` FOREIGN KEY (`thearticle_idthearticle`) REFERENCES `thearticle` (`idthearticle`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_thearticle_has_thecomment_thecomment1` FOREIGN KEY (`thecomment_idthecomment`) REFERENCES `thecomment` (`idthecomment`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `thecomment`
--
ALTER TABLE `thecomment`
    ADD CONSTRAINT `fk_thecomment_theuser1` FOREIGN KEY (`theuser_idtheuser`) REFERENCES `theuser` (`idtheuser`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `theimage_has_thearticle`
--
ALTER TABLE `theimage_has_thearticle`
    ADD CONSTRAINT `fk_theimage_has_thearticle_thearticle1` FOREIGN KEY (`thearticle_idthearticle`) REFERENCES `thearticle` (`idthearticle`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_theimage_has_thearticle_theimage1` FOREIGN KEY (`theimage_idtheimage`) REFERENCES `theimage` (`idtheimage`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `thesection_has_thearticle`
--
ALTER TABLE `thesection_has_thearticle`
    ADD CONSTRAINT `fk_thesection_has_thearticle_thearticle1` FOREIGN KEY (`thearticle_idthearticle`) REFERENCES `thearticle` (`idthearticle`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_thesection_has_thearticle_thesection1` FOREIGN KEY (`thesection_idthesection`) REFERENCES `thesection` (`idthesection`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `theuser`
--
ALTER TABLE `theuser`
    ADD CONSTRAINT `fk_theuser_permission` FOREIGN KEY (`permission_idpermission`) REFERENCES `permission` (`idpermission`) ON DELETE SET NULL ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
