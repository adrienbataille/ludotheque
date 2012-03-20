<?php
/**
* Classe du module "AjoutJeux"
* Le module AjoutJeux permet la gestion des jeux, c'est à dire :
*   - La création des occurences des Jeux
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_JEUX", RACINE_SITE . "module.php?idModule=AjoutJeux");

//Constantes formulaire
define("VIDE", "");

class ModuleAjoutJeux extends Module
{

// Attributs

	// A-t-on fait un traitement sur le formulaire
	private $traitementFormulaire = false;
	// On stocke la base de données
	private $mabase = null;
    
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
	  *	Fonction d'affichage du formulaire
	  */
    public function afficheFormulaire()
    {	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_JEUX . "' id='formProfil'>");
        
        
		// Si on a déjà traité le formulaire
		if ($this->traitementFormulaire)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Formulaire modifié");
			$this->fermeBloc("</p>");
		}
        
			// First fieldset : Nom du jeu
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Nom du jeux</legend>");
			$this->ouvreBloc("<ol>");
			
			// Nom
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . NOM_JEU . "' value='" . VIDE . "' />");
			$this->fermeBloc("</li>");
			
			// Langue
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . NOM_LANGUE . "' value='" . VIDE . "' list=\"listeCategorie\" />");
			// Liste des langues pour l'auto-complete
			$listeCategorie = $this->maBase->recupLangue();
			$this->ouvreBloc("<datalist id=\"listeCategorie\">");
			foreach($listeCategorie as $categorie)
			{
				$this->ajouteLigne("<option id=\"" . $categorie['idLangue'] . "\" label=\"" . $categorie['nomLangue'] . "\" value=\"" . $categorie['nomLangue'] . "\">");
			}
			$this->fermeBloc("</datalist>");
			
			$this->fermeBloc("</li>");
			
			$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");
			
			// Second fieldset : Information sur le jeux
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Information sur le jeux</legend>");
			$this->ouvreBloc("<ol>");
			
			// Description
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DESCRIPTION_JEU . "'>" . $this->convertiTexte("Description") . "</label>");
			$this->ajouteLigne("<textarea rows='3' name='" . DESCRIPTION_JEU . "'>" . VIDE . "</textarea>");
			$this->fermeBloc("</li>");
			
			// Auteur
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . AUTEUR . "'>" . $this->convertiTexte("Auteur") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . AUTEUR . "' value='" . VIDE . "' />");
			$this->fermeBloc("</li>");
			
			// Pays
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_PAYS . "'>" . $this->convertiTexte("Pays d'origine") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . NOM_PAYS . "' value='" . VIDE . "' />");
			$this->fermeBloc("</li>");
			
			// Catégories
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_CATEGORIE . "'>" . $this->convertiTexte("Catégorie") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . NOM_CATEGORIE . "' value='" . VIDE . "' />");
			$this->fermeBloc("</li>");
			
			$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");
			
			// Bouton valider
			$this->ouvreBloc("<fieldset>");
			
			$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
			$this->ajouteLigne("<button type='submit' name='Ajouter'>Je valide et ajouter une versiongit</button>");
			$this->fermeBloc("</fieldset>");
			
			$this->fermeBloc("</form>");
		
    }
    
    
    
	
	/**
	*	Fonction de traitement du formulaire
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
			
			// Nettoyage du Nom
			$nom = $this->filtreChaine($_POST[NOM_JEU], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de la Langue
			$langue = $this->filtreChaine($_POST[NOM_LANGUE], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de la Description
			$description = $this->filtreChaine($_POST[DESCRIPTION_JEU], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de l'Auteur
			$auteur = $this->filtreChaine($_POST[AUTEUR], TAILLE_CHAMPS_COURT);
			
			// Nettoyage du Pays
			$pays = $this->filtreChaine($_POST[NOM_PAYS], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de la Catégorie
			$categorie = $this->filtreChaine($_POST[NOM_CATEGORIE], TAILLE_CHAMPS_COURT);
			
			var_dump($nom);
			var_dump($langue);
			var_dump($description);
			var_dump($auteur);
			var_dump($pays);
			var_dump($categorie);
			
			$listeCategorie = $this->maBase->recupLangue();
			foreach($listeCategorie as $categorie)
			{
				;
			}
			
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
