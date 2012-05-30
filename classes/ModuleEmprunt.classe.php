<?php
/** 
 * Module Emprunt
 * @package composant
 */
// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_EMPRUNT", RACINE_SITE . "module.php?idModule=Emprunt");

/**
 * Module Emprunt
 * @author Romain Laï-King
 * @version 0.1
 * @package module
 */


class ModuleEmprunt extends Module
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
		$this->ouvreBloc("<form method='post' id='formProfil' action='".MODULE_EMPRUNT."'>");
		$this->ajouteLigne("<legend>Emprunter</legend>");
		$this->ouvreBloc("<fieldset>");
		$this->ouvreBloc("<ol>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"idUtilisateur\">" . $this->convertiTexte("IdUtilisateur") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"idUtilisateur\" name=\"idUtilisateur\" />");	
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"prenomEmprunteur\">" . $this->convertiTexte("Prénom") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"prenomEmprunteur\" name=\"prenomEmprunteur\" />");	
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"nomEmprunteur\">" . $this->convertiTexte("Nom") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"nomEmprunteur\" name=\"nomEmprunteur\" />");	
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"code_barre\">" . $this->convertiTexte("Code barre") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"code_barre\" name=\"code_barre\" />");
		$this->fermeBloc("</li>");
		//$this-creationInputText();
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"date_d'emprunt\">" . $this->convertiTexte("Date d'emprunt") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"date_d'emprunt\" value=\"".date('d-m-Y')."\" name=\"date_d'emprunt\" />");		
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<ol>");
		$this->ajouteLigne("<button type='submit' name='valider' value='true'>" . $this->convertiTexte("Valider") . "</button>");

		$this->fermeBloc("</fieldset>");
		$this->fermeBloc("</form>");
	}


}


?>