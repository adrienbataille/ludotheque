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
	private $erreurNom = false;
	private $erreurPays = false;
	private $erreurJeu = false;
	private $erreurUpdateJeu = false;
	// Variables du formulaire
	private $nom;// = array(0 => "");
	private $langue;// = array(0 => "");
	private $description = "";
	private $auteur = "";
	private $pays = "";
	private $categorie = "";
	// Id à converser
	private $idJeu = 0;
	// Nombre de nom de jeu
	private $nbJeu = 1;
    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($idDuJeu)
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		
		if($idDuJeu != null)
		{
			$myGame = $this->maBase->recupJeu($idDuJeu);
			$this->idJeu = $myGame[0][ID_JEU];
			$this->description = $myGame[0][DESCRIPTION_JEU];
			$this->auteur = $myGame[0][AUTEUR];
			$idDuPays = $myGame[0][ID_PAYS];
			
			$myCountry = $this->maBase->recupPays($idDuPays);
			$this->pays = $myCountry[0][NOM_PAYS];
			
			$myNames = $this->maBase->recupNameJeu($this->idJeu);
			
			$i = 0;
			$this->nom = array(0 => "");
			$this->langue = array(0 => "");
			foreach($myNames as $name)
			{
				//if(!in_array($name[NOM_JEU], $this->nom) && !in_array($name[NOM_LANGUE], $this->langue))
				//{
					$this->nom[$i] = $name[NOM_JEU];
					$this->langue[$i] = $name[NOM_LANGUE];
				//}
				$i++;
			}
			
			$this->nbJeu = sizeof($this->nom);
			
			// CATÉGORIE
		}

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
	 * Fonction récupérant les informations des jeux dans la requête POST
	 */
	private function recuperationInformationsFormulaire()
	{
		// Nettoyage des variables POST récupérée
		
		$this->idJeu = $this->filtreChaine($_POST[ID_JEU], TAILLE_CHAMPS_COURT);

		foreach($_POST[NOM_JEU] as $nomJeu)
			// Nettoyage du Nom
			$this->nom[] = $this->filtreChaine($nomJeu, TAILLE_CHAMPS_COURT);
		
		foreach($_POST[NOM_LANGUE] as $nomLangue)
			// Nettoyage de la Langue
			$this->langue[] = $this->filtreChaine($nomLangue, TAILLE_CHAMPS_COURT);
		
		// Nettoyage de la Description
		$this->description = $this->filtreChaine($_POST[DESCRIPTION_JEU], TAILLE_CHAMPS_LONG);
		
		// Nettoyage de l'Auteur
		$this->auteur = $this->filtreChaine($_POST[AUTEUR], TAILLE_CHAMPS_COURT);
		
		// Nettoyage du Pays
		$this->pays = $this->filtreChaine($_POST[NOM_PAYS], TAILLE_CHAMPS_COURT);
		
		// Nettoyage de la Catégorie
		$this->categorie = $this->filtreChaine($_POST[NOM_CATEGORIE], TAILLE_CHAMPS_COURT);
	}
    
	/**
	  *	Fonction d'affichage du formulaire
	  */
    public function afficheFormulaire()
    {
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_JEUX . "' id='formProfil' autocomplete='off'>");
        
		// Si on a déjà traité le formulaire
		if ($this->traitementFormulaire && !$this->erreurPays && $this->erreurJeu && $this->erreurNom && $this->erreurLangue)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Formulaire modifié");
			$this->fermeBloc("</p>");
		}
		if ($this->erreurPays)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Erreur ajout Pays");
			$this->fermeBloc("</p>");
		}
		if ($this->erreurJeu)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Erreur ajout Jeu");
			$this->fermeBloc("</p>");
		}
        
		// First fieldset : Nom du jeu
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Nom du jeu</legend>");
		$this->ouvreBloc("<ol>");
		
		// Nom
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_JEU . "' name='" . NOM_JEU . "[]' value='" . $this->nom[0] . "' required='required' />");
		if($this->erreurNom && !strcmp($this->nom[0], ""))
			$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
		$this->fermeBloc("</li>");
		
		// Langue
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_LANGUE . "' name='" . NOM_LANGUE . "[]' value='" . $this->langue[0] . "' list='listeLangue' required='required' />");
		if($this->erreurLangue && !strcmp($this->langue[0], ""))
			$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
		// Liste des langues pour l'auto-complete
		$listeLangue = $this->maBase->recupLangue();
		$this->ouvreBloc("<datalist id='listeLangue'>");
		foreach($listeLangue as $langue)
			$this->ajouteLigne("<option id='langue_" . $langue[ID_LANGUE] . "' label='" . $langue[NOM_LANGUE] . "' value=\"" . $langue[NOM_LANGUE] . "\">");
		$this->fermeBloc("</datalist>");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		
		if($this->nbJeu > 1)
		{
			
			// Bouton Supprimer Nom du Jeu
			$this->ajouteLigne("<input type='hidden' name='supprimerNomJeu' value='0' />");
			$this->ajouteLigne("<button type='submit' name='SupprimerNomJeu' value='0'>Supprimer ce nom de jeu</button>");
		}
		
		$this->fermeBloc("</fieldset>");
		
		for($i = 1; $i < $this->nbJeu; $i++)
		{
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Ajouter une autre langue</legend>");
			$this->ouvreBloc("<ol>");
			
			// Nom
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . NOM_JEU . "' name='" . NOM_JEU . "[]' value='" . $this->nom[$i] . "' required='required' />");
			if($this->erreurNom && !strcmp($this->nom[$i], ""))
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			$this->fermeBloc("</li>");
			
			// Langue
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . NOM_LANGUE . "' name='" . NOM_LANGUE . "[]' value='" . $this->langue[$i] . "' list='listeLangue' required='required' />");
			if($this->erreurLangue && !strcmp($this->langue[$i], ""))
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			// Liste des langues pour l'auto-complete
			$listeLangue = $this->maBase->recupLangue();
			$this->ouvreBloc("<datalist id='listeLangue'>");
			foreach($listeLangue as $langue)
				$this->ajouteLigne("<option id='langue_" . $langue[ID_LANGUE] . "' label='" . $langue[NOM_LANGUE] . "' value=\"" . $langue[NOM_LANGUE] . "\">");
			$this->fermeBloc("</datalist>");
			$this->fermeBloc("</li>");
			
			$this->fermeBloc("</ol>");
			
			// Bouton Supprimer Nom du Jeu
			$this->ajouteLigne("<input type='hidden' name='supprimerNomJeu' value='" . $i . "' />");
			$this->ajouteLigne("<button type='submit' name='SupprimerNomJeu' value='" . $i . "'>Supprimer ce nom de jeu</button>");
			
			$this->fermeBloc("</fieldset>");
		}
		
		// Bouton valider
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterNom' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterNom' value='true'>Ajouter un autre nom à ce jeu</button>");
		$this->fermeBloc("</fieldset>");
		
		// Second fieldset : Information sur le jeux
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Information sur le jeux</legend>");
		$this->ouvreBloc("<ol>");
		
		// Identifiant du jeu
		$this->ajouteLigne("<input type='hidden' id='" . ID_JEU . "' name='" . ID_JEU . "' value='" . $this->idJeu . "' />");
		
		// Description
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DESCRIPTION_JEU . "'>" . $this->convertiTexte("Description") . "</label>");
		$this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_JEU . "' name='" . DESCRIPTION_JEU . "'>" . $this->description . "</textarea>");
		$this->fermeBloc("</li>");
		
		// Auteur
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . AUTEUR . "'>" . $this->convertiTexte("Auteur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . AUTEUR . "' name='" . AUTEUR . "' value='" . $this->auteur . "' autocomplete='on' />");
		$this->fermeBloc("</li>");
		
		// Pays
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_PAYS . "'>" . $this->convertiTexte("Pays d'origine") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_PAYS . "' name='" . NOM_PAYS . "' value='" . $this->pays . "' list='listePays' />");
		// Liste des langues pour l'auto-complete
		$listePays = $this->maBase->recupPays(null);
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
		$this->ajouteLigne("<input type='text' id='" . NOM_CATEGORIE . "' name='" . NOM_CATEGORIE . "' value='" . $this->categorie . "' />");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		// Bouton valider
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterJeu' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterJeu' value='true'>Je valide et ajouter une version</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
    }
    
    
	
	/**
	*	Fonction de traitement du formulaire
	*/
	private function traiteFormulaire()
	{		
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["AjouterJeu"])
		{
			// Traitement du formulaire
			$this->traitementFormulaire = true;
			
			$this->recuperationInformationsFormulaire();
			$this->nbJeu = sizeof($_POST[NOM_JEU]);
			
			
			if(!in_array("", $this->langue) && !in_array("", $this->nom))
			{					
				// Si le champ Pays n'a pas été laissé vide, on récupére l'id du Pays sélectionné,
				// et s'il s'agit d'un nouveau Pays, on l'insère dans la base de données et on récupére son id
				$idPays = 0;
				
				$listePays = $this->maBase->recupPays(null);
				foreach($listePays as $unPays)
				{
					if(strcasecmp($this->pays, $unPays[NOM_PAYS]) == 0)
						$idPays = $unPays[ID_PAYS];
				}
				
				if($idPays == 0)
					$idPays = $this->maBase->InsertionTablePays($this->pays);
				
				if(!intval($idPays))
					$this->erreurPays = true;
				
				if($this->idJeu == 0)
					$this->idJeu = $this->maBase->InsertionTableJeu($this->description, $this->auteur, $idPays);
				else
					if(!$this->maBase->UpdateTableJeu($this->idJeu, $this->description, $this->auteur, $idPays))
						$this->erreurUpdateJeu = true;

				$this->maBase->DeleteTableNomJeu($this->idJeu);
				
				$i = 0;
				for($i = 0; $i < sizeof($_POST[NOM_JEU]); $i++)
				{
					// Si le champ Langue n'a pas été laissé vide, on récupére l'id de la Langue sélectionnée,
					// et s'il s'agit d'une nouvelle Langue, on l'insère dans la base de données et on récupére son id
					$idLangue = 0;
	
					$listeLangue = $this->maBase->recupLangue();
					foreach($listeLangue as $uneLangue)
					{
						if(strcasecmp($this->langue[$i], $uneLangue[NOM_LANGUE]) == 0)
							$idLangue = $uneLangue[ID_LANGUE];
					}
					if($idLangue == 0)
						$idLangue = $this->maBase->InsertionTableLangue($this->langue[$i]);
	
					if(!intval($idLangue))
						$this->erreurLangue = true;
					
					$this->erreurLangue = $this->maBase->InsertionTableNomJeu($this->nom[$i], $idLangue, $this->idJeu);
				}				
				print "categorie choisie : " . $categorie . "<br />";
			}

			if(in_array("", $this->langue))
				$this->erreurLangue = true;
				
			if(in_array("", $this->nom))
				$this->erreurNom = true;
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
		} elseif($_POST["AjouterNom"])
		{
			$this->recuperationInformationsFormulaire();

			$this->nbJeu += sizeof($_POST[NOM_JEU]);
		} elseif($_POST["SupprimerNomJeu"] != null)
		{
			$this->recuperationInformationsFormulaire();
			
			$this->nbJeu = sizeof($_POST[NOM_JEU]) - 1;
			
			for($i = $_POST["SupprimerNomJeu"]; $i < $this->nbJeu; $i++)
			{
				$this->nom[$i] = $this->nom[$i + 1];
				$this->langue[$i] = $this->langue[$i + 1];
			}
			
			unset($this->nom[$this->nbJeu]);
			unset($this->langue[$this->nbJeu]);
		}
	}	
}

?>
