-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2012 at 08:06 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mdjtufjjpdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_auteur`
--

CREATE TABLE IF NOT EXISTS `mdjt_auteur` (
  `idAuteur` int(10) NOT NULL AUTO_INCREMENT,
  `nomAuteur` varchar(45) NOT NULL,
  PRIMARY KEY (`idAuteur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mdjt_auteur`
--

INSERT INTO `mdjt_auteur` (`idAuteur`, `nomAuteur`) VALUES
(1, 'Lorenzo Silva'),
(2, 'Aureliano Buonfino'),
(3, 'Lorenzo Tucci Sorrentino ');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_auteur_jeu`
--

CREATE TABLE IF NOT EXISTS `mdjt_auteur_jeu` (
  `idAuteurJeu` int(10) NOT NULL AUTO_INCREMENT,
  `idAuteur` int(10) NOT NULL,
  `idJeu` int(10) NOT NULL,
  PRIMARY KEY (`idAuteurJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mdjt_auteur_jeu`
--

INSERT INTO `mdjt_auteur_jeu` (`idAuteurJeu`, `idAuteur`, `idJeu`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_categorie`
--

CREATE TABLE IF NOT EXISTS `mdjt_categorie` (
  `idCategorie` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionCategorie` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`idCategorie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mdjt_categorie`
--

INSERT INTO `mdjt_categorie` (`idCategorie`, `nomCategorie`, `descriptionCategorie`) VALUES
(1, 'plateau', 'jeu de plateau'),
(2, 'Combat', 'du sang!!');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_categorie_jeu`
--

CREATE TABLE IF NOT EXISTS `mdjt_categorie_jeu` (
  `idCategorieJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idJeu` int(10) unsigned NOT NULL,
  `idCategorie` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idCategorieJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mdjt_categorie_jeu`
--

INSERT INTO `mdjt_categorie_jeu` (`idCategorieJeu`, `idJeu`, `idCategorie`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_distributeur`
--

CREATE TABLE IF NOT EXISTS `mdjt_distributeur` (
  `idDistributeur` int(10) NOT NULL AUTO_INCREMENT,
  `nomDistributeur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idDistributeur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mdjt_distributeur`
--

INSERT INTO `mdjt_distributeur` (`idDistributeur`, `nomDistributeur`) VALUES
(1, 'Iello');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_distributeur_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_distributeur_version` (
  `idDistributeurVersion` int(10) NOT NULL AUTO_INCREMENT,
  `idDistributeur` int(10) NOT NULL,
  `idVersion` int(10) NOT NULL,
  PRIMARY KEY (`idDistributeurVersion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mdjt_distributeur_version`
--

INSERT INTO `mdjt_distributeur_version` (`idDistributeurVersion`, `idDistributeur`, `idVersion`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_editeur`
--

CREATE TABLE IF NOT EXISTS `mdjt_editeur` (
  `idEditeur` int(10) NOT NULL AUTO_INCREMENT,
  `nomEditeur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEditeur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mdjt_editeur`
--

INSERT INTO `mdjt_editeur` (`idEditeur`, `nomEditeur`) VALUES
(1, 'Cranio Creations'),
(2, 'Heidelberger'),
(3, 'Iello');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_editeur_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_editeur_version` (
  `idEditeurVersion` int(10) NOT NULL AUTO_INCREMENT,
  `idEditeur` int(10) NOT NULL,
  `idVersion` int(10) NOT NULL,
  PRIMARY KEY (`idEditeurVersion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mdjt_editeur_version`
--

INSERT INTO `mdjt_editeur_version` (`idEditeurVersion`, `idEditeur`, `idVersion`) VALUES
(3, 1, 1),
(4, 2, 1),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_emprunt`
--

CREATE TABLE IF NOT EXISTS `mdjt_emprunt` (
  `idEmprunt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateEmprunt` date NOT NULL,
  `dateRetourSouhaite` date NOT NULL,
  `dateRetourReel` date DEFAULT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idEmprunt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_etat_exemplaire`
--

CREATE TABLE IF NOT EXISTS `mdjt_etat_exemplaire` (
  `idEtatExemplaire` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomEtat` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEtatExemplaire`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_exemplaire`
--

CREATE TABLE IF NOT EXISTS `mdjt_exemplaire` (
  `idExemplaire` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'idexemplaire = codeBarre',
  `codeBarre` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionExemplaire` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prixMDJT` decimal(8,0) NOT NULL,
  `dateAchat` date NOT NULL,
  `dateFinVie` date DEFAULT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  `idEtatExemplaire` int(10) unsigned NOT NULL,
  `idLieuReel` int(10) unsigned NOT NULL,
  `idLieuTempo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idExemplaire`),
  UNIQUE KEY `codeBarre` (`codeBarre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mdjt_exemplaire`
--

INSERT INTO `mdjt_exemplaire` (`idExemplaire`, `codeBarre`, `descriptionExemplaire`, `prixMDJT`, `dateAchat`, `dateFinVie`, `idVersion`, `idEtatExemplaire`, `idLieuReel`, `idLieuTempo`) VALUES
(1, '0000000000', 'test description exemplaire', '10', '2012-05-07', NULL, 1, 1, 1, 1),
(2, '121121221221212', '"''("''(', '44', '2012-05-09', NULL, 1, 4, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_extension`
--

CREATE TABLE IF NOT EXISTS `mdjt_extension` (
  `idExtension` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nature` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idVersionBase` int(10) unsigned NOT NULL,
  `idVersionExtension` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idExtension`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_faire_partie_kit`
--

CREATE TABLE IF NOT EXISTS `mdjt_faire_partie_kit` (
  `idFairePartieKit` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idExemplaire` int(10) unsigned NOT NULL,
  `idKitJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idFairePartieKit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_illustrateur`
--

CREATE TABLE IF NOT EXISTS `mdjt_illustrateur` (
  `idIllustrateur` int(10) NOT NULL AUTO_INCREMENT,
  `nomIllustrateur` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idIllustrateur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mdjt_illustrateur`
--

INSERT INTO `mdjt_illustrateur` (`idIllustrateur`, `nomIllustrateur`) VALUES
(1, 'Giulia Ghigini');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_illustrateur_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_illustrateur_version` (
  `idIllustrateurVersion` int(10) NOT NULL AUTO_INCREMENT,
  `idIllustrateur` int(10) NOT NULL,
  `idVersion` int(10) NOT NULL,
  PRIMARY KEY (`idIllustrateurVersion`),
  KEY `idIllustrateurVersion` (`idIllustrateurVersion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mdjt_illustrateur_version`
--

INSERT INTO `mdjt_illustrateur_version` (`idIllustrateurVersion`, `idIllustrateur`, `idVersion`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_inventaire`
--

CREATE TABLE IF NOT EXISTS `mdjt_inventaire` (
  `idInventaire` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateInventaire` date NOT NULL,
  `commentaireInventaire` text COLLATE utf8_unicode_ci,
  `idUtilisateurs` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idInventaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_jeux`
--

CREATE TABLE IF NOT EXISTS `mdjt_jeux` (
  `idJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descriptionJeu` text COLLATE utf8_unicode_ci,
  `idPays` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `mdjt_jeux`
--

INSERT INTO `mdjt_jeux` (`idJeu`, `descriptionJeu`, `idPays`) VALUES
(1, 'Celebre jeu du combattant de donjon', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_kit_jeu`
--

CREATE TABLE IF NOT EXISTS `mdjt_kit_jeu` (
  `idKitJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomKit` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionKit` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idKitJeu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_langue`
--

CREATE TABLE IF NOT EXISTS `mdjt_langue` (
  `idLangue` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomLangue` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLangue`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `mdjt_langue`
--

INSERT INTO `mdjt_langue` (`idLangue`, `nomLangue`) VALUES
(1, 'Francais'),
(2, 'Anglais');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_langue_regle`
--

CREATE TABLE IF NOT EXISTS `mdjt_langue_regle` (
  `idLangueRegle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idExemplaire` int(10) unsigned NOT NULL,
  `idLangue` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idLangueRegle`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_lieu`
--

CREATE TABLE IF NOT EXISTS `mdjt_lieu` (
  `idLieu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomLieu` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idLieu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mdjt_lieu`
--

INSERT INTO `mdjt_lieu` (`idLieu`, `nomLieu`) VALUES
(1, 'tours'),
(5, 'blois');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_nom_jeu`
--

CREATE TABLE IF NOT EXISTS `mdjt_nom_jeu` (
  `idNomJeu` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomJeu` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idLangue` int(10) unsigned NOT NULL,
  `idJeu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNomJeu`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

--
-- Dumping data for table `mdjt_nom_jeu`
--

INSERT INTO `mdjt_nom_jeu` (`idNomJeu`, `nomJeu`, `idLangue`, `idJeu`) VALUES
(1, 'Dungeon Fighter', 2, 1),
(2, ' Le combatant du donjon', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_note_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_note_version` (
  `idNoteVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noteVersion` int(10) unsigned NOT NULL,
  `commentaireNoteVersion` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idUtilisateurs` int(10) unsigned NOT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idNoteVersion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_pays`
--

CREATE TABLE IF NOT EXISTS `mdjt_pays` (
  `idPays` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomPays` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPays`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Dumping data for table `mdjt_pays`
--

INSERT INTO `mdjt_pays` (`idPays`, `nomPays`) VALUES
(1, 'France');

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_photo`
--

CREATE TABLE IF NOT EXISTS `mdjt_photo` (
  `idPhoto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomPhoto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `texteAlternatif` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPhoto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_photo_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_photo_version` (
  `idPhotoVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPhoto` int(10) unsigned NOT NULL,
  `idVersion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPhotoVersion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_reservation`
--

CREATE TABLE IF NOT EXISTS `mdjt_reservation` (
  `idReversation` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dateSouhaiteEmprunt` date NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idExemplaire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idReversation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_suggestion`
--

CREATE TABLE IF NOT EXISTS `mdjt_suggestion` (
  `idSuggestion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commentaireSugeestion` text COLLATE utf8_unicode_ci,
  `etatSuggestion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idJeux` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idSuggestion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mdjt_version`
--

CREATE TABLE IF NOT EXISTS `mdjt_version` (
  `idVersion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomVersion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descriptionVersion` text COLLATE utf8_unicode_ci,
  `ageMinimum` mediumint(8) unsigned DEFAULT NULL,
  `nbJoueurRecommande` mediumint(8) unsigned DEFAULT NULL,
  `dureePartie` time DEFAULT NULL,
  `prixAchat` decimal(8,0) unsigned DEFAULT NULL,
  `anneeSortie` year(4) DEFAULT NULL,
  `idJeu` int(10) unsigned DEFAULT NULL,
  `idLangue` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idVersion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mdjt_version`
--

INSERT INTO `mdjt_version` (`idVersion`, `nomVersion`, `descriptionVersion`, `ageMinimum`, `nbJoueurRecommande`, `dureePartie`, `prixAchat`, `anneeSortie`, `idJeu`, `idLangue`) VALUES
(1, 'Dungeon Fighter', 'Le Dungeon est constitue de 3 zones contenant des pieces. La derniere zone est celle du boss de fin de niveau.\r\n\r\nLes joueurs peuvent choisir la difficulte du jeu qui fera varier le nombre et le niveau des monstres rencontres.\r\n\r\nChaque joueur dispose d''une fiche de personnage. L''equipe dispose en debut de partie d''un de de bonus et de deux pieces d''or. Le joueur qui ressemble le plus a un heros devient le chef de l''equipe pour la partie.\r\nLe chef decide du chemin emprunte et des achats d''equipements en accord avec les autres joueurs (ou pas mais apres on se dispute).', 7, 4, '00:45:00', '40', 2012, 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
