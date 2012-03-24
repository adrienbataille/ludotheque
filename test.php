<?php

require_once("classes/RequeteSQL.classe.php");
require_once("classes/AccesAuxDonneesDev.classe.php");

$query=new RequeteSQL();
$query->setRequete("SELECT nomPhoto, idVersion, nomJeu, nomVersion, idEtatExemplaire, COUNT(idExemplaire) AS nbExemplaire");
	
//pour le moment je garde les X de Jeu tant qu'on a pas la nouvelle BDD corrigé
//Voir les commentaires dans RequeteSQL pour les méthodes
	
//On joint les 6 tables nécessaires pour le SELECT DE BASE
$query->jointure(TABLE_EXEMPLAIRE, ID_VERSION, TABLE_VERSION, ID_VERSION);
$query->jointure(TABLE_JEUX, ID_JEU, TABLE_VERSION, ID_JEU);
$query->jointure(TABLE_ETAT_EXEMPLAIRE, ID_ETAT_EXEMPLAIRE, TABLE_EXEMPLAIRE, ID_ETAT_EXEMPLAIRE);
$query->jointure(TABLE_PHOTO, ID_PHOTO, TABLE_PHOTO_VERSION,ID_PHOTO);
$query->jointure(TABLE_PHOTO_VERSION, ID_VERSION, TABLE_VERSION, ID_VERSION);
$query->jointure(TABLE_NOM_JEU,ID_JEU,TABLE_JEUX,ID_JEU);
	
// Création dynamique de la requète maintenant
$critere["nom"]="jeu";
$critere["langue"]="Anglais";

//Par nom. On regarde aussi bien le nom du jeu que le nom de la version.
if($critere["nom"]!=""){
	//comme il y a des LIKE, j'ai pas fait de méthode particulière encore
	$string="AND ( nomVersion LIKE '%" .$critere["nom"]."%' OR nomJeu LIKE '%" .$critere["nom"]. "%') ";
	$query->ajoutWhereLibre($string);
}

//Par langue. On regarde seulement la langue de la version ( pour le moment )
if($critere["langue"]){
	$query->jointure(TABLE_LANGUE, ID_LANGUE, TABLE_VERSION, ID_LANGUE);
	$query->ajoutAndEgal(TABLE_LANGUE, NOM_LANGUE, $critere["langue"]);
}

echo $query->debug();
?>