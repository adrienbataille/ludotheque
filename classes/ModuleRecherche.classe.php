<?php
//Module Recherche

// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_RECHERCHE", RACINE_SITE . "module.php?idModule=Recherche");

class ModuleRecherche extends Module
{
	// accès aux données (Base de donnée)
	private $baseDonnees = NULL;
	
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		$this->afficheFormulaire();

		
	}
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
		$this->ajouteLigne($ch);
		$ch.= "sfs";
		$this->ajouteLigne($ch);
		$this->creationSelect($langue,"lang[test]");
		$this->ajouteLigne($langue[0][0]);
		//$this->ajouteLigne(var_dump($this->maBase->rechercheParLangue()))
		$this->ajouteLigne("<input type='hidden' value='' name='lang[hidden]' >");
		$this->ajouteLigne("<input type='submit' value='kikoo' />");
		$this->fermeBloc("</form>");
	}
	
	/** Fonction qui crée des listes HTML <select>
	* @param tableau 2 colonnes, la première étant la value, deuxième le nom
	* @param nom du paramètre POST
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