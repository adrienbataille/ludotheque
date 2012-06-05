-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 12 Avril 2012 à 14:39
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
  `idCategorie` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionCategorie` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idCategorie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_CATEGORIE_JEU`
--

DROP TABLE IF EXISTS `MDJT_CATEGORIE_JEU`;
CREATE TABLE IF NOT EXISTS `MDJT_CATEGORIE_JEU` (
  `idCategorieJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idJeu` int(10) unsigned NOT NULL,
  `idCategorie` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idCategorieJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_DISTRIBUTEUR`
--

DROP TABLE IF EXISTS `MDJT_DISTRIBUTEUR`;
CREATE TABLE IF NOT EXISTS `MDJT_DISTRIBUTEUR` (
  `idDistributeur` int(10) NOT NULL,
  `nomDistributeur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idDistributeur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EDITEUR`
--

DROP TABLE IF EXISTS `MDJT_EDITEUR`;
CREATE TABLE IF NOT EXISTS `MDJT_EDITEUR` (
  `idEditeur` int(10) NOT NULL,
  `nomEditeur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEditeur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EMPRUNT`
--

DROP TABLE IF EXISTS `MDJT_EMPRUNT`;
CREATE TABLE IF NOT EXISTS `MDJT_EMPRUNT` (
  `idEmprunt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateEmprunt` date NOT NULL,
  `dateRetourSouhaite` date NOT NULL,
  `dateRetourReel` date DEFAULT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idEmprunt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_ETAT_EXEMPLAIRE`
--

DROP TABLE IF EXISTS `MDJT_ETAT_EXEMPLAIRE`;
CREATE TABLE IF NOT EXISTS `MDJT_ETAT_EXEMPLAIRE` (
  `idEtatExemplaire` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomEtat` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEtatExemplaire`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EXEMPLAIRE`
--

DROP TABLE IF EXISTS `MDJT_EXEMPLAIRE`;
CREATE TABLE IF NOT EXISTS `MDJT_EXEMPLAIRE` (
  `idExemplaire` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'idexemplaire = codeBarre',
  `descriptionExemplaire` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prixMJDT` decimal(8,0) NOT NULL,
  `dateAchat` date NOT NULL,
  `dateFinVie` date DEFAULT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  `idEtatExemplaire` int(10) unsigned NOT NULL,
  `idLieuReel` int(10) unsigned NOT NULL,
  `idLieuTempo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idExemplaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_EXTENSION`
--

DROP TABLE IF EXISTS `MDJT_EXTENSION`;
CREATE TABLE IF NOT EXISTS `MDJT_EXTENSION` (
  `idExtension` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nature` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idVersionBase` int(10) unsigned NOT NULL,
  `idVersionExtension` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idExtension`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_FAIRE_PARTIE_KIT`
--

DROP TABLE IF EXISTS `MDJT_FAIRE_PARTIE_KIT`;
CREATE TABLE IF NOT EXISTS `MDJT_FAIRE_PARTIE_KIT` (
  `idFairePartieKit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idExemplaire` int(10) unsigned NOT NULL,
  `idKitJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idFairePartieKit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_ILLUSTRATEUR`
--

DROP TABLE IF EXISTS `MDJT_ILLUSTRATEUR`;
CREATE TABLE IF NOT EXISTS `MDJT_ILLUSTRATEUR` (
  `idIllustrateur` int(10) NOT NULL,
  `nomIllustrateur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idIllustrateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_INVENTAIRE`
--

DROP TABLE IF EXISTS `MDJT_INVENTAIRE`;
CREATE TABLE IF NOT EXISTS `MDJT_INVENTAIRE` (
  `idInventaire` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateInventaire` date NOT NULL,
  `commentaireInventaire` text COLLATE utf8_unicode_ci,
  `idUtilisateurs` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idInventaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_JEUX`
--

DROP TABLE IF EXISTS `MDJT_JEUX`;
CREATE TABLE IF NOT EXISTS `MDJT_JEUX` (
  `idJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descriptionJeu` text COLLATE utf8_unicode_ci,
  `auteur` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idPays` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_KIT_JEU`
--

DROP TABLE IF EXISTS `MDJT_KIT_JEU`;
CREATE TABLE IF NOT EXISTS `MDJT_KIT_JEU` (
  `idKitJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomKit` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionKit` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idKitJeu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LANGUE`
--

DROP TABLE IF EXISTS `MDJT_LANGUE`;
CREATE TABLE IF NOT EXISTS `MDJT_LANGUE` (
  `idLangue` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomLangue` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLangue`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LANGUE_REGLE`
--

DROP TABLE IF EXISTS `MDJT_LANGUE_REGLE`;
CREATE TABLE IF NOT EXISTS `MDJT_LANGUE_REGLE` (
  `idLangueRegle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idExemplaire` int(10) unsigned NOT NULL,
  `idLangue` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idLangueRegle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LIEU`
--

DROP TABLE IF EXISTS `MDJT_LIEU`;
CREATE TABLE IF NOT EXISTS `MDJT_LIEU` (
  `idLieu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomLieu` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLieu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NB_JOUEUR`
--

DROP TABLE IF EXISTS `MDJT_NB_JOUEUR`;
CREATE TABLE IF NOT EXISTS `MDJT_NB_JOUEUR` (
  `idNbJoueur` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `nbJoueur` int(4) unsigned NOT NULL,
  PRIMARY KEY (`idNbJoueur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NB_JOUEUR_VERSION_JEU`
--

DROP TABLE IF EXISTS `MDJT_NB_JOUEUR_VERSION_JEU`;
CREATE TABLE IF NOT EXISTS `MDJT_NB_JOUEUR_VERSION_JEU` (
  `idNbJoueurJeu` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `idNbJoueur` int(10) unsigned NOT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNbJoueurJeu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NOM_JEU`
--

DROP TABLE IF EXISTS `MDJT_NOM_JEU`;
CREATE TABLE IF NOT EXISTS `MDJT_NOM_JEU` (
  `idNomJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomJeu` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idLangue` int(10) unsigned NOT NULL,
  `idJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNomJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_NOTE_VERSION`
--

DROP TABLE IF EXISTS `MDJT_NOTE_VERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_NOTE_VERSION` (
  `idNoteVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noteVersion` int(10) unsigned NOT NULL,
  `commentaireNoteVersion` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idUtilisateurs` int(10) unsigned NOT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNoteVersion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PAYS`
--

DROP TABLE IF EXISTS `MDJT_PAYS`;
CREATE TABLE IF NOT EXISTS `MDJT_PAYS` (
  `idPays` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPays`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PHOTO`
--

DROP TABLE IF EXISTS `MDJT_PHOTO`;
CREATE TABLE IF NOT EXISTS `MDJT_PHOTO` (
  `idPhoto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomPhoto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `texteAlternatif` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPhoto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_PHOTO_VERSION`
--

DROP TABLE IF EXISTS `MDJT_PHOTO_VERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_PHOTO_VERSION` (
  `idPhotoVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPhoto` int(10) unsigned NOT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPhotoVersion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_RESERVATION`
--

DROP TABLE IF EXISTS `MDJT_RESERVATION`;
CREATE TABLE IF NOT EXISTS `MDJT_RESERVATION` (
  `idReversation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateSouhaiteEmprunt` date NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idReversation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_SUGGESTION`
--

DROP TABLE IF EXISTS `MDJT_SUGGESTION`;
CREATE TABLE IF NOT EXISTS `MDJT_SUGGESTION` (
  `idSuggestion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commentaireSugeestion` text COLLATE utf8_unicode_ci,
  `etatSuggestion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idSuggestion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_VERSION`
--

DROP TABLE IF EXISTS `MDJT_VERSION`;
CREATE TABLE IF NOT EXISTS `MDJT_VERSION` (
  `idVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomVersion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionVersion` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ageMinimum` mediumint(8) unsigned DEFAULT NULL,
  `nbJoueurRecommande` mediumint(8) unsigned DEFAULT NULL,
  `dureePartie` time DEFAULT NULL,
  `prixAchat` decimal(8,0) unsigned NOT NULL,
  `anneeSortie` year(4) DEFAULT NULL,
  `idIllustrateur` int(10) DEFAULT NULL,
  `idDistributeur` int(10) DEFAULT NULL,
  `idEditeur` int(10) DEFAULT NULL,
  `idJeu` int(10) unsigned NOT NULL,
  `idLangue` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idVersion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
