<?php
/** 
 * Module recherche
 * @package composant
 */
// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_RECHERCHE", RACINE_SITE . "module.php?idModule=Recherche");

/**
 * Module recherche
 * @author Romain Laï-King
 * @version 0.1
 * @package module
 */


class ModuleRecherche extends Module
{
	/**
	 * @var AccesAuxDonneesDev Connexion BDD
	 */
	private $baseDonnees = NULL;
	
	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		$this->afficheFormulaire();

		
	}
	/**
	 * Affiche le formulaire de recherche
	 */
	private function afficheFormulaire()
	{	
		$this->ouvreBloc("<form method='post' action='".MODULE_RECHERCHE."'>");
		$this->ajouteLigne("Hello World");
		//$this->baseDonnees = AccesAuxDonneesDev::recupAccesDonnees();
		$langue=$this->maBase->listeLangue();
		$etat=$this->maBase->listeEtat();
		$lieu=$this->maBase->listeLieu();
		var_dump($langue);
		//var_dump($etat);
		//var_dump($lieu);
		$test=$_POST['lang'];
		var_dump($test);
		$this->ajouteLigne($test["test"]);
		$this->ajouteLigne($test["hidden"]);
		$ch="lol";
		$ch.= "sfs";
		print_r($ch);
		$this->creationSelect($langue,"lang[test]");
		$this->ajouteLigne($langue[0][0]);
		//$this->ajouteLigne(var_dump($this->maBase->rechercheParLangue()))
		$this->ajouteLigne("<input type='hidden' value='' name='lang[hidden]' >");
		$this->ajouteLigne("<input type='submit' value='kikoo' />");
		$this->fermeBloc("</form>");
	}
	
	/** Fonction qui crée des listes HTML <select>
	* @param array tableau 2 colonnes, la première étant la value, deuxième le nom
	* @param string nom du paramètre
	*/

	private function creationSelect($array,$name){
		$this->ouvreBloc("<select name=\"".$name."\">");
		$this->ajouteLigne("<option value=\"\">Indifférent</option>");
		foreach($array as $row){
			$this->ajouteLigne("<option value=\"".$row[0]."\">".$row[1]."</option>");
		}
		$this->fermeBloc("</select>");
	}
}


?>