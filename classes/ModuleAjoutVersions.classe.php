<?php
/**
* Classe du module "AjoutVersions"
* Le module AjoutVersions permet la gestion des verions, c'est à dire :
*   - La création des occurences des Versions
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_VERSIONS", RACINE_SITE . "module.php?idModule=AjoutVersions");

//Constantes formulaire
define("NB_JOUEUR_V", "nb_joueur_min");

// Variables du formulaire
										



class ModuleAjoutVersions extends Module
{

// Attributs

	// A-t-on fait un traitement sur le formulaire
	private $traitementFormulaire = false;
	// On stocke la base de données
	private $mabase = null;
	// On stocke les erreurs qui pourront arriver
	private $erreurNom = false;
	private $erreurPrixAchat = false;
	private $erreurEditeur = false;

	
// Methodes
	
	//private $idVersion = "";
	private $nomVersion = "";
	private $description = "";
	private $ageMinimum = "";
	private $nb_joueur = "";
	private $nb_joueur_reco = "";
	private $prix_achat = "";
	private $annee_sortie ="";
	private $duree_partie = "";
	private $illustrateur ="";
	private $distributeur ="";
	private $editeur = "";
	private $idJeu ="";
	
// Id à converser
	private $idVersion = 0;
	private $erreurLoadVersion = false;
    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($idDeJeu , $idDeVersion)
    {var_dump($idDeJeu);var_dump($idDeVersion);
        // On utilise le constructeur de la classe mère
		parent::__construct();
					
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		
		$maVersion = $this->maBase->recupExemplaire($idDeVersion);
				
		if($maVersion == null || $maVersion == false)
		{
			$this->erreurLoadVersion = true;
		}		
		else if($idDeVersion != 0)
		{
			$myVersion = $this->maBase->recupVersion($idDeVersion);var_dump($myVersion);
			$this->idVersion = $myVersion[0][ID_VERSION];
			$this->nomVersion = $myVersion[0][NOM_VERSION];
			$this->description = $myVersion[0][DESCRIPTION_VERSION];
			$this->ageMinimum = $myVersion[0][AGE_MINIMUM];
			$this->nb_joueur_reco = $myVersion[0][NB_JOUEUR_RECOMMANDE];
			$this->duree_partie = $myVersion[0][DUREE_PARTIE];
			$this->prix_achat = $myVersion[0][PRIX_ACHAT];
			$this->annee_sortie = $myVersion[0][ANNEE_SORTIE];
			$this->illustrateur = $myVersion[0][ILLUSTRATEUR];
			$this->distributeur = $myVersion[0][DISTRIBUTEUR];
			$this->editeur = $myVersion[0][EDITEUR];
			$this->idJeu = $myVersion[0][ID_JEU];
						
				
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
			// Contre injection de code
			// mysql_real_escape_string(); Echappement des caractères spéciaux SQL
		
			
			$this->idVersion = $this->filtreChaine($_POST[ID_VERSION], TAILLE_CHAMPS_COURT);
		
			//Nettoyage du nom de la version
			$this->nomVersion = $this->filtreChaine($_POST[NOM_VERSION], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de la Description
			$this->description = $this->filtreChaine($_POST[DESCRIPTION_VERSION], TAILLE_CHAMPS_LONG);
			
			// Nettoyage du Prix MDJT
			$this->ageMinimum = $this->filtreChaine($_POST[AGE_MINIMUM], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de nb joueurs
			//$this->nb_joueur = $this->filtreChaine($_POST[NB_JOUEUR_V], TAILLE_CHAMPS_COURT);
			
			// Nettoyage de nb joueurs reco
			$this->nb_joueur_reco = $this->filtreChaine($_POST[NB_JOUEUR_RECOMMANDE], TAILLE_CHAMPS_COURT);
			
			// Nettoyage duree partie
			$this->duree_partie = $this->filtreChaine($_POST[DUREE_PARTIE], TAILLE_CHAMPS_COURT);
			
			//Nettoyage de prix acaht
			$this->prix_achat = $this->filtreChaine($_POST[PRIX_ACHAT], TAILLE_CHAMPS_COURT);
			
			//Nettoyage de année sortie
			$this->annee_sortie = $this->filtreChaine($_POST[ANNEE_SORTIE], TAILLE_CHAMPS_COURT);
			
			//Nettoyage de illustrateur
			$this->illustrateur = $this->filtreChaine($_POST[ILLUSTRATEUR], TAILLE_CHAMPS_COURT);
			
			//Nettoyage du distributeur
			$this->distributeur = $this->filtreChaine($_POST[DISTRIBUTEUR], TAILLE_CHAMPS_COURT);
			
			//Nettoyage de date fin vie
			$this->editeur = $this->filtreChaine($_POST[EDITEUR], TAILLE_CHAMPS_COURT);
			
			//id jeu associé
			$this->idJeu = $this->filtreChaine($_POST[ID_JEU], TAILLE_CHAMPS_COURT);
}
	
    public function afficheFormulaire()
    {	
		if($this->erreurLoadVersion)
    		$this->ajouteLigne("<p class='erreurForm'>Attention, tentative de piratage !!</p>");
		else 
		{
			$this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_VERSIONS . "' id='formProfil'>");
			
				$this->ajouteLigne("<input type='hidden' name='idVersion' value='" . $this->idVersion . "' />");
				

			// First fieldset : Nom de la versions
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Jeu associé à la version</legend>");				
			$this->ouvreBloc("<ol>");
			$this->ouvreBloc("<li>");	
			
			$this->ajouteLigne("<label for='" . ID_JEU . "'>" . $this->convertiTexte("Jeu associé") . "</label>");
			$this->ouvreBloc("<select name='" . ID_JEU . "'>");

			
			if($this->idJeu == null)
			{
				$this->ajouteLigne("<option value='null'></option>");	
				$listeJeu = $this->maBase->recupNomJeu(null);			
			}
			else
			{
				$listeJeu = $this->maBase->recupNomJeu($this->idJeu);
				
			}
			
			
			foreach($listeJeu as $jeu)
					$this->ajouteLigne("<option value='" . $jeu[ID_JEU] . "'>" . $jeu[NOM_JEU] . "</option>");
			$this->fermeBloc("</select>");
			$this->fermeBloc("</li>");
			
			$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");
			
			// deuxième fieldset : Nom de la versions
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Nom de la version</legend>");				
			$this->ouvreBloc("<ol>");
			
		
			// Nom
			 $this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NOM_VERSION . "'>" . $this->convertiTexte("Nom de la version") . "</label>");
			$this->ajouteLigne("<input type='text' id='". NOM_VERSION . "' name='" . NOM_VERSION . "' value='" . $this->nomVersion . "' required='required'  />");
			if($this->erreurNom)
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			$this->fermeBloc("</li>");
			
						 
			
			$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");
			
			// Second fieldset : Informations sur la version
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Informations sur la version</legend>");
			$this->ouvreBloc("<ol>");
			
			// Description
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DESCRIPTION_VERSION . "'>" . $this->convertiTexte("Description") . "</label>");
			$this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_VERSION ."' name='" . DESCRIPTION_VERSION . "'>" . $this->description . "</textarea>");
			$this->fermeBloc("</li>");
			
			// Age minimum
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . AGE_MINIMUM . "'>" . $this->convertiTexte("Age min") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . AGE_MINIMUM ."' name='" . AGE_MINIMUM . "' value='" . $this->ageMinimum . "' />");
			$this->fermeBloc("</li>");
			
			// Nombre Joueur
		  /*  $this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NB_JOUEUR_V . "'>" . $this->convertiTexte("Nombre de joueurs") . "</label>");
			$this->ajouteLigne("<input type='text' maxlength='2' name='"  . NB_JOUEUR_V . "' value='" . $this->nb_joueur . "' />");
			$this->fermeBloc("</li>");*/
			
			
			 // Nombre Joueur recommandés
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . NB_JOUEUR_RECOMMANDE . "'>" . $this->convertiTexte("Joueurs recommandés") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . NB_JOUEUR_RECOMMANDE . "' maxlength='2' name='"  . NB_JOUEUR_RECOMMANDE . "' value='" . $this->nb_joueur_reco . "' />");
			$this->fermeBloc("</li>");
			
			 // Durée partie
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DUREE_PARTIE . "'>" . $this->convertiTexte("Durée d'une partie") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . DUREE_PARTIE . "' name='"  . DUREE_PARTIE . "' value='" . $this->duree_partie . "' />");
			$this->fermeBloc("</li>");
			
			
			 // Prix achat
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . PRIX_ACHAT . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . PRIX_ACHAT . "' name='"  . PRIX_ACHAT . "' value='" . $this->prix_achat . "' required='required'  />");
			if($this->erreurPrixAchat)
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			$this->fermeBloc("</li>");
			
			 //Année de sortie
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . ANNEE_SORTIE . "'>" . $this->convertiTexte("Année de sortie") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . ANNEE_SORTIE . "' maxlength='4' name='"  . ANNEE_SORTIE . "' value='" . $this->annee_sortie . "' />");
			$this->fermeBloc("</li>");
			
			//Illustrateur
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . ILLUSTRATEUR . "'>" . $this->convertiTexte("Illustrateur") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . ILLUSTRATEUR . "' name='"  . ILLUSTRATEUR . "' value='" . $this->illustrateur . "' autocomplete='on'  />");
			$this->fermeBloc("</li>");
			
			
			//Distributeur
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . DISTRIBUTEUR . "'>" . $this->convertiTexte("Distributeur") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . DISTRIBUTEUR ."' name='"  . DISTRIBUTEUR . "' value='" . $this->distributeur . "' autocomplete='on' />");
			$this->fermeBloc("</li>");
			
			//Editeur
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . EDITEUR . "'>" . $this->convertiTexte("Editeur") . "</label>");
			$this->ajouteLigne("<input type='text' id='" . EDITEUR . "' name='"  . EDITEUR . "' value='" . $this->editeur . "' autocomplete='on' required='required'  />");
					if($this->erreurEditeur)
				$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être remplit</p>");
			$this->fermeBloc("</li>");
			
			// Catégories
			/*$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for='" . CATEGORIE_J . "'>" . $this->convertiTexte("Catégorie") . "</label>");
			$this->ajouteLigne("<input type='text' name='" . CATEGORIE_J . "' value='" . VIDE . "' />");
			$this->fermeBloc("</li>");*/
						
				
				
			$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");
			
			$this->ouvreBloc("<fieldset>");	
			$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
			$this->ajouteLigne("<button type='submit' name='Ajouter'>Valider</button>");
			$this->fermeBloc("</fieldset>");
			
			$this->fermeBloc("</form>");
	}
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

			$this->recuperationInformationsFormulaire();
			
			var_dump($this->idVersion);
			
			if($this->idVersion == 0)
				$this->maBase->InsertionTableVersion($this->nomVersion,$this->description,$this->ageMinimum,$this->nb_joueur_reco,
											$this->duree_partie,$this->prix_achat,$this->annee_sortie,
											$this->illustrateur,$this->distributeur,$this->editeur, $this->idJeu);													
			
			else
				$this->maBase->UpdateTableVersion($this->idVersion,$this->nomVersion,$this->description,$this->ageMinimum,$this->nb_joueur_reco,
											$this->duree_partie,$this->prix_achat,$this->annee_sortie,
											$this->illustrateur,$this->distributeur,$this->editeur, $this->idJeu);		
			
					
											
											
		
			/*var_dump($this->nomVersion);
			var_dump($this->description);
			var_dump($this->ageMinimum);*/
			//var_dump($this->nb_joueur);
			/*var_dump($this->nb_joueur_reco);
			var_dump($this->duree_partie);
			var_dump($this->prix_achat);
			var_dump($this->annee_sortie);
			var_dump($this->illustrateur);
			var_dump($this->distributeur);
			var_dump($this->editeur);
			var_dump($this->idJeu);*/
		
			
		}
	}	
    
}

?>
