-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Lun 19 Mars 2012 à 10:57
-- Version du serveur: 5.5.21
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mdjtufjjpdev`
--

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_CATEGORIE`
--

DROP TABLE IF EXISTS `MDJT_CATEGORIE`;
CREATE TABLE IF NOT EXISTS `MDJT_CATEGORIE` (
  `idCategorie` int(10) unsigned NOT NULL,
  `nomCategorie` varchar(45) NOT NULL,
  `description` text,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_CATEGORIEJEUX`
--

DROP TABLE IF EXISTS `MDJT_CATEGORIEJEUX`;
CREATE TABLE IF NOT EXISTS `MDJT_CATEGORIEJEUX` (
  `jeux_idjeux` int(10) unsigned NOT NULL,
  `categorie_idcategorie` int(10) unsigned NOT NULL,
  PRIMARY KEY (`jeux_idjeux`,`categorie_idcategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_ETATEXEMPLAIRE`
--

DROP TABLE IF EXISTS `MDJT_ETATEXEMPLAIRE`;
CREATE TABLE IF NOT EXISTS `MDJT_ETATEXEMPLAIRE` (
  `idEtatExemplaire` int(10) unsigned NOT NULL,
  `nomEtat` varchar(45) NOT NULL,
  PRIMARY KEY (`idEtatExemplaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EXEMPLAIRE`
--

DROP TABLE IF EXISTS `MDJT_EXEMPLAIRE`;
CREATE TABLE IF NOT EXISTS `MDJT_EXEMPLAIRE` (
  `idExemplaire` int(10) unsigned NOT NULL COMMENT 'idexemplaire = codeBarre',
  `description` varchar(45) DEFAULT NULL,
  `prixMJDT` decimal(8,0) NOT NULL,
  `dateAchat` date NOT NULL,
  `dateFinVie` date DEFAULT NULL,
  `fkIdVersion` int(10) unsigned NOT NULL,
  `fkIdEtatExemplaire` int(10) unsigned NOT NULL,
  `fkIdLieuStockageReel` int(10) unsigned NOT NULL,
  `fkIdLieuStockageTempo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idExemplaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EXTENSION`
--

DROP TABLE IF EXISTS `MDJT_EXTENSION`;
CREATE TABLE IF NOT EXISTS `MDJT_EXTENSION` (
  `fkIdVersionBase` int(10) unsigned NOT NULL,
  `fkIdVersionExtension` int(10) unsigned NOT NULL,
  `nature` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fkIdVersionBase`,`fkIdVersionExtension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_FAIREPARTIEKIT`
--

DROP TABLE IF EXISTS `MDJT_FAIREPARTIEKIT`;
CREATE TABLE IF NOT EXISTS `MDJT_FAIREPARTIEKIT` (
  `fkIdExemplaire` int(10) unsigned NOT NULL,
  `fkIdKitJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fkIdExemplaire`,`fkIdKitJeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_JEUX`
--

DROP TABLE IF EXISTS `MDJT_JEUX`;
CREATE TABLE IF NOT EXISTS `MDJT_JEUX` (
  `idJeux` int(10) unsigned NOT NULL,
  `description` text,
  `auteur` varchar(45) DEFAULT NULL,
  `fkIdPays` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idJeux`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_KITJEU`
--

DROP TABLE IF EXISTS `MDJT_KITJEU`;
CREATE TABLE IF NOT EXISTS `MDJT_KITJEU` (
  `idKitJeu` int(10) unsigned NOT NULL,
  `nomKit` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idKitJeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LANGUE`
--

DROP TABLE IF EXISTS `MDJT_LANGUE`;
CREATE TABLE IF NOT EXISTS `MDJT_LANGUE` (
  `idLangue` int(10) unsigned NOT NULL,
  `nomLangue` varchar(45) NOT NULL,
  PRIMARY KEY (`idLangue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NOMJEU`
--

DROP TABLE IF EXISTS `MDJT_NOMJEU`;
CREATE TABLE IF NOT EXISTS `MDJT_NOMJEU` (
  `idNomJeu` int(10) unsigned NOT NULL,
  `nom` varchar(45) NOT NULL,
  `fkIdLangue` int(10) unsigned NOT NULL,
  `fkIdJeux` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNomJeu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NOTEVERSION`
--

DROP TABLE IF EXISTS `MDJT_NOTEVERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_NOTEVERSION` (
  `mdjt_utilisateurs_id` int(10) unsigned NOT NULL,
  `mdjt_version_idVersion` int(10) unsigned NOT NULL,
  `note` int(10) unsigned NOT NULL,
  `commentaire` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`mdjt_utilisateurs_id`,`mdjt_version_idVersion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PAYS`
--

DROP TABLE IF EXISTS `MDJT_PAYS`;
CREATE TABLE IF NOT EXISTS `MDJT_PAYS` (
  `idPays` int(10) unsigned NOT NULL,
  `nomPays` varchar(45) NOT NULL,
  PRIMARY KEY (`idPays`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PHOTO`
--

DROP TABLE IF EXISTS `MDJT_PHOTO`;
CREATE TABLE IF NOT EXISTS `MDJT_PHOTO` (
  `idPhoto` int(10) unsigned NOT NULL,
  `nom` varchar(45) NOT NULL,
  `texteAlternatif` varchar(45) NOT NULL,
  PRIMARY KEY (`idPhoto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PHOTOVERSION`
--

DROP TABLE IF EXISTS `MDJT_PHOTOVERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_PHOTOVERSION` (
  `fkIdPhoto` int(10) unsigned NOT NULL,
  `fkIdVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fkIdPhoto`,`fkIdVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mdjt_utilisateurs`
--

DROP TABLE IF EXISTS `mdjt_utilisateurs`;
CREATE TABLE IF NOT EXISTS `mdjt_utilisateurs` (
  `id` int(10) unsigned NOT NULL,
  `titre` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `portable` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `profession` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateAdhesion` date NOT NULL,
  `dateCotisation` date NOT NULL,
  `exemptCotisation` tinyint(1) NOT NULL,
  `commentaires` text COLLATE utf8_unicode_ci NOT NULL,
  `idTypeAdherent` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_VERSION`
--

DROP TABLE IF EXISTS `MDJT_VERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_VERSION` (
  `idVersion` int(10) unsigned NOT NULL,
  `nomVersion` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `ageMinimum` mediumint(8) unsigned DEFAULT NULL,
  `nbJoueurs` varchar(45) NOT NULL,
  `nbJoueurRecommande` mediumint(8) unsigned DEFAULT NULL,
  `dureePartie` timestamp NULL DEFAULT NULL,
  `prixAchat` decimal(8,0) unsigned NOT NULL,
  `anneeSortie` year(4) DEFAULT NULL,
  `illustrateur` varchar(45) DEFAULT NULL,
  `distributeur` varchar(45) DEFAULT NULL,
  `editeur` varchar(45) NOT NULL,
  `fkIdJeux` int(10) unsigned NOT NULL,
  `fkIdLangue` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idVersion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MDTJ_LIEU`
--

DROP TABLE IF EXISTS `MDTJ_LIEU`;
CREATE TABLE IF NOT EXISTS `MDTJ_LIEU` (
  `idLieu` int(10) unsigned NOT NULL,
  `nomLieu` varchar(45) NOT NULL,
  PRIMARY KEY (`idLieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
