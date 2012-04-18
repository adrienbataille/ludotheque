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
	private $erreurLoadJeu = false;
	// Variables du formulaire
	private $nom;// = array(0 => "");
	private $langue;// = array(0 => "");
	private $description = "";
	private $auteur = "";
	private $idPays = 0;
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
			if($myGame[0] == null || !$myGame)
				$this->erreurLoadJeu = true;
			else
			{
				$this->idJeu = $myGame[0][ID_JEU];
				$this->description = $myGame[0][DESCRIPTION_JEU];
				$this->auteur = $myGame[0][AUTEUR];
				$this->idPays = $myGame[0][ID_PAYS];
				
				$myNames = $this->maBase->recupNomJeu($this->idJeu);
				
				$i = 0;
				$this->nom = array(0 => "");
				$this->langue = array(0 => "");
				foreach($myNames as $name)
				{
					$this->nom[$i] = $name[NOM_JEU];
					$this->langue[$i] = $name[ID_LANGUE];
					$i++;
				}
				
				$this->nbJeu = sizeof($this->nom);
				
				// CATÉGORIE
			}
		}

		// On traite le formulaire, le cas échéant
		$this->traiteFormulaire();
		
		// On affiche le contenu du module
		if($this->erreurLoadJeu)
    		$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_PIRATAGE) . "</p>");
		else
		{
			// On affiche le formulaire d'ajout des informations propres à un jeux
			$this->afficheFormulaire();
		}
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

		if($_POST[NOM_JEU] != null)
			foreach($_POST[NOM_JEU] as $nomJeu)
				// Nettoyage du Nom
				$this->nom[] = $this->filtreChaine($nomJeu, TAILLE_CHAMPS_COURT);

		if($_POST[NOM_LANGUE] != null)
			foreach($_POST[NOM_LANGUE] as $nomLangue)
				// Nettoyage de la Langue
				$this->langue[] = $this->filtreChaine($nomLangue, TAILLE_CHAMPS_COURT);

		// Nettoyage de la Description
		$this->description = $this->filtreChaine($_POST[DESCRIPTION_JEU], TAILLE_CHAMPS_LONG);

		// Nettoyage de l'Auteur
		$this->auteur = $this->filtreChaine($_POST[AUTEUR], TAILLE_CHAMPS_COURT);

		if($_POST[NOM_PAYS] != null)
			// Nettoyage du Pays
			$this->idPays = $this->filtreChaine($_POST[NOM_PAYS], TAILLE_CHAMPS_COURT);

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
		/*if ($this->traitementFormulaire && !$this->erreurPays && $this->erreurJeu && $this->erreurNom && $this->erreurLangue)
		{
			$this->ouvreBloc("<p>");
			$this->ajouteLigne("Formulaire modifié");
			$this->fermeBloc("</p>");
		}*/
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
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Nom du jeu") . "</legend>");
		$this->ouvreBloc("<ol>");
		
		// Nom
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom *") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_JEU . "' name='" . NOM_JEU . "[]' value='" . $this->nom[0] . "' required='required' />");
		if($this->erreurNom && !strcmp($this->nom[0], ""))
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_CHAMP_REQUIS) . "</p>");
		$this->fermeBloc("</li>");
		
		// Langue
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom *") . "</label>");
		$this->ouvreBloc("<select id='" . NOM_LANGUE . "' name='" . NOM_LANGUE . "[]' required='required'>");
		$this->ajouteLigne("<option value='null'></option>");
		$listeLangue = $this->maBase->recupLangue();
		foreach($listeLangue as $langue)
			if($langue[ID_LANGUE] == $this->langue[0])
				$this->ajouteLigne("<option value='" . $langue[ID_LANGUE] . "' selected='selected'>" . $this->convertiTexte($langue[NOM_LANGUE]) . "</option><");
			else
				$this->ajouteLigne("<option value='" . $langue[ID_LANGUE] . "'>" . $this->convertiTexte($langue[NOM_LANGUE]) . "</option>");
		$this->fermeBloc("</select>");
		if($this->erreurLangue && !strcmp($this->langue[0], "null"))
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_CHAMP_REQUIS) . "</p>");
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
			$this->ajouteLigne("<label for='" . NOM_JEU . "'>" . $this->convertiTexte("Nom *") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . NOM_JEU . "' name='" . NOM_JEU . "[]' value='" . $this->nom[$i] . "' required='required' />");
			if($this->erreurNom && !strcmp($this->nom[$i], ""))
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			$this->fermeBloc("</li>");
			
			// Langue
			//$listeLangue = $this->maBase->recupLangue();
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_LANGUE . "'>" . $this->convertiTexte("Langue du nom *") . "</label>");
			$this->ouvreBloc("<select id='" . NOM_LANGUE . "' name='" . NOM_LANGUE . "[]' required='required'>");
			$this->ajouteLigne("<option value='null'></option>");
			$listeLangue = $this->maBase->recupLangue();
			foreach($listeLangue as $langue)
				if($langue[ID_LANGUE] == $this->langue[$i])
					$this->ajouteLigne("<option value='" . $langue[ID_LANGUE] . "' selected='selected'>" . $this->convertiTexte($langue[NOM_LANGUE]) . "</option><");
				else
					$this->ajouteLigne("<option value='" . $langue[ID_LANGUE] . "'>" . $this->convertiTexte($langue[NOM_LANGUE]) . "</option>");
			$this->fermeBloc("</select>");
			if($this->erreurLangue && !strcmp($this->langue[$i], "null"))
				$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_CHAMP_REQUIS) . "</p>");
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
		$this->ouvreBloc("<li style='display:none;'>");
		$this->ajouteLigne("<input type='hidden' id='" . ID_JEU . "' name='" . ID_JEU . "' value='" . $this->idJeu . "' />");
		$this->fermeBloc("</li>");
		
		// Description
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DESCRIPTION_JEU . "'>" . $this->convertiTexte("Description") . "</label>");
		$this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_JEU . "' name='" . DESCRIPTION_JEU . "'>" . $this->convertiTexte($this->description) . "</textarea>");
		$this->fermeBloc("</li>");
		
		// Auteur
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . AUTEUR . "'>" . $this->convertiTexte("Auteur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . AUTEUR . "' name='" . AUTEUR . "' value='" . $this->convertiTexte($this->auteur) . "' autocomplete='on' />");
		$this->fermeBloc("</li>");
		
		// Pays
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_PAYS . "'>" . $this->convertiTexte("Pays d'origine") . "</label>");
		$this->ouvreBloc("<select id='" . NOM_PAYS . "' name='" . NOM_PAYS . "' required='required'>");
		$this->ajouteLigne("<option value='null'></option>");
		$listePays = $this->maBase->recupPays(null);//print_r($listePays);var_dump($this->idPays);
		foreach($listePays as $pays)
			if($pays[ID_PAYS] == $this->idPays)
				$this->ajouteLigne("<option value='" . $pays[ID_PAYS] . "' selected='selected'>" . $this->convertiTexte($pays[NOM_PAYS]) . "</option><");
			else
				$this->ajouteLigne("<option value='" . $pays[ID_PAYS] . "'>" . $this->convertiTexte($pays[NOM_PAYS]) . "</option>");
		$this->fermeBloc("</select>");
		$this->fermeBloc("</li>");
		
		// Catégories
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_CATEGORIE . "'>" . $this->convertiTexte("Catégorie") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_CATEGORIE . "' name='" . NOM_CATEGORIE . "' value='" . $this->convertiTexte($this->categorie) . "' />");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		// Bouton valider
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Ajouter' value='true'>Valider</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterJeu' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterJeu' value='true'>Valider et ajouter un autre jeu</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterVersion' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterVersion' value='true'>Valider et ajouter une version</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
    }
    
    
	
	/**
	*	Fonction de traitement du formulaire
	*/
	private function traiteFormulaire()
	{
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["Ajouter"] || $_POST["AjouterJeu"] || $_POST["AjouterVersion"])
		{
			// Traitement du formulaire
			$this->traitementFormulaire = true;
			
			$this->recuperationInformationsFormulaire();
			$this->nbJeu = sizeof($_POST[NOM_JEU]);
			
			if($this->langue != null && $this->nom != null)
			{
				if(!in_array("null", $this->langue) && !in_array("", $this->nom))
				{
					$this->pays = $unPays[ID_PAYS];
					
					$listeCateSelect = split(",", $this->categorie);
					$listeCateBase = $this->maBase->recupCategorie();
					$listeCateId;
					foreach($listeCateBase as $arrayCat => $uneCategorie)
					{
						//var_dump($uneCategorie);print "<br />";var_dump($arrayCat);print "@@@@<br/>";
						if(in_array($uneCategorie[NOM_CATEGORIE], $listeCateSelect))
						{
							$listeCateId[] = $uneCategorie[ID_CATEGORIE];
							unset($listeCateSelect[array_search($uneCategorie[NOM_CATEGORIE], $listeCateSelect)]);
						}
					}
					foreach($listeCateSelect as $categorie)
						$listeCateId[] = $this->maBase->InsertionTableCategorie($categorie);
					
					if($this->idJeu == 0)
						$this->idJeu = $this->maBase->InsertionTableJeu($this->description, $this->auteur, $this->idPays);
					else
					{
						if(!$this->maBase->UpdateTableJeu($this->idJeu, $this->description, $this->auteur, $this->idPays))
							$this->erreurUpdateJeu = true;
						else
							$this->maBase->DeleteTableNomJeu($this->idJeu);
					}
					$i = 0;
					for($i = 0; $i < sizeof($_POST[NOM_JEU]); $i++)
						$this->erreurLangue = $this->maBase->InsertionTableNomJeu($this->nom[$i], $this->langue[$i], $this->idJeu);
					//print "categorie choisie : " . $categorie . "<br />";
					$this->maBase->DeleteTableCategorieJeu($this->idJeu);
					$i = 0;
					for($i = 0; $i < sizeof($listeCateId); $i++)
						$this->maBase->InsertionTableCategorieJeu($listeCateId[$i], $this->idJeu);
				}
	
				if(in_array("null", $this->langue))
					$this->erreurLangue = true;
					
				if(in_array("", $this->nom))
					$this->erreurNom = true;
					
				if(!$this->erreurLangue && !$this->erreurNom && !$this->erreurPays && !$this->erreurJeu && !$this->erreurUpdateJeu)
				{
					if($_POST["Ajouter"]) {
						//header("Location: " . MODULE_GESTION_JEUX);
						//exit;
					} elseif ($_POST["AjouterJeu"]) {
						header("Location: " . MODULE_AJOUT_JEUX);
						exit;
					} elseif ($_POST["AjouterVersion"]) {
						header("Location: " . MODULE_AJOUT_VERSIONS . "&idJeu=" . $this->idJeu);
						exit;
					}
				}
			}			
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
