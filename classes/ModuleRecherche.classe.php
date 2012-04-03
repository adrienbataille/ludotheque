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
	private $maBase = NULL;
	
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
		$this->traitementFormulaire();

		
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
		$this->ajouteLigne("<input type=\"text\" id=\"nom\" name=\"recherche[nom]\" />");
		$this->fermeBloc("</div>");
		//Categorie
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"categorie\">" . $this->convertiTexte("Catégorie") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"categorie\" name=\"recherche[categorie]\" />");
		$this->fermeBloc("</div>");
		//Nombre de joueur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nombreDeJoueur\">" . $this->convertiTexte("Nombre de joueur") . "</label>");
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j1]\" />");
		$this->ajouteLigne($this->convertiTexte("1"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j2]\" />");
		$this->ajouteLigne($this->convertiTexte("2"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j3]\" />");
		$this->ajouteLigne($this->convertiTexte("3"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j4]\" />");
		$this->ajouteLigne($this->convertiTexte("4"));
		$this->ajouteLigne("<br/><input type=\"checkbox\" name=\"recherche[j5]\" />");
		$this->ajouteLigne($this->convertiTexte("5"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j6]\" />");
		$this->ajouteLigne($this->convertiTexte("6"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j7]\" />");
		$this->ajouteLigne($this->convertiTexte("7"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j8]\" />");
		$this->ajouteLigne($this->convertiTexte("8"));
		$this->ajouteLigne("<input type=\"checkbox\" name=\"recherche[j9]\" />");
		$this->ajouteLigne($this->convertiTexte("8+"));
		$this->fermeBloc("</div>");
		//Durée
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"dureeEnMinute\">" . $this->convertiTexte("Durée en minute") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"dureeEnMinute\" name=\"recherche[DureeJeu]\" />");
		$this->fermeBloc("</div>");
		//Langue
		
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"langue\">" . $this->convertiTexte("Langue") . "</label>");
		$this->creationSelect($langue,"recherche[idLangue]");
		$this->fermeBloc("</div>");
		
		//Etat
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"etat\">" . $this->convertiTexte("Etat") . "</label>");
		$this->creationSelect($etat,"recherche[idEtatExemplaire]");
		$this->fermeBloc("</div>");
		
		//Lieu
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"lieu\">" . $this->convertiTexte("Lieu") . "</label>");
		$this->creationSelect($etat,"recherche[idLieu]");
		$this->fermeBloc("</div>");
		
		
		//Prix
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"prix\">" . $this->convertiTexte("Prix:") . "</label>");
		//$this->ajouteLigne("<input type=\"text\" id=\"prix\" name=\"recherche[prix]\" />");
		$this->ajouteLigne("<label for=\"prixMin\">" . $this->convertiTexte("Min") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"prixMin\" name=\"recherche[prixMin]\" />");
		$this->ajouteLigne("<label for=\"prixMax\">" . $this->convertiTexte("Max") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"prixMax\" name=\"recherche[prixMax]\" />");
		$this->fermeBloc("</div>");
		$this->fermeBloc("</fieldset>");
		
		//Recherche avancée
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Recherche avancée</legend>");
		
		//Auteur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"auteur\">" . $this->convertiTexte("Auteur") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"auteur\" name=\"recherche[auteur]\" />");
		$this->fermeBloc("</div>");
		
		//Illustrateur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"illustrateur\">" . $this->convertiTexte("Illustrateur") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"illustrateur\" name=\"recherche[illustrateur]\" />");
		$this->fermeBloc("</div>");
		
		//Année
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"annee\">" . $this->convertiTexte("Année") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"annee\" name=\"recherche[annee]\" />");
		$this->fermeBloc("</div>");
		
		//Distributeur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"distributeur\">" . $this->convertiTexte("Distributeur") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"distributeur\" name=\"recherche[distributeur]\" />");
		$this->fermeBloc("</div>");
		

		$this->ajouteLigne("<input type='submit' />");
		var_dump($_POST['recherche']);
		$this->fermeBloc("</fieldset>");
		$this->fermeBloc("</form>");
	}
	
	/**
	 * Traitement du formulaire pour la recherche. Cette fonction s'occupe d'afficher les résultats de la recherche
	 */
	
	private function traitementFormulaire(){
		$param=false;
		$recherche=$_POST["recherche"];
		if ($recherche!=NULL){
			var_dump($recherche);
			foreach($recherche as $row){
				if ($row!=""){
					$param=true;
				}
			}
		}
		if($param){
			
			$resultat=$this->maBase->rechercheVersion($recherche);
		}
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