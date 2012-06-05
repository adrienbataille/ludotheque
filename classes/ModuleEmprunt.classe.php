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
 * @author Ziyang KE, Rania DAOUDI
 * @version 0.1
 * @package module
 */


class ModuleEmprunt extends Module
{
	/**
	 * @var AccesAuxDonneesDoc Connexion BDD
	 */
	private $maBaseDoc = NULL;
	private $maBaseDev = NULL;

	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBaseDoc = AccesAuxDonnees::recupAccesDonnees();		
		$this->maBaseDev = AccesAuxDonneesDev::recupAccesDonneesDev();
		
		$this->afficheFormulaire();		
		$this->traitementFormulaire();

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
		$this->ajouteLigne("<label for=\"codeBarre\">" . $this->convertiTexte("Code barre") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"codeBarre\" name=\"codeBarre\" />");
		$this->fermeBloc("</li>");
		//$this-creationInputText();
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for=\"dateEmprunt\">" . $this->convertiTexte("Date d'emprunt") . "</label>");
		$this->ajouteLigne("<input type=\"text\" id=\"dateEmprunt\" value=\"".date('d-m-Y')."\" name=\"dateEmprunt\" />");		
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<ol>");

		$this->fermeBloc("</fieldset>");
		
		
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='validerEmprunt' value='true' />");
		$this->ajouteLigne("<button type='submit' name='ValiderEmprunt' value='true'>Valider l'emprunt</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
	}
	
	/**/
	private function traitementFormulaire(){		
		
		if($_POST[ValiderEmprunt]) {
			//Obtenir les données remplies par la méthode POST
			$idUtilisateur=$_POST['idUtilisateur'];
			$codeBarre=$_POST['codeBarre'];
			$dateEmprunt=$_POST['dateEmprunt'];	
			
			//print_r("code".$codeBarre."<br />");
			
			//La fonction testUtilisateur retourne 
			$peutEmprunter = $this->maBaseDoc->testUtilisateur($idUtilisateur);
			//print_r("peutEmprunter".$peutEmprunter."<br />");
			$aCotiser = $this->maBaseDoc->testDateCotisation($idUtilisateur,$dateEmprunt);
			//print_r("coti".$aCotiser."<br />");
			$codeBarreVerifie =$this->maBaseDev->testCodeBarre($codeBarre);
			//print_r("codeVer".$codeBarreVerifie."<br />");
			$empruntable=$this->maBaseDev->testEtatJeu($codeBarre);
			//var_dump($empruntable);
			//print_r("empruntable".$empruntable."<br />");
			if($empruntable && $peutEmprunter && $aCotiser && $codeBarreVerifie){
				$this->maBaseDev->insertionEmprunt($idUtilisateur,$codeBarre,$dateEmprunt);
				//print_r("OK!");
				header("Location: " . MODULE_EMPRUNTER);
				exit;
			}
			//if($empruntable)
			//MA NOUVELLE DATE = $this->dateAffichageToBase(MA VARIABLE DATE)
		}
	}
	
	/**
	* Fonction de conversion des dates
	* Converti les dates affichée en date stockable en base
	* jj/mm/aaaa -> AAAA-MM-JJ
	*/
	private function dateAffichageToBase($uneDate)
	{
		$jour = substr($uneDate,0,2);
		$mois = substr($uneDate,3,2);
		$annee = substr($uneDate,6,4);
		$date = $annee . "-" . $mois . "-" . $jour;
		
		if($uneDate == null)
			return "";
		else
			return $date;
	}
}

?>