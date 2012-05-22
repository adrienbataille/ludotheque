<?php
/** 
 * Module Emprunt
 * @package composant
 */
// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_RETOUR", RACINE_SITE . "module.php?idModule=Retour");

/**
 * Module Emprunt
 * @author Romain Laï-King
 * @version 0.1
 * @package module
 */


class ModuleRetour extends Module
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
		//TODO  euh faudra changer la fonction de construction qui suit quand on merge!!
		$this->maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
		$this->afficheFormulaire();		

	}
	/**
	 * Affiche le formulaire de recherche
	 */
	private function afficheFormulaire()
	{
		$this->ouvreBloc("<form method='post' id='formProfil' action='".MODULE_RETOUR."'>");
		
		$this->ouvreBloc("<fieldset>");	
		$this->ouvreBloc("<ol>");
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"code_barre\">" . $this->convertiTexte("Code barre") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"code_barre\" name=\"code_barre\" />");
		$this->fermeBloc("</li>");
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"lieu_de_retour\">" . $this->convertiTexte("Lieu de retour") . "</label>");
		$lieu=$this->maBase->listeLieu();
		$this->creationSelect($lieu,"idLieu");		
		$this->fermeBloc("</li>");
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"date_de_retour\">" . $this->convertiTexte("Date de retour") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"code_barre\" value=\"".date('d-m-Y')."\" name=\"date_de_retour\" />");
		$this->fermeBloc("</li>");
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"etat\">" . $this->convertiTexte("Etat") . "</label>");
		$etat=$this->maBase->listeEtat();
		$this->creationSelect($etat,"idEtat");
		$this->fermeBloc("</li>");
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"commentaire\">" . $this->convertiTexte("Commentaire") . "</label>");
		$this->ajouteLigne("<textarea id=\"commentaire\" name=\"commentaire\"></textarea>");
		$this->fermeBloc("</li>");

		$this->fermeBloc("</ol>");
				$this->ajouteLigne("<button type='submit' name='valider' value='true'>" . $this->convertiTexte("Valider") . "</button>");

		$this->fermeBloc("</fieldset>");
		$this->fermeBloc("</form>");
	}
	
		private function creationSelect($array,$name){
		$post=$_POST[$name];
		$this->ouvreBloc("<select name=\"".$name."\">");
		$this->ajouteLigne("<option value=\"\">Indifférent</option>");
		foreach($array as $row){
			if($row[0]==$post){
				$this->ajouteLigne("<option selected=\"selected\" value=\"".$row[0]."\">". $row[1] ."</option>");
			}
			else{
				$this->ajouteLigne("<option value=\"".$row[0]."\">".$row[1]."</option>");
			}
		}
		$this->fermeBloc("</select>");
	}

	/**
	 *Fonction qui crée des input type text et le prérempli si le paramètre post existe
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 * @todo ajout d'attribut list avec comme valeur $name
	 */

	private function creationInputText($param,$name){
		$post=$_POST[$param];
		$value=$post[$name];
		if($post==NULL||$value==""){
			$this->ajouteLigne("<input type=\"text\" id=\"".$name."\" name=\"".$param ."[".$name."]\" />");
		}
		else {
			$this->ajouteLigne("<input type=\"text\" id=\"".$name."\" name=\"".$param ."[".$name."]\" value=\"". $value ."\" />");
		}
	}


}


?>