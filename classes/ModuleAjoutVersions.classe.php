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
	private $erreurVersion = false;	
	private $erreurLoadVersion = false;

	private $nomVersion = "";
	private $description = "";
	private $ageMinimum = "";
	private $nbJoueur = "";
	private $nbJoueurReco = "";
	private $prixAchat = "";
	private $anneeSortie ="";
	private $dureePartie = "";
	private $illustrateur ="";
	private $distributeur ="";
	private $editeur = "";
	private $idJeu = 0;
	private $idVersion = 0;
	

	private $chemin;


	
// Methodes
	
    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($idDeJeu , $idDeVersion)
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
					
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		
		
		if($idDeJeu != null && intval($idDeJeu))
		{
			$playId = $this->maBase->recupJeu($idDeJeu);
			if($playId[0] == null)
				$this->erreurLoadVersion = true;
			else
				$this->idJeu = $playId[0][ID_JEU];
		}
		elseif ($idDeJeu != null)
			$this->erreurLoadVersion = true;
		
		if($idDeVersion != null && intval($idDeVersion))
		{
			$myVersion = $this->maBase->recupVersion($idDeVersion);
			if($myVersion[0] == null)
				$this->erreurLoadVersion = true;
			else
			{
				$this->idVersion = $myVersion[0][ID_VERSION];
				$this->nomVersion = $myVersion[0][NOM_VERSION];
				$this->description = $myVersion[0][DESCRIPTION_VERSION];
				$this->ageMinimum = $myVersion[0][AGE_MINIMUM];
				$this->nbJoueurReco = $myVersion[0][NB_JOUEUR_RECOMMANDE];
				$this->dureePartie = $myVersion[0][DUREE_PARTIE];
				$this->prixAchat = $myVersion[0][PRIX_ACHAT];
				$this->anneeSortie = $myVersion[0][ANNEE_SORTIE];
				$this->illustrateur = $myVersion[0][ILLUSTRATEUR];
				$this->distributeur = $myVersion[0][DISTRIBUTEUR];
				$this->editeur = $myVersion[0][EDITEUR];
				if($this->idJeu == 0)
					$this->idJeu = $myVersion[0][ID_JEU];
				elseif($this->idJeu != 0 && $this->idJeu != $myVersion[0][ID_JEU])
					$this->erreurLoadVersion = true;
					
			}
		}
			
				
		// On traite le formulaire, le cas échéant
		$this->traiteFormulaire();
		
		// On affiche le contenu du module
		if($this->erreurLoadVersion)
    		$this->ajouteLigne("<p class='erreurForm'>Attention, tentative de piratage !!</p>");
		else 
		{
			// On affiche le formulaire d'ajout des informations propres à une version d'un jeu
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
		// Contre injection de code
		
		//var_dump($_FILES['PHOTO_VERSION']);		
		
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
		$this->nbJoueurReco = $this->filtreChaine($_POST[NB_JOUEUR_RECOMMANDE], TAILLE_CHAMPS_COURT);
		
		// Nettoyage duree partie
		$this->dureePartie = $this->filtreChaine($_POST[DUREE_PARTIE], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de prix acaht
		$this->prixAchat = $this->filtreChaine($_POST[PRIX_ACHAT], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de année sortie
		$this->anneeSortie = $this->filtreChaine($_POST[ANNEE_SORTIE], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de illustrateur
		$this->illustrateur = intval($this->filtreChaine($_POST[ILLUSTRATEUR], TAILLE_CHAMPS_COURT));
		
		//Nettoyage du distributeur
		$this->distributeur = intval($this->filtreChaine($_POST[DISTRIBUTEUR], TAILLE_CHAMPS_COURT));
		
		//Nettoyage de date fin vie
		$this->editeur = intval($this->filtreChaine($_POST[EDITEUR], TAILLE_CHAMPS_COURT));
		
		//id jeu associé
		$this->idJeu = intval($this->filtreChaine($_POST[ID_JEU], TAILLE_CHAMPS_COURT));
		
			
	}
	
    public function afficheFormulaire()
    {
		if($this->erreurVersion)
			$this->ajouteLigne("<p class='erreurForm'>Une erreur est survenue lors de l'ajout de votre version, veuillez réessayer ou contacter l'administrateur</p>");
			
		$this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_VERSIONS . "' id='formProfil'  enctype='multipart/form-data'>");
		
		$this->ajouteLigne("<input type='hidden' name='idVersion' value='" . $this->idVersion . "' />");
			

		// First fieldset : Nom de la versions
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Jeu associé à la version</legend>");				
		$this->ouvreBloc("<ol>");
		$this->ouvreBloc("<li>");	
		
		$this->ajouteLigne("<label for='" . ID_JEU . "'>" . $this->convertiTexte("Jeu associé") . "</label>");
		$listeJeu = $this->maBase->recupNomJeu(null);
		if($this->idJeu == 0)
			$this->ouvreBloc("<select name='" . ID_JEU . "'>");
		else
			$this->ouvreBloc("<select name='" . ID_JEU . "' disabled='disabled'>");
		foreach($listeJeu as $idJeu => $jeu)
		{
			$name = "";
			$i = 0;
			$taille = sizeof($jeu) - 1;
			foreach($jeu as $nomJeu)
			{
				$name .= $this->convertiTexte($nomJeu[NOM_JEU]);
				if($i < $taille)
					$name .= $this->convertiTexte(" - ");
				$i++;
			}
			if($idJeu == $this->idJeu)
				$this->ajouteLigne("<option value='" . $idJeu . "' selected='selected'>" . $this->convertiTexte($name) . "</option>");
			else
				$this->ajouteLigne("<option value='" . $idJeu . "'>" . $this->convertiTexte($name) . "</option>");
		}
		$this->fermeBloc("</select>");
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li style='display:none;'>");	
		$this->ajouteLigne("<input type='hidden' id='" . ID_JEU . "' name='" . ID_JEU . "' value='" . $this->idJeu . "' />");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		// deuxième fieldset : Nom de la versions
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Nom de la version</legend>");				
		$this->ouvreBloc("<ol>");
		

        
        // Nom
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NOM_VERSION . "'>" . $this->convertiTexte("Nom de la version *") . "</label>");
        $this->ajouteLigne("<input type='text' id='". NOM_VERSION . "' name='" . NOM_VERSION . "' value='" . $this->convertiTexte($this->nomVersion) . "' required='required'  />");
		if($this->erreurNom)
			$this->ajouteLigne("<p class='erreurForm'>Ce champ doit être rempli</p>");
		$this->fermeBloc("</li>");
        $this->fermeBloc("</li>");
			
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PHOTO_VERSION . "'>" . $this->convertiTexte("Photo") . "</label>");
		$this->ajouteLigne("<input type='hidden' name='MAX_FILE_SIZE' value='1234569' />");
		$this->ajouteLigne("<input type='file' name='". PHOTO_VERSION . "' />");

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
		$this->ajouteLigne("<textarea rows='3' id='" . DESCRIPTION_VERSION ."' name='" . DESCRIPTION_VERSION . "'>" . $this->convertiTexte($this->description) . "</textarea>");
		$this->fermeBloc("</li>");
		
		// Age minimum
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . AGE_MINIMUM . "'>" . $this->convertiTexte("Age minimum") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . AGE_MINIMUM ."' name='" . AGE_MINIMUM . "' value='" . $this->convertiTexte($this->ageMinimum) . "' />");
		$this->fermeBloc("</li>");
		
		// Nombre Joueur
	  /*  $this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NB_JOUEUR_V . "'>" . $this->convertiTexte("Nombre de joueurs") . "</label>");
		$this->ajouteLigne("<input type='text' maxlength='2' name='"  . NB_JOUEUR_V . "' value='" . $this->nbJoueur . "' />");
		$this->fermeBloc("</li>");*/
		
		
		// Nombre Joueur recommandés
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NB_JOUEUR_RECOMMANDE . "'>" . $this->convertiTexte("Joueurs recommandés") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NB_JOUEUR_RECOMMANDE . "' maxlength='2' name='"  . NB_JOUEUR_RECOMMANDE . "' value='" . $this->convertiTexte($this->nbJoueurReco) . "' />");
		$this->fermeBloc("</li>");
		
		// Durée partie
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DUREE_PARTIE . "'>" . $this->convertiTexte("Durée d'une partie") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . DUREE_PARTIE . "' name='"  . DUREE_PARTIE . "' value='" . $this->convertiTexte($this->dureePartie) . "' />");
		$this->fermeBloc("</li>");
		
		
		// Prix achat
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PRIX_ACHAT . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . PRIX_ACHAT . "' name='"  . PRIX_ACHAT . "' value='" . $this->convertiTexte($this->prixAchat) . "' />");
		$this->fermeBloc("</li>");
		
		 //Année de sortie
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . ANNEE_SORTIE . "'>" . $this->convertiTexte("Année de sortie") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . ANNEE_SORTIE . "' maxlength='4' name='"  . ANNEE_SORTIE . "' value='" . $this->convertiTexte($this->anneeSortie) . "' />");
		$this->fermeBloc("</li>");
		
		//Illustrateur
		$listeIllustrateur = $this->maBase->recupIllustrateur(null);
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . ILLUSTRATEUR . "'>" . $this->convertiTexte("Illustrateur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . ILLUSTRATEUR . "' name='"  . ILLUSTRATEUR . "' value='" . $this->convertiTexte($this->illustrateur) . "' list='listeIllustrateur' autocomplete='on'  />");
		
		$this->ouvreBloc("<datalist id='listeIllustrateur'>");
		foreach($listeIllustrateur as $illustrateur)
			$this->ajouteLigne("<option id='illustrateur_" . $illustrateur[ID_ILLUSTRATEUR] . "' label='" . $illustrateur[NOM_ILLUSTRATEUR] . "' value=\"" . $this->convertiTexte($illustrateur[NOM_ILLUSTRATEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		
		//Distributeur
		$listeDistributeur = $this->maBase->recupDistributeur(null);
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DISTRIBUTEUR . "'>" . $this->convertiTexte("Distributeur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . DISTRIBUTEUR ."' name='"  . DISTRIBUTEUR . "' value='" . $this->convertiTexte($this->distributeur) . "' list='listeDistributeur' autocomplete='on' />");
		
		$this->ouvreBloc("<datalist id='listeDistributeur'>");
		foreach($listeDistributeur as $distributeur)
			$this->ajouteLigne("<option id='distributeur_" . $distributeur[ID_DISTRIBUTEUR] . "' label='" . $distributeur[NOM_DISTRIBUTEUR] . "' value=\"" . $this->convertiTexte($illustrateur[NOM_DISTRIBUTEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		//Editeur
		$listeEditeur = $this->maBase->recupEditeur(null);
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . EDITEUR . "'>" . $this->convertiTexte("Editeur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . EDITEUR . "' name='"  . EDITEUR . "' value='" . $this->convertiTexte($this->editeur) . "' list='listeEditeur' autocomplete='on' />");
		
		$this->ouvreBloc("<datalist id='listeEditeur'>");
		foreach($listeEditeur as $editeur)
			$this->ajouteLigne("<option id='editeur_" . $editeur[ID_EDITEUR] . "' label='" . $illustrateur[NOM_EDITEUR] . "' value=\"" . $this->convertiTexte($illustrateur[NOM_EDITEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
				
			
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

			$this->recuperationInformationsFormulaire();
			
			if(strcmp($this->nomVersion, "") == 0 || $this->nomVersion == null)
				$this->erreurNom = true;
			
			if(!floatval($this->prixAchat) || $this->prixAchat < 0)
				$this->erreurPrixAchat = true;
			
			if(strcmp($this->editeur, "") == 0 || $this->editeur == null)
				$this->erreurEditeur = true;
						
			
			$chemin = 'fichier/';
			$resultat2 = move_uploaded_file($_FILES['PHOTO_VERSION']['tmp_name'],$chemin.$_FILES['PHOTO_VERSION']['name']);  
			//var_dump($resultat2);

			
			if (is_uploaded_file($_FILES['PHOTO_VERSION']['tmp_name']))
			{
				$nomPhoto = $_FILES['PHOTO_VERSION']['name'];
				 // recupération de l'extension du fichier
				// autrement dit tout ce qu'il y a après le dernier point (inclus)
				$extension = substr($nomPhoto,strrpos($nomPhoto,"."));
				// Contrôle de l'extension du fichier
				$extensionsAutorisees = array(".jpeg", ".jpg", ".gif");
				if (!(in_array($extension, $extensionsAutorisees))) {
				die("Le fichier n'a pas l'extension attendue");
				}
			}
			
			$this->chemin = 'fichier/';
			move_uploaded_file($_FILES['PHOTO_VERSION']['tmp_name'],$chemin.$_FILES['PHOTO_VERSION']['name']);  
			
			$this->chemin .= $_FILES['PHOTO_VERSION']['name'];
	
			
			if(!$this->erreurNom)
			{
				if($this->idVersion == 0 )
				if($this->idVersion == 0 && $resultat2)
				{
					$this->idVersion = $this->maBase->InsertionTableVersion($this->nomVersion, $this->description, $this->ageMinimum, $this->nbJoueurReco, $this->dureePartie, $this->prixAchat, $this->anneeSortie, $this->illustrateur, $this->distributeur, $this->editeur, $this->idJeu);													
					//$this->idPhotoVersion = 
					$this->maBase->InsertionTablePhoto($this->chemin);
					if($this->idVersion == null || !$this->idVersion)
						$this->erreurVersion = true;
					else
					{
						header("Location: " . MODULE_AJOUT_EXEMPLAIRES . "&idVersion=" . $this->idVersion);
						exit;
					}
				
					
				}
				else
				{
					$this->maBase->UpdateTableVersion($this->idVersion, $this->nomVersion, $this->description, $this->ageMinimum, $this->nbJoueurReco, $this->dureePartie, $this->prixAchat, $this->anneeSortie, $this->illustrateur, $this->distributeur, $this->editeur, $this->idJeu);
					
					header("Location: " . MODULE_GESTION_JEUX);
					exit;
				}
			}

		}
	}	
    
}

?>
