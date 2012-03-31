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
		$langue=$this->maBase->listeLangue();
		$etat=$this->maBase->listeEtat();
		$lieu=$this->maBase->listeLieu();
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Recherche de jeu</legend>");		
		// Nom du jeu
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nom\">" . $this->convertiTexte("Nom du jeu") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"nom\" name=\"nom\" />");
		$this->fermeBloc("</div>");
		//Categorie
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"categorie\">" . $this->convertiTexte("Catégorie") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"categorie\" name=\"categorie\" />");
		$this->fermeBloc("</div>");
		//Nombre de joueur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nombreDeJoueur\">" . $this->convertiTexte("Nombre de joueur") . "</label>");
		$this->ajouteLigne("<input type=\"checkbox\" name=\"2_4\" />");
		$this->ajouteLigne($this->convertiTexte("2-4"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"4_6\" />");
		$this->ajouteLigne($this->convertiTexte("4-6"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"6_8\" />");
		$this->ajouteLigne($this->convertiTexte("6-8"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"plus_8\" />");
		$this->ajouteLigne($this->convertiTexte("8+"));
		$this->fermeBloc("</div>");
		//Durée
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"dureeEnMinute\">" . $this->convertiTexte("Durée en minute") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"dureeEnMinute\" name=\"dureeEnMinute\" />");
		$this->fermeBloc("</div>");
		//Langue
		
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"langue\">" . $this->convertiTexte("Langue") . "</label>");
		$this->creationSelect($langue,"lang[test]");
		$this->fermeBloc("</div>");


		$this->ajouteLigne("<input type='submit' />");
		$this->fermeBloc("</fieldset>");
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