-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : ven. 06 mai 2022 à 12:31
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.0.13

SET FOREIGN_KEY_CHECKS=0;
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
CREATE TABLE IF NOT EXISTS `permission` (
  `idpermission` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `permissionname` varchar(45) NOT NULL,
  `permissionrole` tinyint(3) UNSIGNED NOT NULL COMMENT '0 => admin\n1 => contributor\n2 => commentator',
  PRIMARY KEY (`idpermission`),
  UNIQUE KEY `permissionname_UNIQUE` (`permissionname`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`idpermission`, `permissionname`, `permissionrole`) VALUES
(1, 'Administrateur', 0),
(2, 'Rédacteur', 1),
(3, 'Membre', 2);

-- --------------------------------------------------------

--
-- Structure de la table `thearticle`
--

DROP TABLE IF EXISTS `thearticle`;
CREATE TABLE IF NOT EXISTS `thearticle` (
  `idthearticle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thearticletitle` varchar(120) NOT NULL,
  `thearticleslug` varchar(120) NOT NULL,
  `thearticleresume` varchar(250) DEFAULT NULL,
  `thearticletext` text NOT NULL,
  `thearticledate` datetime DEFAULT current_timestamp(),
  `thearticleactivate` tinyint(4) DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
  `theuser_idtheuser` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`idthearticle`),
  UNIQUE KEY `thearticleslug_UNIQUE` (`thearticleslug`),
  KEY `fk_thearticle_theuser1_idx` (`theuser_idtheuser`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thearticle`
--

INSERT INTO `thearticle` (`idthearticle`, `thearticletitle`, `thearticleslug`, `thearticleresume`, `thearticletext`, `thearticledate`, `thearticleactivate`, `theuser_idtheuser`) VALUES
(1, 'Quoi de neuf dans PHP 8.1 : Fonctionnalités, changements, améliorations et plus encore', 'quoi-de-neuf-dans-php-8-1-fonctionnalites-changements-ameliorations-et-plus-encore', 'Dans cet article, nous allons couvrir en détail les nouveautés de PHP 8.1.', 'Types d’intersection purs\r\nPHP 8.1 ajoute la prise en charge des types d’intersection. C’est similaire aux types d’union introduits dans PHP 8.0, mais leur utilisation prévue est exactement l’inverse.\r\n\r\nPour mieux comprendre son utilisation, rafraîchissons la façon dont les déclarations de type fonctionnent en PHP.\r\n\r\nEssentiellement, vous pouvez ajouter des déclarations de type aux arguments des fonctions, aux valeurs de retour et aux propriétés des classes. Cette affectation est appelée indication de type et garantit que la valeur est du bon type au moment de l’appel. Sinon, une TypeError est immédiatement émise. En retour, cela vous aide à mieux déboguer le code.\r\n\r\nCependant, la déclaration d’un type uniques a ses limites. Les types d’union vous aident à surmonter cela en vous permettant de déclarer une valeur avec plusieurs types, et l’entrée doit satisfaire au moins un des types déclarés.\r\n\r\nD’autre part, la RFC décrit les types d’intersection comme ceci :\r\n\r\nUn « type d’intersection » exige qu’une valeur satisfasse plusieurs contraintes de type au lieu d’une seule.\r\n\r\n…les types d’intersection purs sont spécifiés à l’aide de la syntaxe T1&T2&… et peuvent être utilisés dans toutes les positions où les types sont actuellement acceptés…\r\n\r\nNotez l’utilisation de l’opérateur & (AND) pour déclarer les types d’intersection. En revanche, nous utilisons l’opérateur | (OR) pour déclarer les types d’union.\r\n\r\nL’utilisation de la plupart des types standard dans un type d’intersection donnera un type qui ne pourra jamais être rempli (par exemple, integer et string). Par conséquent, les types d’intersection ne peuvent inclure que des types de classe (c’est-à-dire des interfaces et des noms de classe).\r\n\r\nVoici un exemple de code montrant comment vous pouvez utiliser les types d’intersection :\r\n<pre>\r\nclasse A {\r\n    private Traversable&Countable $countableIterator;\r\n \r\n    public function setIterator(Traversable&Countable $countableIterator) : void {\r\n        $this->countableIterator = $countableIterator;\r\n    }\r\n \r\n    public function getIterator() : Traversable&Countable {\r\n        retourne $this->countableIterator;\r\n    }\r\n}</pre>\r\nDans le code ci-dessus, nous avons défini une variable countableIterator comme une intersection de deux types : Traversable et Countable. Dans ce cas, les deux types déclarés sont des interfaces.\r\n\r\nLes types d’intersection sont également conformes aux règles standard de variance PHP déjà utilisées pour la vérification des types et l’héritage. Mais il existe deux règles supplémentaires concernant la façon dont les types d’intersection interagissent avec le sous-typage. Vous pouvez en savoir plus sur les règles de variance des types d’intersection dans sa RFC.\r\n\r\nDans certains langages de programmation, vous pouvez combiner les types Union et les types Intersection dans la même déclaration. Mais PHP 8.1 l’interdit. C’est pourquoi sa mise en œuvre est appelée types d’intersection « purs ». Cependant, la RFC mentionne que c’est « laissé comme une scope future »\r\n\r\nEnums\r\nPHP 8.1 ajoute enfin la prise en charge des enums (également appelés énumérations ou types énumérés). Il s’agit d’un type de données défini par l’utilisateur, composé d’un ensemble de valeurs possibles.\r\n\r\nL’exemple d’énumération le plus courant dans les langages de programmation est le type booléen, avec true et false comme deux valeurs possibles. C’est tellement courant qu’il est intégré dans de nombreux langages de programmation modernes.\r\n\r\nConformément à la RFC, les énumérations en PHP seront limitées aux « énumérations d’unités » au départ :\r\n\r\nLa portée de cette RFC est limitée aux « énumérations d’unités », c’est-à-dire aux énumérations qui sont elles-mêmes une valeur, plutôt qu’une simple syntaxe fantaisiste pour une constante primitive, et qui n’incluent pas d’informations associées supplémentaires. Cette capacité offre une prise en charge considérablement élargie pour la modélisation des données, les définitions de types personnalisées et le comportement de style monade. Les Enums permettent la technique de modélisation consistant à « rendre les états non valides irreprésentables », ce qui conduit à un code plus robuste nécessitant moins de tests exhaustifs.\r\n\r\nPour arriver à ce stade, l’équipe PHP a étudié de nombreux langages qui prennent déjà en charge les énumérations. Leur étude a révélé que l’on peut classer les énumérations en trois groupes généraux : Constantes fantaisistes, objets fantaisistes et types de données algébriques (ADT) complets. C’est une lecture intéressante !\r\n\r\nPHP implémente les énumérations « Fancy Objects », et prévoit de les étendre aux ADT complets à l’avenir. Il est conceptuellement et sémantiquement modelé sur les types énumérés de Swift, Rust et Kotlin, bien qu’il ne soit pas directement modelé sur aucun d’entre eux.\r\n\r\nLa RFC utilise la célèbre analogie des couleurs dans un jeu de cartes pour expliquer son fonctionnement :\r\n<pre>\r\nenum Suit {\r\ncase Hearts;\r\ncase Diamonds;\r\ncase Clubs;\r\ncase Spades;</pre>\r\n\r\nIci, l’enum Suit définit quatre valeurs possibles : Hearts, Diamonds, Clubs et Spades. Vous pouvez accéder directement à ces valeurs en utilisant la syntaxe : Suit::Hearts, Suit::Diamonds, Suit::Clubs, et Suit::Spades.\r\n\r\nCette utilisation peut vous sembler familière, car les enums sont construits au-dessus des classes et des objets. Ils se comportent de manière similaire et ont presque les mêmes exigences. Les enums partagent les mêmes espaces de noms que les classes, les interfaces et les traits.\r\n\r\nLes enums mentionnés ci-dessus sont appelés Pure Enums.\r\n\r\nVous pouvez aussi définir des Enums Backed si vous voulez donner une valeur scalaire équivalente à n’importe quel cas. Cependant, les backed enums ne peuvent avoir qu’un seul type, soit int soit string (jamais les deux).\r\n<pre>\r\nenum Suit: string {\r\ncase Hearts = \'H\';\r\ncase Diamonds = \'D\';\r\ncase Clubs = \'C\';\r\ncase Spades = \'S\';\r\n}</pre>\r\nDe plus, tous les différents cas d’un backed enum doivent avoir une valeur unique. Et vous ne pouvez jamais mélanger les enums purs et backed.\r\n\r\nLa RFC approfondit les méthodes d’énumération, les méthodes statiques, les constantes, les expressions constantes et bien plus encore. Les couvrir tous dépasse le cadre de cet article. Vous pouvez vous référer à la documentation pour vous familiariser avec toutes ses qualités.\r\n\r\nLe type de retour never\r\nPHP 8.1 ajoute un nouvel indice de type de retour appelé never. C’est très utile pour les fonctions throw ou exit.\r\n\r\nSelon la RFC, les fonctions de redirection d’URL exit (explicitement ou implicitement) sont un bon exemple de son utilisation :\r\n<pre>\r\nfunction redirect(string $uri) : never {\r\n    header(\'Location : \' . $uri) ;\r\n    exit() ;\r\n}\r\n \r\nfonction redirectToLoginPage() : never {\r\n    redirect(\'/login\');\r\n}</pre>\r\n\r\nUne fonction déclarée never doit satisfaire trois conditions :\r\n\r\nL’instruction return ne doit pas être définie explicitement.\r\nL’instruction return ne doit pas être définie implicitement (par exemple, les instructions if-else).\r\nElle doit terminer son exécution avec une déclaration exit (explicitement ou implicitement).\r\nL’exemple de redirection d’URL ci-dessus montre une utilisation à la fois explicite et implicite du type de retour never.\r\n\r\nLe type never return partage de nombreuses similitudes avec le type void return. Ils garantissent tous deux que la fonction ou la méthode ne renvoie pas de valeur. Cependant, il diffère en appliquant des règles plus strictes. Par exemple, une fonction déclarée void peut toujours return sans valeur explicite, mais vous ne pouvez pas faire la même chose avec une fonction déclarée never.\r\n\r\nEn règle générale, utilisez void lorsque vous voulez que PHP continue à s’exécuter après l’appel de la fonction. Choisissez never lorsque vous voulez le contraire.\r\n\r\nDe plus, never est défini comme un type « inférieur ». Par conséquent, toute méthode de classe déclarée never ne peut « jamais » changer son type de retour en quelque chose d’autre. Cependant, vous pouvez étendre une méthode déclarée void avec une méthode déclarée never.\r\n\r\nInfo\r\nLa RFC originale indique le type de retour never comme noreturn, qui était un type de retour déjà pris en charge par deux outils d’analyse statique de PHP, à savoir Psalm et PHPStan. Comme il a été proposé par les auteurs de Psalm et PHPStan eux-mêmes, ils ont conservé sa terminologie. Cependant, en raison des conventions de nommage, l’équipe PHP a réalisé un sondage sur noreturn vs never, dont never est sorti vainqueur. Par conséquent, pour les versions PHP 8.1+, remplace toujours noreturn par never.', '2022-05-06 14:29:57', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `thearticle_has_thecomment`
--

DROP TABLE IF EXISTS `thearticle_has_thecomment`;
CREATE TABLE IF NOT EXISTS `thearticle_has_thecomment` (
  `thearticle_idthearticle` int(10) UNSIGNED NOT NULL,
  `thecomment_idthecomment` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`thearticle_idthearticle`,`thecomment_idthecomment`),
  KEY `fk_thearticle_has_thecomment_thecomment1_idx` (`thecomment_idthecomment`),
  KEY `fk_thearticle_has_thecomment_thearticle1_idx` (`thearticle_idthearticle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `thecomment`
--

DROP TABLE IF EXISTS `thecomment`;
CREATE TABLE IF NOT EXISTS `thecomment` (
  `idthecomment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theuser_idtheuser` int(10) UNSIGNED DEFAULT NULL,
  `thecommenttext` varchar(850) NOT NULL,
  `thecommentdate` datetime DEFAULT current_timestamp(),
  `thecommentactive` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => waiting\n1 => publish\n2 => deleted',
  PRIMARY KEY (`idthecomment`),
  KEY `fk_thecomment_theuser1_idx` (`theuser_idtheuser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theimage`
--

DROP TABLE IF EXISTS `theimage`;
CREATE TABLE IF NOT EXISTS `theimage` (
  `idtheimage` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theimagename` varchar(45) NOT NULL,
  `theimagetype` varchar(5) NOT NULL,
  `theimageurl` varchar(100) NOT NULL,
  `theimagetext` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idtheimage`),
  UNIQUE KEY `theimagename_UNIQUE` (`theimagename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theimage_has_thearticle`
--

DROP TABLE IF EXISTS `theimage_has_thearticle`;
CREATE TABLE IF NOT EXISTS `theimage_has_thearticle` (
  `theimage_idtheimage` int(10) UNSIGNED NOT NULL,
  `thearticle_idthearticle` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`theimage_idtheimage`,`thearticle_idthearticle`),
  KEY `fk_theimage_has_thearticle_thearticle1_idx` (`thearticle_idthearticle`),
  KEY `fk_theimage_has_thearticle_theimage1_idx` (`theimage_idtheimage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `thesection`
--

DROP TABLE IF EXISTS `thesection`;
CREATE TABLE IF NOT EXISTS `thesection` (
  `idthesection` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thesectiontitle` varchar(60) NOT NULL,
  `thesectionslug` varchar(60) NOT NULL,
  `thesectiondesc` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idthesection`),
  UNIQUE KEY `thesectionslug_UNIQUE` (`thesectionslug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thesection`
--

INSERT INTO `thesection` (`idthesection`, `thesectiontitle`, `thesectionslug`, `thesectiondesc`) VALUES
(9, 'HTML', 'html', 'HTML signifie « HyperText Markup Language » qu\'on peut traduire par « langage de balises pour l\'hypertexte ». Il est utilisé afin de créer et de représenter le contenu d\'une page web et sa structure.'),
(10, 'CSS', 'css', 'CSS est l\'un des langages principaux du Web ouvert et a été standardisé par le W3C.'),
(11, 'Javascript', 'javascript', 'JavaScript est au cœur des langages utilisés par les développeurs web. Une grande majorité des sites web l\'utilisent, et la majorité des navigateurs web disposent d\'un moteur JavaScript5 pour l\'interpréter.'),
(12, 'PHP', 'php', 'PHP: Hypertext Preprocessor, plus connu sous son sigle PHP, est un langage de programmation libre, principalement utilisé pour produire des pages Web dynamiques via un serveur HTTP.'),
(13, 'SQL', 'sql', 'SQL est un langage informatique normalisé servant à exploiter des bases de données relationnelles. La partie langage de manipulation des données de SQL permet de rechercher, d\'ajouter, de modifier ou de supprimer des données dans les bases de données relationnelles.'),
(14, 'Algorithmie Générale', 'algorithmie-generale', 'L\'algorithmique est l\'étude et la production de règles et techniques qui sont impliquées dans la définition et la conception d\'algorithmes, c\'est-à-dire de processus systématiques de résolution d\'un problème permettant de décrire précisément des étapes pour résoudre un problème algorithmique'),
(15, 'Programmation', 'programmation', 'La programmation, appelée aussi codage dans le domaine informatique, désigne l\'ensemble des activités qui permettent l\'écriture des programmes informatiques. C\'est une étape importante du développement de logiciels.'),
(16, 'Autre', 'autre', 'A propos du développement web');

-- --------------------------------------------------------

--
-- Structure de la table `thesection_has_thearticle`
--

DROP TABLE IF EXISTS `thesection_has_thearticle`;
CREATE TABLE IF NOT EXISTS `thesection_has_thearticle` (
  `thesection_idthesection` smallint(5) UNSIGNED NOT NULL,
  `thearticle_idthearticle` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`thesection_idthesection`,`thearticle_idthearticle`),
  KEY `fk_thesection_has_thearticle_thearticle1_idx` (`thearticle_idthearticle`),
  KEY `fk_thesection_has_thearticle_thesection1_idx` (`thesection_idthesection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `thesection_has_thearticle`
--

INSERT INTO `thesection_has_thearticle` (`thesection_idthesection`, `thearticle_idthearticle`) VALUES
(12, 1),
(15, 1);

-- --------------------------------------------------------

--
-- Structure de la table `theuser`
--

DROP TABLE IF EXISTS `theuser`;
CREATE TABLE IF NOT EXISTS `theuser` (
  `idtheuser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theuserlogin` varchar(60) NOT NULL,
  `theuserpwd` varchar(255) NOT NULL,
  `theusermail` varchar(255) NOT NULL,
  `theuseruniqid` varchar(255) NOT NULL,
  `theuseractivate` tinyint(3) UNSIGNED DEFAULT 0 COMMENT '0 => inactive\n1 => active\n2 => ban',
  `permission_idpermission` tinyint(3) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`idtheuser`),
  UNIQUE KEY `theuserlogin_UNIQUE` (`theuserlogin`),
  UNIQUE KEY `theusermail_UNIQUE` (`theusermail`),
  UNIQUE KEY `theuseruniqid_UNIQUE` (`theuseruniqid`),
  KEY `fk_theuser_permission_idx` (`permission_idpermission`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `theuser`
--

INSERT INTO `theuser` (`idtheuser`, `theuserlogin`, `theuserpwd`, `theusermail`, `theuseruniqid`, `theuseractivate`, `permission_idpermission`) VALUES
(1, 'admin', '$2y$10$vBhjRuKwxfK1AXnTzMUHXOP2KMhwdkWd1N3VflFJTCvoG7AUZh4r6', 'michaeljpitz@gmail.com', '626fa6578dd31', 1, 1),
(2, 'Pierre', '$2y$10$.08wH0aufWao2s0D2yn1d.tJyH1rYpK/o5KKb538/SZNj8S3m/n0C', 'pierre.sandron@cf2m.be', '626fa6bf4f026', 1, 2);

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
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
