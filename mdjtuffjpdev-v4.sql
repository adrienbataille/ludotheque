SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `mdjtufjjpdev` ;
CREATE SCHEMA IF NOT EXISTS `mdjtufjjpdev` DEFAULT CHARACTER SET utf8 ;
USE `mdjtufjjpdev` ;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_CATEGORIE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_CATEGORIE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_CATEGORIE` (
  `idCategorie` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomCategorie` VARCHAR(45) NOT NULL ,
  `descriptionCategorie` TEXT NULL ,
  PRIMARY KEY (`idCategorie`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_CATEGORIE_JEU`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_CATEGORIE_JEU` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_CATEGORIE_JEU` (
  `idCategorieJeu` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idJeu` INT UNSIGNED NOT NULL ,
  `idCategorie` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idCategorieJeu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_EMPRUNT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_EMPRUNT` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_EMPRUNT` (
  `idEmprunt` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dateEmprunt` DATE NOT NULL ,
  `dateRetourSouhaite` DATE NOT NULL ,
  `dateRetourReel` DATE NULL ,
  `idUtilisateur` INT(10) UNSIGNED NOT NULL ,
  `idExemplaire` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idEmprunt`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_ETAT_EXEMPLAIRE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_ETAT_EXEMPLAIRE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_ETAT_EXEMPLAIRE` (
  `idEtatExemplaire` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomEtat` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idEtatExemplaire`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_EXEMPLAIRE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_EXEMPLAIRE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_EXEMPLAIRE` (
  `idExemplaire` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'idexemplaire = codeBarre' ,
  `descriptionExemplaire` VARCHAR(45) NULL ,
  `prixMJDT` DECIMAL(8) NOT NULL ,
  `dateAchat` DATE NOT NULL ,
  `dateFinVie` DATE NULL ,
  `idVersion` INT UNSIGNED NOT NULL ,
  `idEtatExemplaire` INT UNSIGNED NOT NULL ,
  `idLieuReel` INT UNSIGNED NOT NULL ,
  `idLieuTempo` INT UNSIGNED NULL ,
  PRIMARY KEY (`idExemplaire`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_EXTENSION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_EXTENSION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_EXTENSION` (
  `idExtension` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nature` VARCHAR(45) NULL ,
  `idVersionBase` INT(10) UNSIGNED NOT NULL ,
  `idVersionExtension` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idExtension`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_FAIRE_PARTIE_KIT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_FAIRE_PARTIE_KIT` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_FAIRE_PARTIE_KIT` (
  `idFairePartieKit` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idExemplaire` INT(10) UNSIGNED NOT NULL ,
  `idKitJeu` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idFairePartieKit`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_INVENTAIRE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_INVENTAIRE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_INVENTAIRE` (
  `idInventaire` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dateInventaire` DATE NOT NULL ,
  `commentaireInventaire` TEXT NULL ,
  `idUtilisateurs` INT(10) UNSIGNED NOT NULL ,
  `idExemplaire` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idInventaire`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_JEUX`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_JEUX` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_JEUX` (
  `idJeu` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `descriptionJeu` TEXT NULL ,
  `auteur` VARCHAR(45) NULL ,
  `idPays` INT UNSIGNED NULL ,
  PRIMARY KEY (`idJeu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_KIT_JEU`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_KIT_JEU` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_KIT_JEU` (
  `idKitJeu` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomKit` VARCHAR(45) NOT NULL ,
  `descriptionKit` VARCHAR(45) NULL ,
  PRIMARY KEY (`idKitJeu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_LANGUE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_LANGUE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_LANGUE` (
  `idLangue` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomLangue` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idLangue`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_LANGUE_REGLE`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_LANGUE_REGLE` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_LANGUE_REGLE` (
  `idLangueRegle` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idExemplaire` INT(10) UNSIGNED NOT NULL ,
  `idLangue` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idLangueRegle`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDTJ_LIEU`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDTJ_LIEU` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDTJ_LIEU` (
  `idLieu` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomLieu` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idLieu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_NB_JOUEUR`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_NB_JOUEUR` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_NB_JOUEUR` (
  `idNbJoueur` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nbJoueur` INT(4) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idNbJoueur`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_NB_JOUEUR_VERSION_JEU`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_NB_JOUEUR_VERSION_JEU` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_NB_JOUEUR_VERSION_JEU` (
  `idNbJoueurJeu` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idNbJoueur` INT(10) UNSIGNED NOT NULL ,
  `idVersion` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idNbJoueurJeu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_NOM_JEU`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_NOM_JEU` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_NOM_JEU` (
  `idNomJeu` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomJeu` VARCHAR(45) NOT NULL ,
  `idLangue` INT UNSIGNED NOT NULL ,
  `idJeux` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idNomJeu`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_NOTE_VERSION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_NOTE_VERSION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_NOTE_VERSION` (
  `idNoteVersion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `noteVersion` INT UNSIGNED NOT NULL ,
  `commentaireNoteVersion` VARCHAR(45) NULL ,
  `idUtilisateurs` INT(10) UNSIGNED NOT NULL ,
  `idVersion` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`idNoteVersion`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_PAYS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_PAYS` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_PAYS` (
  `idPays` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomPays` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idPays`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_PHOTO`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_PHOTO` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_PHOTO` (
  `idPhoto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomPhoto` VARCHAR(45) NOT NULL ,
  `texteAlternatif` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idPhoto`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_PHOTO_VERSION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_PHOTO_VERSION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_PHOTO_VERSION` (
  `idPhotoVersion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `idPhoto` INT(10) UNSIGNED NOT NULL ,
  `idVersion` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idPhotoVersion`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_RESERVATION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_RESERVATION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_RESERVATION` (
  `idReversation` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `dateSouhaiteEmprunt` DATE NOT NULL ,
  `idUtilisateur` INT(10) UNSIGNED NOT NULL ,
  `idExemplaire` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idReversation`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_SUGGESTION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_SUGGESTION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_SUGGESTION` (
  `idSuggestion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `commentaireSugeestion` TEXT NULL ,
  `etatSuggestion` VARCHAR(45) NOT NULL ,
  `idUtilisateur` INT(10) UNSIGNED NOT NULL ,
  `idJeux` INT(10) UNSIGNED NOT NULL ,
  PRIMARY KEY (`idSuggestion`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mdjtufjjpdev`.`MDJT_VERSION`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mdjtufjjpdev`.`MDJT_VERSION` ;

CREATE  TABLE IF NOT EXISTS `mdjtufjjpdev`.`MDJT_VERSION` (
  `idVersion` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nomVersion` VARCHAR(45) NOT NULL ,
  `descriptionVersion` VARCHAR(45) NULL ,
  `ageMinimum` MEDIUMINT(8) UNSIGNED NULL ,
  `nbJoueurRecommande` MEDIUMINT(8) UNSIGNED NULL ,
  `dureePartie` TIMESTAMP NULL ,
  `prixAchat` DECIMAL(8) UNSIGNED NOT NULL ,
  `anneeSortie` YEAR NULL ,
  `illustrateur` VARCHAR(45) NULL ,
  `distributeur` VARCHAR(45) NULL ,
  `editeur` VARCHAR(45) NOT NULL ,
  `idJeu` INT UNSIGNED NOT NULL ,
  `idLangue` INT UNSIGNED NULL ,
  PRIMARY KEY (`idVersion`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
