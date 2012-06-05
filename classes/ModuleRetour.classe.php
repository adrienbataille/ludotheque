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
 * Module Retour
 * @author Adrien Bataille
 * @version 0.1
 * @package module
 */


class ModuleRetour extends Module
{
	/**
	 * @var AccesAuxDonneesDev Connexion BDD
	 */
	private $maBase = NULL;
	
	private $idExemplaire = 0;
	private $codeBarre = "";
	private $idLieuRetour;
	private $commentaire = "";
	private $dateRetour;
	private $etat;
	private $erreurCodeBarre = false;
	private $erreurEmprunt = false;
	private $monUtilisateur = null;

	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct($user)
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		
		$this->monUtilisateur = $user;
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		//TODO  euh faudra changer la fonction de construction qui suit quand on merge!!
		$this->maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
		// On traite le formulaire, le cas échéant
		$this->traiteFormulaire();
		$this->afficheFormulaire();		

	}
	
	
	/**
	 * Fonction récupérant les informations des jeux dans la requête POST
	 */
	private function recuperationInformationsFormulaire()
	{
		/*
		// Nettoyage du nom du jeu
		$this->nomJeu = $this->filtreChaine($_POST[NOM_JEU], TAILLE_CHAMPS_COURT);
		// Nettoyage du l'id du jeu
		$this->idJeu = $this->filtreChaine($_POST[ID_JEU], TAILLE_CHAMPS_COURT);
		
		// Nettoyage du nom de la version du jeu
		$this->nomVersion = $this->filtreChaine($_POST[NOM_VERSION], TAILLE_CHAMPS_COURT);
		// Nettoyage de l'id de la version du jeu
		$this->idVersion = $this->filtreChaine($_POST[ID_VERSION], TAILLE_CHAMPS_COURT);
		*/
	}
	
	/**
	 * Affiche le formulaire de recherche
	 */
	private function afficheFormulaire()
	{
		$this->ouvreBloc("<form method='post' id='formProfil' action='".MODULE_RETOUR."'>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Retour") . "</legend>");
		$this->ouvreBloc("<fieldset>");	
		$this->ouvreBloc("<ol>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . CODE_BARRE . "'>" . $this->convertiTexte("Code barre") . "</label>");
		if(strcmp($this->codeBarre, "") != 0) {
			$this->ajouteLigne("<input type='text' id='" . CODE_BARRE . "' name='" . CODE_BARRE . "' value='" . $this->codeBarre . "' disabled='disabled' />");
			$this->ajouteLigne("<input type='hidden' id='" . CODE_BARRE . "' name='" . CODE_BARRE . "' value='" . $this->codeBarre . "' />");
			$this->ajouteLigne("<input type='hidden' id='" . ID_EXEMPLAIRE . "' name='" . ID_EXEMPLAIRE . "' value='" . $this->idExemplaire . "' />");
		} else
			$this->ajouteLigne("<input type='text' id='" . CODE_BARRE . "' name='" . CODE_BARRE . "' value='" . $this->codeBarre . "' />");
		if($this->erreurCodeBarre)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_INFO_INCORRECT) . "</p>");
		if($this->erreurEmprunt)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_RETOUR_EMPRUNT) . "</p>");
		$this->fermeBloc("</li>");
		
		if(strcmp($this->codeBarre, "") != 0) {
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='lieu_de_retour'>" . $this->convertiTexte("Lieu de retour") . "</label>");
			$lieu = $this->maBase->listeLieu();
			$this->creationSelect($lieu, "idLieu", $this->idLieuRetour, false);		
			$this->fermeBloc("</li>");
			
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DATE_RETOUR_REEL . "'>" . $this->convertiTexte("Date de retour") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . DATE_RETOUR_REEL . "' value='".date('d-m-Y')."' name='" . DATE_RETOUR_REEL . "' />");
			$this->fermeBloc("</li>");
			
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='etat'>" . $this->convertiTexte("Etat") . "</label>");
			$etat = $this->maBase->listeEtat();
			$this->creationSelect($etat, ID_ETAT_EXEMPLAIRE, $this->etat, true);
			$this->fermeBloc("</li>");
			
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DESCRIPTION_EXEMPLAIRE . "'>" . $this->convertiTexte("Commentaire") . "</label>");
			$this->ajouteLigne("<textarea id='" . DESCRIPTION_EXEMPLAIRE . "' name='" . DESCRIPTION_EXEMPLAIRE . "' disabled='disabled'>" . $this->commentaire . "</textarea>");
			$this->fermeBloc("</li>");
			
			$this->ouvreBloc("<li style='display: none;'>");
			$this->ajouteLigne("<label for='" . ID_UTILISATEUR . "'>" . $this->convertiTexte("Id Utilisateur") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . ID_UTILISATEUR . "' name='" . ID_UTILISATEUR . "' value='" . $this->monUtilisateur->RecupId() . "' />");
			$this->fermeBloc("</li>");
		}
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		if(strcmp($this->codeBarre, "") == 0) {
			$this->ouvreBloc("<fieldset>");	
			$this->ajouteLigne("<input type='hidden' name='validerCodeBarre' value='true' />");
			$this->ajouteLigne("<button type='submit' name='ValiderCodeBarre' value='true'>" . $this->convertiTexte("Valider code barre") . "</button>");	
			$this->fermeBloc("</fieldset>");
		} else {
			$this->ouvreBloc("<fieldset>");	
			$this->ajouteLigne("<input type='hidden' name='validerRetour' value='true' />");
			$this->ajouteLigne("<button type='submit' name='ValiderRetour' value='true'>" . $this->convertiTexte("État correct") . "</button>");	
			$this->fermeBloc("</fieldset>");
			
			$this->ouvreBloc("<fieldset>");	
			$this->ajouteLigne("<input type='hidden' name='validerPbRetour' value='true' />");
			$this->ajouteLigne("<button type='submit' name='ValiderPbRetour' value='true'>" . $this->convertiTexte("Problème état") . "</button>");	
			$this->fermeBloc("</fieldset>");
		}
		
		$this->fermeBloc("</form>");
	}
	
	/*
	* Traitement formulaire
	*/
	
	private function traiteFormulaire()
	{
		$this->codeBarre = $this->filtreChaine($_POST[CODE_BARRE], TAILLE_CHAMPS_COURT);
		
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["ValiderCodeBarre"])
		{
			$myEx = $this->maBase->recupExemplaireCB($this->codeBarre);
			$this->idExemplaire = $myEx[0][ID_EXEMPLAIRE];
			if(!empty($myEx)) {
				$myEmprunt = $this->maBase->verifTableEmprunt($this->idExemplaire);
				if(!empty($myEmprunt)) {
					$this->commentaire = $myEx[0][DESCRIPTION_EXEMPLAIRE];
					$this->etat = $myEx[0][ID_ETAT_EXEMPLAIRE];
					if($myEx[0][ID_LIEU_TEMPO] != null && $myEx[0][ID_LIEU_TEMPO] != 0 )
						$this->idLieuRetour = $myEx[0][ID_LIEU_TEMPO];
					else
						$this->idLieuRetour = $myEx[0][ID_LIEU_REEL];
				} else {
					$this->codeBarre = "";
					$this->erreurEmprunt = true;
				}
			} else {
				$this->codeBarre = "";
				$this->erreurCodeBarre = true;
			}
		} else {
			$this->idExemplaire = intval($this->filtreChaine($_POST[ID_EXEMPLAIRE], TAILLE_CHAMPS_COURT));
			$this->idLieuRetour = $this->filtreChaine("idLieu", TAILLE_CHAMPS_COURT);
			$this->dateRetour = $this->dateAffichageToBase($_POST[DATE_RETOUR_REEL]);
			$user = intval($this->filtreChaine($_POST[ID_UTILISATEUR], TAILLE_CHAMPS_COURT));
			
			$this->maBase->updateDateRetourReelEmprunt($this->idExemplaire, $this->dateRetour);
		
			if ($_POST["ValiderRetour"]) {
				$this->maBase->InsertionTableInventaire($this->dateRetour, $this->commantaire, $user, $this->idExemplaire);
				header("Location: " . MODULE_EMPRUNTER . "&rendu=true&idExemplaire=".$this->idExemplaire);
				exit;
			} elseif ($_POST["ValiderPbRetour"]) {
				header("Location: " . MODULE_INVENTAIRE . "&idExemplaire=".$this->idExemplaire);
				exit;
			}
		}
	}
	
		private function creationSelect($array, $name, $selected, $disabled){
		if($disabled)
			$this->ouvreBloc("<select id='" . $name . "' name='" . $name . "' disabled='disabled'>");
		else
			$this->ouvreBloc("<select id='" . $name . "' name='" . $name . "'>");
		$this->ajouteLigne("<option value='NULL'></option>");
		foreach($array as $row){
			if($row[0]==$selected){
				$this->ajouteLigne("<option selected='selected' value='".$row[0]."'>". $row[1] ."</option>");
			}
			else{
				$this->ajouteLigne("<option value='".$row[0]."'>".$row[1]."</option>");
			}
		}
		$this->fermeBloc("</select>");
	}
	
	 /**
	 * Fonction de nettoyage des chaine de caractères
     * Prends en paramètre la chaine à filtrer, et la taille max de cette chaine
	 */
	private function filtreChaine($uneChaine,$uneTaille)
	{
		// On supprime les \ rajouté par les Magic Quotes. Si il y a lieu
		if (get_magic_quotes_gpc() == 1)
		{
			$uneChaine = stripslashes($uneChaine);
		}
		// On supprime les balises HTML s'il y en avait
		$resultat = strip_tags($uneChaine);
		// On vérifie sa taille
		$resultat = substr($resultat,0,$uneTaille);
		return $resultat;
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
			$this->ajouteLigne("<input type='text' id='".$name."' name='".$param ."[".$name."]' />");
		}
		else {
			$this->ajouteLigne("<input type='text' id='".$name."' name='".$param ."[".$name."]' value='". $value ."' />");
		}
	}


}


?>