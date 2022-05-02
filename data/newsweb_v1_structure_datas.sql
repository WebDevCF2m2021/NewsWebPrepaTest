-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : lun. 02 mai 2022 à 09:41
-- Version du serveur : 10.6.5-MariaDB
-- Version de PHP : 8.0.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `newsweb`
--
DROP DATABASE IF EXISTS `newsweb`;
CREATE DATABASE IF NOT EXISTS `newsweb` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
