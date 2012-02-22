-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Client: mysql5-14.90
-- Généré le : Ven 10 Février 2012 à 15:49
-- Version du serveur: 5.1.49
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

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_LIEN_UTILISATEURS_GROUPES`
--

CREATE TABLE IF NOT EXISTS `MDJT_LIEN_UTILISATEURS_GROUPES` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUtilisateur` int(10) unsigned NOT NULL,
  `idGroupe` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `MDJT_TYPE_ADHERENT`
--

CREATE TABLE IF NOT EXISTS `MDJT_TYPE_ADHERENT` (
  `idTypeAdherent` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeAdherent` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idTypeAdherent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
