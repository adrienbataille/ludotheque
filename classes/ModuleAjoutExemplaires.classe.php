<?php
/**
* Classe du module "AjoutExemplaires"
* Le module AjoutVersions permet la gestion des verions, c'est à dire :
*   - La création des occurences des Versions
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_EXEMPLAIRES", RACINE_SITE . "module.php?idModule=AjoutExemplaires");



/* REMARQUES :
Je pense que Date fin de vie n'esst pas un champs possible à l'insertion dès la premiere insertion, mais seulement à la modification
*/



class ModuleAjoutExemplaires extends Module
{

// Attributs

// On stocke les erreurs qui pourront arriver
	private $erreurPrixMdjt = false;
	private $erreurDateAchat = false;
    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct()
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();		
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
				
		// On traite le formulaire, le cas échéant
		$this->traiteFormulaire();
		
		// On affiche le contenu du module
		// On affiche le formulaire d'ajout des informations propres à un jeux
		$this->afficheFormulaire();	
	
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
	* Converti les dates stockée en date affichable
	* AAAA-MM-JJ -> jj/mm/aaaa
	*/
	private function dateBaseToAffichage($uneDate)
	{
		$annee = substr($uneDate,0,4);
		$mois = substr($uneDate,5,2);
		$jour = substr($uneDate,8,2);
		$date = $jour . "/" . $mois . "/" . $annee;
		return $date;
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
		return $date;
	}
	
	        /**
	* Fonction de vérification d'une date au format d'affichage
	*/
	private function verifDateAffichee($uneDate)
	{
            if (preg_match('#^([0-9]{2})([/-])([0-9]{2})\2([0-9]{4})$#', $uneDate))
            {
                return checkdate(substr($uneDate,3,2), substr($uneDate,0,2), substr($uneDate,6,4));
            }
            else
            {
                return false;
            }
	}
	
    public function afficheFormulaire()
    {	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_EXEMPLAIRES . "' id='formProfil'>");
        
        
        // Second fieldset : Informations sur l'exemplaire
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Informations sur l'exemplaire</legend>");
        $this->ouvreBloc("<ol>");
        
        // Description
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DESCRIPTION_EXEMPLAIRE . "'>" . $this->convertiTexte("Description") . "</label>");
        $this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_EXEMPLAIRE . "'name='" . DESCRIPTION_EXEMPLAIRE . "'>" . $this->descriptionExemplaire . "</textarea>");
        $this->fermeBloc("</li>");
		
				
		 // Prix mdjt
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . PRIX_MDJT . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
        $this->ajouteLigne("<input type='text' id='" . PRIX_MDJT ."' name='"  . PRIX_MDJT . "' value='" . $this->prixMDJT . "' required='required' />");
		if($this->erreurPrixMdjt)
			$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
        $this->fermeBloc("</li>");
        
        // Data achat
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DATE_ACHAT . "'>" . $this->convertiTexte("Date Achat") . "</label>");
        $this->ajouteLigne("<input type='text' id='" . DATE_ACHAT ."' maxlength='10' name='" . DATE_ACHAT . "' value='" . $this->dateBaseToAffichage($this->dateAchat) . "'  required='required' />");
		if($this->erreurDateAchat)
			$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
        $this->fermeBloc("</li>");
        
				
        // Data fin de vie
        /*$this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DATE_FIN_VIE . "'>" . $this->convertiTexte("Date fin de vie") . "</label>");
        $this->ajouteLigne("<input type='text' id='" . DATE_FIN_VIE . "' maxlength='10' name='" . DATE_FIN_VIE . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");*/
        		
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
		
		
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Ajouter'>Valider</button>");
		$this->fermeBloc("</fieldset>");
        
        $this->fermeBloc("</form>");
    }
	
	/*
	* Traitement formulaire
	*/
	
	private function traiteFormulaire()
	{
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["ajouter"])
		{
			// Traitement du formulaire
			$this->traitementFormulaire = true;		
			
			// Nettoyage des variables POST récupérée
			// Contre injection de code
			// mysql_real_escape_string(); Echappement des caractères spéciaux SQL
		
			
			// Nettoyage de la Description
			$this->descriptionExemplaire = $this->filtreChaine($_POST[DESCRIPTION_EXEMPLAIRE], TAILLE_CHAMPS_LONG);
			
			// Nettoyage du Prix MDJT
			$this->prixMDJT = $this->filtreChaine($_POST[PRIX_MDJT], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de Date achat
			//$this->dateAchat = $this->filtreChaine($_POST[DATE_ACHAT], TAILLE_CHAMPS_COURT);
			
			// Vérification de la date achat
			if ( $this->verifDateAffichee($_POST[DATE_ACHAT]) )			
			{
				$this->dateAchat = $this->dateAffichageToBase($_POST[DATE_ACHAT]);
			}
	
			
			// Nettoyage de date fin vie
			//$categorie = $this->filtreChaine($_POST[DATE_FIN_VIE], TAILLE_CHAMPS_COURT);
				
			$this->maBase->InsertionTableExemplaire($this->descriptionExemplaire,$this->prixMDJT,$this->dateAchat);
			
			if(strcmp($this->prixMDJT, "") == 0)
				$this->erreurPrixMdjt = true;
				
			if(strcmp($this->dateAchat, "") == 0)
				$this->erreurDateAchat = true;
			
				
				
			var_dump($this->descriptionExemplaire);
			var_dump($this->prixMDJT);
			var_dump($this->dateAchat);
			

		}
	}	
    
}

?>
