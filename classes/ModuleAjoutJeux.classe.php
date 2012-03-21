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
	// On stocke les erreurs qui pourront arriver
	private $erreurLangue = false;
	private $erreurPays = false;
	private $erreurJeu = false;
    
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
    
	/**
	  *	Fonction d'affichage du formulaire
	  */
    public function afficheFormulaire()
    {	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_JEUX . "' id='formProfil' autocomplete='off'>");
        
		// Si on a déjà traité le formulaire
		if ($this->traitementFormulaire)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Formulaire modifié");
			$this->fermeBloc("</p>");
		}
		if ($erreurLangue)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Erreur ajout Langue");
			$this->fermeBloc("</p>");
		}
		if ($erreurPays)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Erreur ajout Pays");
			$this->fermeBloc("</p>");
		}
		if ($erreurJeu)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Erreur ajout Jeu");
			$this->fermeBloc("</p>");
		}
        
		// First fieldset : Nom du jeu
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Nom du jeux</legend>");
		$this->ouvreBloc("<ol>");
		
		// Nom
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_JEU . "' name='" . NOM_JEU . "' value='" . VIDE . "' required='required' />");
		$this->fermeBloc("</li>");
		
		// Langue
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_LANGUE . "' name='" . NOM_LANGUE . "' value='" . VIDE . "' list='listeCategorie' required='required' />");
		// Liste des langues pour l'auto-complete
		$listeLangue = $this->maBase->recupLangue();
		$this->ouvreBloc("<datalist id='listeLangue'>");
		foreach($listeLangue as $langue)
			$this->ajouteLigne("<option id='langue_" . $langue[ID_LANGUE] . "' label='" . $langue[NOM_LANGUE] . "' value=\"" . $langue[NOM_LANGUE] . "\">");
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
		$this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_JEU . "' name='" . DESCRIPTION_JEU . "'>" . VIDE . "</textarea>");
		$this->fermeBloc("</li>");
		
		// Auteur
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . AUTEUR . "'>" . $this->convertiTexte("Auteur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . AUTEUR . "' name='" . AUTEUR . "' value='" . VIDE . "' autocomplete='on' />");
		$this->fermeBloc("</li>");
		
		// Pays
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_PAYS . "'>" . $this->convertiTexte("Pays d'origine") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_PAYS . "' name='" . NOM_PAYS . "' value='" . VIDE . "' list='listePays' />");
		// Liste des langues pour l'auto-complete
		$listePays = $this->maBase->recupPays();
		$this->ouvreBloc("<datalist id='listePays'>");
		foreach($listePays as $pays)
		{
			$this->ajouteLigne("<option id='pays_" . $pays[ID_PAYS] . "' label='" . $pays[NOM_PAYS] . "' value='" . $pays[NOM_PAYS] . "'>");
		}
		$this->fermeBloc("</datalist>");
		$this->fermeBloc("</li>");
		
		// Catégories
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_CATEGORIE . "'>" . $this->convertiTexte("Catégorie") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_CATEGORIE . "' name='" . NOM_CATEGORIE . "' value='" . VIDE . "' />");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		// Bouton valider
		$this->ouvreBloc("<fieldset>");
		
		$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Ajouter'>Je valide et ajouter une version</button>");
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
			
			
			// Si le champ Langue n'a pas été laissé vide, on récupére l'id de la Langue sélectionnée,
			// et s'il s'agit d'une nouvelle Langue, on l'insère dans la base de données et on récupére son id
			$idLangue = 0;
			if(strcmp($langue, "") != 0)
			{
				$listeLangue = $this->maBase->recupLangue();
				foreach($listeLangue as $uneLangue)
				{
					if(strcasecmp($langue, $uneLangue[NOM_LANGUE]) == 0)
						$idLangue = $uneLangue[ID_LANGUE];
				}
				if($idLangue == 0)
					$idLangue = $this->maBase->InsertionTableLangue($langue);
			}
			if(!intval($idLangue))
				$erreurLangue = true;
			
			// Si le champ Pays n'a pas été laissé vide, on récupére l'id du Pays sélectionné,
			// et s'il s'agit d'un nouveau Pays, on l'insère dans la base de données et on récupére son id
			$idPays = 0;
			if(strcmp($pays, "") != 0)
			{
				$listePays = $this->maBase->recupPays();
				foreach($listePays as $unPays)
				{
					if(strcasecmp($pays, $unPays[NOM_PAYS]) == 0)
						$idPays = $unPays[ID_PAYS];
				}
				if($idPays == 0)
					$idPays = $this->maBase->InsertionTablePays($pays);
			}
			if(!intval($idPays))
				$erreurPays = true;
			
			$erreurJeu = $this->maBase->InsertionTableJeu($description, $auteur, $idPays);
			
			print "categorie choisie : " . $categorie . "<br />";
			
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
