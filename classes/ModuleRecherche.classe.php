<?php

// Inclusions
require_once("classes/Module.classe.php");
require_once("classes/ComposantRecherche.classe.php");


//Constantes
define("MODULE_RECHERCHE", RACINE_SITE . "module.php?idModule=Recherche");

/**
 * Module recherche
 * @author Romain Laï-King, Rania Daoudi, Ziyang Ke
 * @package module
 * @version 0.1
 */


class ModuleRecherche extends Module
{


	/**
	 * Constructeur.
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->affiche();
		$comp=new ComposantRecherche();
		$this->ajouteLigne($comp->recupContenu());


	}
	/**
	 * Affiche le formulaire de recherche
	 */
	private function affiche()
	{
	}
}


?>