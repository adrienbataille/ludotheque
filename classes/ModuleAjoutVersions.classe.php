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
	private $erreurPhotoFormat = false;
	private $erreurPhotoTaille = false;

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
	private $idEditeur;
	private $idIllustrateur;
	private $idDistributeur;
	private $idPhotoVersion = 0;
	
	private $chemin;
	private $TexteAlternatif="";

	
// Methodes
	
    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($idDeJeu , $idDeVersion)
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
					
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
		
		
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
				$this->nbJoueur[] = split(",", $myVersion[0][NB_JOUEUR]);
				$this->nbJoueurReco = $myVersion[0][NB_JOUEUR_RECOMMANDE];
				$this->dureePartie = $myVersion[0][DUREE_PARTIE];
				$this->prixAchat = $myVersion[0][PRIX_ACHAT];
				$this->anneeSortie = $myVersion[0][ANNEE_SORTIE];
				$this->illustrateur = $myVersion[0][ID_ILLUSTRATEUR];
				$this->distributeur = $myVersion[0][ID_DISTRIBUTEUR];
				$this->editeur = $myVersion[0][ID_EDITEUR];
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
    		$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte("Attention, tentative de piratage !!") . "</p>");
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
		
		//Nettoyage du texte alternatif de la photo
		$this->TexteAlternatif = $this->filtreChaine($_POST[TEXTE_ALTERNATIF], TAILLE_CHAMPS_COURT);
		
		// Nettoyage de la Description
		$this->description = $this->filtreChaine($_POST[DESCRIPTION_VERSION], TAILLE_CHAMPS_LONG);
		
		// Nettoyage du Prix MDJT
		$this->ageMinimum = $this->filtreChaine($_POST[AGE_MINIMUM], TAILLE_CHAMPS_COURT);
		
		// Nettoyage de nb joueurs
		$this->nbJoueur = Array();
		foreach($_POST[NB_JOUEUR] as  $nbJoueur)
			$this->nbJoueur[] = $this->filtreChaine($nbJoueur, TAILLE_CHAMPS_COURT);
		
		// Nettoyage de nb joueurs reco
		$this->nbJoueurReco = $this->filtreChaine($_POST[NB_JOUEUR_RECOMMANDE], TAILLE_CHAMPS_COURT);
		
		// Nettoyage duree partie
		$this->dureePartie = $this->filtreChaine($_POST[DUREE_PARTIE], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de prix acaht
		$this->prixAchat = $this->filtreChaine($_POST[PRIX_ACHAT], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de année sortie
		$this->anneeSortie = $this->filtreChaine($_POST[ANNEE_SORTIE], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de illustrateur
		$this->illustrateur = $this->filtreChaine($_POST[NOM_ILLUSTRATEUR], TAILLE_CHAMPS_COURT);
		
		//Nettoyage du distributeur
		$this->distributeur = $this->filtreChaine($_POST[NOM_DISTRIBUTEUR], TAILLE_CHAMPS_COURT);
		
		//Nettoyage de date fin vie
		$this->editeur = $this->filtreChaine($_POST[NOM_EDITEUR], TAILLE_CHAMPS_COURT);
		
		//id jeu associé
		$this->idJeu = intval($this->filtreChaine($_POST[ID_JEU], TAILLE_CHAMPS_COURT));
		
			
	}
	
    public function afficheFormulaire()
    {
		if($this->erreurVersion)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte("Une erreur est survenue lors de l'ajout de votre version, veuillez réessayer ou contacter l'administrateur") . "</p>");
			
		$this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_VERSIONS . "' id='formProfil'  enctype='multipart/form-data'>");
		
		$this->ajouteLigne("<input type='hidden' name='idVersion' value='" . $this->idVersion . "' />");
			

		// First fieldset : Nom de la versions
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Jeu associé à la version") . "</legend>");				
		$this->ouvreBloc("<ol>");
		$this->ouvreBloc("<li>");	
		
		$this->ajouteLigne("<label for='" . ID_JEU . "'>" . $this->convertiTexte("Jeu associé") . "</label>");
		$listeJeu = $this->maBase->recupNomJeu(null);
		if($this->idJeu == 0)
			$this->ouvreBloc("<select id='" . ID_JEU . "' name='" . ID_JEU . "'>");
		else
			$this->ouvreBloc("<select id='" . ID_JEU . "' name='" . ID_JEU . "' disabled='disabled'>");
		if($listeJeu != null)
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
		
		if($this->idJeu != 0)
		{
			$this->ouvreBloc("<li style='display:none;'>");	
			$this->ajouteLigne("<input type='hidden' id='" . ID_JEU . "' name='" . ID_JEU . "' value='" . $this->idJeu . "' />");
			$this->fermeBloc("</li>");
		}
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		//fieldset : Nom de la versions
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Nom de la version") . "</legend>");				
		$this->ouvreBloc("<ol>");
		
	        
        // Nom
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NOM_VERSION . "'>" . $this->convertiTexte("Nom de la version *") . "</label>");
        $this->ajouteLigne("<input type='text' id='". NOM_VERSION . "' name='" . NOM_VERSION . "' value='" . $this->convertiTexte($this->nomVersion) . "' required='required'  />");
		if($this->erreurNom)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_CHAMP_REQUIS) . "</p>");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
		
		
		//fieldset : Photo
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Photo") . "</legend>");				
		$this->ouvreBloc("<ol>");
				
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PHOTO_VERSION . "'>" . $this->convertiTexte("Photo") . "</label>");
		$this->ajouteLigne("<input type='hidden' name='MAX_FILE_SIZE' value='512000' />");
		$this->ajouteLigne("<input id='". PHOTO_VERSION . "' type='file' name='". PHOTO_VERSION . "' />");
		if($this->erreurPhotoFormat)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_PHOTO_FORMAT) . "</p>");
		if($this->erreurPhotoTaille)
			$this->ajouteLigne("<p class='erreurForm'>" . $this->convertiTexte(ERREUR_PHOTO_TAILLE) . "</p>");
		$this->fermeBloc("</li>");
		
		// Texte alternatif photo
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . TEXTE_ALTERNATIF . "'>" . $this->convertiTexte("Texte alternatif") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . TEXTE_ALTERNATIF ."' name='" . TEXTE_ALTERNATIF . "' value='" . $this->convertiTexte($this->TexteAlternatif) . "' />");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        

		// fieldset : Informations sur la version
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Informations sur la version") . "</legend>");
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
	    $this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NB_JOUEUR . "'>" . $this->convertiTexte("Nombre de joueurs") . "</label>");
		
		if(in_array("1", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='1' checked='checked' />1");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='1' />1");
		
		if(in_array("2", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='2' checked='checked' />2");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='2' />2");
		
		if(in_array("3", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='3' checked='checked' />3");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='3' />3");
		
		if(in_array("4", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='4' checked='checked' />4");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='4' />4");
		
		if(in_array("5", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='5' checked='checked' />5");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='5' />5");
		
		if(in_array("6", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='6' checked='checked' />6");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='6' />6");
		
		if(in_array("7", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='7' checked='checked' />7");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='7' />7");
		
		if(in_array("8", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='8' checked='checked' />8");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='8' />8");
			
		if(in_array("9", $this->nbJoueur))
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='9' checked='checked' />9");
		else
			$this->ajouteLigne("<input type='checkbox' name='"  . NB_JOUEUR . "[]' id='" . NB_JOUEUR . "' value='9' />9 et plus");
		
		$this->fermeBloc("</li>");
		
		
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
		$this->ajouteLigne("<label for='" . NOM_ILLUSTRATEUR . "'>" . $this->convertiTexte("Illustrateur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_ILLUSTRATEUR . "' name='"  . NOM_ILLUSTRATEUR . "' value='" . $this->convertiTexte($this->illustrateur) . "' list='listeIllustrateur' autocomplete='off'  />");
		
		$this->ouvreBloc("<datalist id='listeIllustrateur'>");
		if($listeIllustrateur != null)
			foreach($listeIllustrateur as $illustrateur)
				$this->ajouteLigne("<option id='illustrateur_" . $illustrateur[ID_ILLUSTRATEUR] . "' label='" . $illustrateur[NOM_ILLUSTRATEUR] . "' value=\"" . $this->convertiTexte($illustrateur[NOM_ILLUSTRATEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		
		//Distributeur
		$listeDistributeur = $this->maBase->recupDistributeur(null);
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_DISTRIBUTEUR . "'>" . $this->convertiTexte("Distributeur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_DISTRIBUTEUR ."' name='"  . NOM_DISTRIBUTEUR . "' value='" . $this->convertiTexte($this->distributeur) . "' list='listeDistributeur' autocomplete='off' />");
		
		$this->ouvreBloc("<datalist id='listeDistributeur'>");
		if($listeDistributeur != null)
			foreach($listeDistributeur as $distributeur)
				$this->ajouteLigne("<option id='distributeur_" . $distributeur[ID_DISTRIBUTEUR] . "' label='" . $distributeur[NOM_DISTRIBUTEUR] . "' value=\"" . $this->convertiTexte($distributeur[NOM_DISTRIBUTEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		//Editeur
		$listeEditeur = $this->maBase->recupEditeur(null);
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_EDITEUR . "'>" . $this->convertiTexte("Editeur") . "</label>");
		$this->ajouteLigne("<input type='text' id='" . NOM_EDITEUR . "' name='"  . NOM_EDITEUR . "' value='" . $this->convertiTexte($this->editeur) . "' list='listeEditeur' autocomplete='off' />");
		
		$this->ouvreBloc("<datalist id='listeEditeur'>");
		if($listeEditeur != null)
			foreach($listeEditeur as $editeur)
				$this->ajouteLigne("<option id='editeur_" . $editeur[ID_EDITEUR] . "' label='" . $editeur[NOM_EDITEUR] . "' value=\"" . $this->convertiTexte($editeur[NOM_EDITEUR]) . "\">");
		$this->fermeBloc("</datalist>");
		
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='ajouter' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Ajouter' value='true'>" . $this->convertiTexte("Valider") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='ajouterVersion' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterVersion' value='true'>" . $this->convertiTexte("Valider et ajouter une autre version") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='ajouterExemplaire' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterExemplaire' value='true'>" . $this->convertiTexte("Valider et ajouter des exemplaires à cette version") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
    }
	
	/*
	* Traitement formulaire
	*/
	
	private function traiteFormulaire()
	{
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["Ajouter"] || $_POST["AjouterVersion"] || $_POST["AjouterExemplaire"])
		{
			// Traitement du formulaire
			$this->traitementFormulaire = true;	

			$this->recuperationInformationsFormulaire();
			
			if(strcmp($this->nomVersion, "") == 0 || $this->nomVersion == null)
				$this->erreurNom = true;
			
			if((!floatval($this->prixAchat) || $this->prixAchat < 0) && $this->prixAchat != null)
				$this->erreurPrixAchat = true;
			
			$listeIllustrateurSelect = split(",", $this->distributeur);
			$listeIllustrateurBase = $this->maBase->recupIllustrateur(null);
			foreach($listeIllustrateurBase as $arrayIll => $unIllustrateur)
			{
				if(in_array($unIllustrateur[NOM_ILLUSTRATEUR], $listeIllustrateurSelect))
				{
					$this->idIllustrateur[] = $unIllustrateur[ID_ILLUSTRATEUR];
					unset($listeIllustrateurSelect[array_search($unIllustrateur[NOM_ILLUSTRATEUR], $listeIllustrateurSelect)]);
				}
			}
			foreach($listeIllustrateurSelect as $illustrateur)
				$this->idIllustrateur[] = $this->maBase->InsertionTableIllustrateur($illustrateur);
			
			
			$listeDistributeurSelect = split(",", $this->distributeur);
			$listeDistributeurBase = $this->maBase->recupDistributeur(null);
			foreach($listeDistributeurBase as $arrayDis => $unDistributeur)
			{
				if(in_array($unDistributeur[NOM_DISTRIBUTEUR], $listeDistributeurSelect))
				{
					$this->idDistributeur[] = $unDistributeur[ID_DISTRIBUTEUR];
					unset($listeDistributeurSelect[array_search($unDistributeur[NOM_DISTRIBUTEUR], $listeDistributeurSelect)]);
				}
			}
			foreach($listeDistributeurSelect as $distributeur)
				$this->idDistributeur[] = $this->maBase->InsertionTableDistributeur($distributeur);
			
			
			$listeEditeurSelect = split(",", $this->editeur);
			$listeEditeurBase = $this->maBase->recupEditeur(null);
			foreach($listeEditeurBase as $arrayEd => $unEditeur)
			{
				if(in_array($unEditeur[NOM_EDITEUR], $listeEditeurSelect))
				{
					$this->idEditeur[] = $unEditeur[ID_EDITEUR];
					unset($listeEditeurSelect[array_search($unEditeur[NOM_EDITEUR], $listeEditeurSelect)]);
				}
			}
			foreach($listeEditeurSelect as $editeur)
				$this->idEditeur[] = $this->maBase->InsertionTableEditeur($editeur);
		
			if(!$this->erreurNom && !$this->erreurPrixAchat)
			{
						
						
				if($_FILES[PHOTO_VERSION]['name'] != null)
				{
					if (($_FILES[PHOTO_VERSION]['size'] == 0 && $_FILES[PHOTO_VERSION]['name'] != null) || $_FILES[PHOTO_VERSION]['size'] > 512000)
						$this->erreurPhotoTaille = true;
					
					$nomPhoto = md5(date("Y-m-d-H-i-s")).$_FILES[PHOTO_VERSION]['name'];
					// recupération de l'extension du fichier
					// autrement dit tout ce qu'il y a après le dernier point (inclus)
					$extension = substr($nomPhoto,strrpos($nomPhoto,"."));
					// Contrôle de l'extension du fichier
					$extensionsAutorisees = array(".jpeg", ".jpg", ".gif", ".png");
					
					$this->chemin = $nomPhoto;
					
					if (!(in_array($extension, $extensionsAutorisees)))
						$this->erreurPhotoFormat = true;
					
				}
				
				if(!$this->erreurPhotoFormat && !$this->erreurPhotoTaille) {
				
					if($_FILES[PHOTO_VERSION]['name'] != null)
					{
						if (is_uploaded_file($_FILES[PHOTO_VERSION]['tmp_name']))
							$this->redimension_image($_FILES[PHOTO_VERSION], 512000, 200, 200, 'fichier/');
					}
					
					$myPlayer = "";
					$sizePlayer = sizeof($this->nbJoueur);
					foreach($this->nbJoueur as $nb) {
						$myPlayer .= $nb;
						$sizePlayer--;
						if($sizePlayer > 0)
							$myPlayer .= ",";
					}
					
					if($this->idVersion == 0/* && $resultat2*/)
					{
						$this->idVersion = $this->maBase->InsertionTableVersion($this->nomVersion, $this->description, $this->ageMinimum, $myPlayer, $this->nbJoueurReco, $this->dureePartie, $this->prixAchat, $this->anneeSortie, $this->idJeu);													
						if($this->chemin != null)
						$this->idPhotoVersion = $this->maBase->InsertionTablePhoto($this->chemin, $this->TexteAlternatif);
						$this->maBase->InsertionTablePhotoVersion($this->idPhotoVersion,$this->idVersion);
					}
					else
						$this->maBase->UpdateTableVersion($this->idVersion, $this->nomVersion, $this->description, $this->ageMinimum, $myPlayer, $this->nbJoueurReco, $this->dureePartie, $this->prixAchat, $this->anneeSortie, $this->idJeu);
					
					$this->maBase->DeleteTableEditeurVersion($this->idVersion);
					$this->maBase->DeleteTableDistributeurVersion($this->idVersion);
					$this->maBase->DeleteTableIllustrateurVersion($this->idVersion);
					
					foreach($this->idDistributeur as $distributeur)
						$this->maBase->InsertionTableDistributeurVersion($this->idVersion, $distributeur);
					foreach($this->idIllustrateur as $illustrateur)
						$this->maBase->InsertionTableIllustrateurVersion($this->idVersion, $illustrateur);
	
					if($this->idVersion == null || !$this->idVersion)
						$this->erreurVersion = true;
					else
					{
						if($_POST["Ajouter"]) {
							//header("Location: " . MODULE_GESTION_JEUX);
							//exit;
						} else if($_POST["AjouterExemplaire"]) {
							header("Location: " . MODULE_AJOUT_EXEMPLAIRES . "&idVersion=" . $this->idVersion);
							exit;
						} else if($_POST["AjouterVersion"]) {
							header("Location: " . MODULE_AJOUT_VERSIONS . "&idJeu=" . $this->idJeu);
							exit;
						} else {}
					}
				}
			}
		}
	}
	
	function redimension_image($fichier, $poidsMax, $largeurMax, $hauteurMax, $dossier = "") {
		$retour = 1;
		if($fichier['size'] <= $poidsMax) {
			$retour                = 2;
			$infosfichier          = pathinfo($fichier['name']);
			$extension_upload      =  substr($fichier['name'],strrpos($fichier['name'],"."));
			$extensions_autorisees = array(".jpg", ".jpeg", ".gif", ".png");
			//$nomImg                = basename($fichier['name']);
	
			$nomImg = md5(date("Y-m-d-H-i-s")).basename($fichier['name']);
	
	
	
	
			if(in_array($extension_upload, $extensions_autorisees)) {
				$retour  = 0;
				$infos   = getimagesize($fichier['tmp_name']);
				$largeur = $infos[0];
				$hauteur = $infos[1];
	
				if($largeur > $largeurMax || $hauteur > $hauteurMax) {
					if($extension_upload == ".jpg" || $extension_upload == ".jpeg") {
						$objImage = imagecreatefromjpeg($fichier['tmp_name']);
					}
					elseif($extension_upload == ".gif") {
						$objImage = imagecreatefromgif($fichier['tmp_name']);
					}
					else {
						$objImage = imagecreatefrompng($fichier['tmp_name']);
					}
	
					if($largeur >= $hauteur && $largeur > $largeurMax) {
						// REDUCTION PAR LA LARGEUR
						$nouvelleLargeur = $largeurMax;
						$reduction       = ( ($largeurMax*100) / $largeur );
						$nouvelleHauteur = ( ($hauteur*$reduction) / 100 );
					}
					else {
						// REDUCTION PAR LA HAUTEUR
						$nouvelleHauteur = $hauteurMax;
						$reduction       = ( ($hauteurMax*100) / $hauteur );
						$nouvelleLargeur = ( ($largeur*$reduction) / 100 );
					}
	
					$nouvelleImage = imagecreatetruecolor($nouvelleLargeur , $nouvelleHauteur);
	
					if($extension_upload == ".png") {
						// fond transparent (pour les png avec transparence)
						imagesavealpha($nouvelleImage, true);
						$trans_color = imagecolorallocatealpha($nouvelleImage, 0, 0, 0, 127);
						imagefill($nouvelleImage, 0, 0, $trans_color);
					}
	
					imagecopyresampled($nouvelleImage, $objImage, 0, 0, 0, 0, $nouvelleLargeur, $nouvelleHauteur, $largeur, $hauteur);
					imagedestroy($objImage);
	
					if($extension_upload == ".jpg" || $extension_upload == ".jpeg") {
						imagejpeg($nouvelleImage, $dossier.$nomImg, 100);
					}
					elseif($extension_upload == ".gif") {
						imagegif($nouvelleImage, $dossier.$nomImg);
					}
					else {
						imagepng($nouvelleImage, $dossier.$nomImg, 9);
	
					}
				}
				else {
					move_uploaded_file($fichier['tmp_name'], $dossier.$nomImg);
				}
			}
		}
		return $retour;
	}
    
}

?>
