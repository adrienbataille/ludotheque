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
    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct()
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->baseDonnees = AccesAuxDonneesDev::recupAccesDonnees();
		
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
        $this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_EXEMPLAIRE . "'name='" . DESCRIPTION_EXEMPLAIRE . "'>" . VIDE . "</textarea>");
        $this->fermeBloc("</li>");
		
				
		 // Prix mdjt
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . PRIX_MDJT . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
        $this->ajouteLigne("<input type='text' id='" . PRIX_MDJT ."' name='"  . PRIX_MDJT . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Data achat
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DATE_ACHAT . "'>" . $this->convertiTexte("Date Achat") . "</label>");
        $this->ajouteLigne("<input type='text' id='" . DATE_ACHAT ."' maxlength='10' name='" . DATE_ACHAT . "' value='" . VIDE . "' />");
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
			$description = $this->filtreChaine($_POST[DESCRIPTION_EXEMPLAIRE], TAILLE_CHAMPS_COURT);
			
			// Nettoyage du Prix MDJT
			$prix_mdjt = $this->filtreChaine($_POST[PRIX_MDJT], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de Date achat
			$date_achat = $this->filtreChaine($_POST[DATE_ACHAT], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de date fin vie
			//$categorie = $this->filtreChaine($_POST[DATE_FIN_VIE], TAILLE_CHAMPS_COURT);
			
		
			var_dump($description);
			var_dump($prix_mdjt);
			var_dump($date_achat);
			
			/*
			// Vérification de la présence de modifications
			// Changement de titre ?
			if (strcmp($titre,$this->monUtilisateur->recupTitre() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeTitre($titre);
			}
			... au niveau des champs

			// Si il y a au moins une modification
				// On demande la mise à jour des informations dans la base
			if ($this->estModifie)
			{
				$this->modificationOK = $this->monUtilisateur->mettreAJour();
			} 
			*/
		}
	}	
    
}

?>
