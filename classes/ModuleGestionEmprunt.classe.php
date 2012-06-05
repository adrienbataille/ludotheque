<?php
/** 
 * Module Emprunt
 * @package composant
 */
// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_EMPRUNTER", RACINE_SITE . "module.php?idModule=Emprunter");

/**
 * Module GestionEmprunt
 * @author Romain Laï-King
 * @version 0.1
 * @package module
 */


class ModuleEmprunter extends Module
{
	/**
	 * @var AccesAuxDonneesDev Connexion BDD
	 */
	private $maBase = NULL;

	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
		$this->afficheFormulaire();		

	}
	/**
	 * Affiche le formulaire de recherche
	 */
	private function afficheFormulaire()
	{
		$this->ouvreBloc("<div id='module_emprunter'>");
		
		$this->ouvreBloc("<form method='post' action='" . MODULE_EMPRUNT. "' id='formProfil'>");        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='emprunter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='emprunter' value='true'>" . $this->convertiTexte("Emprunt") . "</button>");
		$this->fermeBloc("</fieldset>");		
		$this->fermeBloc("</form>");
			
		$this->ouvreBloc("<form method='post' action='" . MODULE_RETOUR . "' id='formProfil'>");        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='emprunter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='emprunter' value='true'>" . $this->convertiTexte("Retour") . "</button>");
		$this->fermeBloc("</fieldset>");		
		$this->fermeBloc("</form>");  
		
		/*
		$this->ouvreBloc("<form method='post' action='" . MODULE_INVENTAIRE . "' id='formProfil'>");        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='inventaire' value='true' />");
		$this->ajouteLigne("<button type='submit' name='inventaire' value='true'>" . $this->convertiTexte("Inventaire") . "</button>");
		$this->fermeBloc("</fieldset>");		
		$this->fermeBloc("</form>");   	
    	*/
        /*
		$this->ouvreBloc("<form method='post' action='" . MODULE_GESTION_EMPRUNT. "' id='formProfil'>");        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='emprunter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='emprunter' value='true'>" . $this->convertiTexte("Gestion emprunt") . "</button>");
		$this->fermeBloc("</fieldset>");		
		$this->fermeBloc("</form>");
		*/
				
		$this->fermeBloc("</div>");
	}


}


?>