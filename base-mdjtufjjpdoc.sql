-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Jeu 10 Mai 2012 à 09:12
-- Version du serveur: 5.5.21
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mdjtufjjpdoc`
--

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_GROUPES`
--

CREATE TABLE IF NOT EXISTS `MDJT_GROUPES` (
  `idGroupe` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomGroupe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idGroupe`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `MDJT_GROUPES`
--

INSERT INTO `MDJT_GROUPES` (`idGroupe`, `nomGroupe`) VALUES
(1, 'Dieu');

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LIEN_UTILISATEURS_GROUPES`
--

CREATE TABLE IF NOT EXISTS `MDJT_LIEN_UTILISATEURS_GROUPES` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idGroupe` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `MDJT_LIEN_UTILISATEURS_GROUPES`
--

INSERT INTO `MDJT_LIEN_UTILISATEURS_GROUPES` (`id`, `idUtilisateur`, `idGroupe`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_TYPE_ADHERENT`
--

CREATE TABLE IF NOT EXISTS `MDJT_TYPE_ADHERENT` (
  `idTypeAdherent` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeAdherent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTypeAdherent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `MDJT_TYPE_ADHERENT`
--

INSERT INTO `MDJT_TYPE_ADHERENT` (`idTypeAdherent`, `typeAdherent`) VALUES
(1, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_UTILISATEURS`
--

CREATE TABLE IF NOT EXISTS `MDJT_UTILISATEURS` (
  `idUtilisateur` int(10) unsigned NOT NULL,
  `titre` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idVille` int(10) unsigned NOT NULL,
  `telephone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `portable` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `profession` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateAdhesion` date NOT NULL,
  `dateCotisation` date NOT NULL,
  `exemptCotisation` tinyint(1) NOT NULL,
  `commentaires` text COLLATE utf8_unicode_ci NOT NULL,
  `idTypeAdherent` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `MDJT_UTILISATEURS`
--

INSERT INTO `MDJT_UTILISATEURS` (`idUtilisateur`, `titre`, `nom`, `prenom`, `email`, `actif`, `adresse`, `idVille`, `telephone`, `portable`, `dateNaissance`, `profession`, `dateAdhesion`, `dateCotisation`, `exemptCotisation`, `commentaires`, `idTypeAdherent`) VALUES
(2, 'M', 'Dieu', 'Administrateur', 'admin@dieu.fr', 1, '64 Avenue Jean Portalis', 1, '0123456789', '0678954321', '0000-01-01', 'Dieu', '2012-02-02', '2012-03-02', 1, 'Je suis Dieu', 1);

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_VILLES`
--

CREATE TABLE IF NOT EXISTS `MDJT_VILLES` (
  `idVille` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codePostal` mediumint(8) unsigned NOT NULL,
  `nomVille` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idVille`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `MDJT_VILLES`
--

INSERT INTO `MDJT_VILLES` (`idVille`, `codePostal`, `nomVille`) VALUES
(1, 37200, 'Tours');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
