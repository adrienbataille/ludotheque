<?php
/**
* Classe de gestion de l'accès à la base de donnée
*
*/

// Inclusions
require_once("classes/AccesAuxDonnees.classe.php");
require_once("classes/RequeteSQL.classe.php");

//Constantes - paramètre du système
define("SERVEUR_DEV","127.0.0.1");
define("LOGIN_DEV","ludotheque");
define("MDP_DEV","ludo");
define("BASE_DEV","mdjtufjjpdev");
define("TABLE_PREFIX_DEV","MDJT_");

// Constantes - Definition des Tables SQL
define("TABLE_AUTEUR", TABLE_PREFIX_DEV . "AUTEUR");
define("TABLE_AUTEUR_JEU", TABLE_PREFIX_DEV . "AUTEUR_JEU");
define("TABLE_CATEGORIE", TABLE_PREFIX_DEV . "CATEGORIE");
define("TABLE_CATEGORIE_JEU", TABLE_PREFIX_DEV . "CATEGORIE_JEU");
define("TABLE_DISTRIBUTEUR", TABLE_PREFIX_DEV . "DISTRIBUTEUR");
define("TABLE_DISTRIBUTEUR_VERSION", TABLE_PREFIX_DEV . "DISTRIBUTEUR_VERSION");
define("TABLE_EDITEUR", TABLE_PREFIX_DEV . "EDITEUR");
define("TABLE_EDITEUR_VERSION", TABLE_PREFIX_DEV . "EDITEUR_VERSION");
define("TABLE_EMPRUNT", TABLE_PREFIX_DEV . "EMPRUNT");
define("TABLE_ETAT_EXEMPLAIRE", TABLE_PREFIX_DEV . "ETAT_EXEMPLAIRE");
define("TABLE_EXEMPLAIRE", TABLE_PREFIX_DEV . "EXEMPLAIRE");
define("TABLE_EXTENSION", TABLE_PREFIX_DEV . "EXTENSION");
define("TABLE_FAIRE_PARTIE_KIT", TABLE_PREFIX_DEV . "FAIRE_PARTIE_KIT");
define("TABLE_ILLUSTRATEUR", TABLE_PREFIX_DEV . "ILLUSTRATEUR");
define("TABLE_ILLUSTRATEUR_VERSION", TABLE_PREFIX_DEV . "ILLUSTRATEUR_VERSION");
define("TABLE_INVENTAIRE", TABLE_PREFIX_DEV . "INVENTAIRE");
define("TABLE_JEUX", TABLE_PREFIX_DEV . "JEUX");
define("TABLE_KIT_JEUX", TABLE_PREFIX_DEV . "KIT_JEUX");
define("TABLE_LANGUE", TABLE_PREFIX_DEV . "LANGUE");
define("TABLE_LANGUE_REGLE", TABLE_PREFIX_DEV . "LANGUE_REGLE");
define("TABLE_LIEU", TABLE_PREFIX_DEV . "LIEU");
define("TABLE_NOM_JEU", TABLE_PREFIX_DEV . "NOM_JEU");
define("TABLE_NOTE_VERSION", TABLE_PREFIX_DEV . "NOTE_VERSION");
define("TABLE_PAYS", TABLE_PREFIX_DEV . "PAYS");
define("TABLE_PHOTO", TABLE_PREFIX_DEV . "PHOTO");
define("TABLE_PHOTO_VERSION", TABLE_PREFIX_DEV . "PHOTO_VERSION");
define("TABLE_RESERVATION", TABLE_PREFIX_DEV . "RESERVATION");
define("TABLE_SUGGESTION", TABLE_PREFIX_DEV . "SUGGESTION");
define("TABLE_VERSION", TABLE_PREFIX_DEV . "VERSION");

// Définition des champs de la table TABLE_AUTEUR
define("ID_AUTEUR", "idAuteur");
define("NOM_AUTEUR", "nomAuteur");

// Définition des champs de la table TABLE_AUTEUR_JEU
define("ID_AUTEUR_JEU", "idAuteurJeu");

// Définition des champs de la table TABLE_CATEGORIE
define("ID_CATEGORIE", "idCategorie");
define("NOM_CATEGORIE", "nomCategorie");
define("DESCRIPTION_CATEGORIE", "descriptionCategorie");

// Définition des champs de la table TABLE_CATEGORIE_JEU
define("ID_CATEGORIE_JEU", "idCategorieJeu");

// Définition des champs de la table TABLE_DISTRIBUTEUR
define("ID_DISTRIBUTEUR", "idDistributeur");
define("NOM_DISTRIBUTEUR", "nomDistributeur");

// Définition des champs de la table TABLE_EDITEUR
define("ID_EDITEUR", "idEditeur");
define("NOM_EDITEUR", "nomEditeur");

// Définition des champs de la table TABLE_EMPRUNT
define("ID_EMPRUNT", "idEmprunt");
define("DATE_EMPRUNT", "dateEmprunt");
define("DATE_RETOUR_SOUHAITE", "dateRetourSouhaite");
define("DATE_RETOUR_REEL", "dateRetourReel");

// Définition des champs de la table TABLE_ETAT_EXEMPLAIRE
define("ID_ETAT_EXEMPLAIRE", "idEtatExemplaire");
define("NOM_ETAT", "nomEtat");

// Définition des champs de la table TABLE_EXEMPLAIRE
define("ID_EXEMPLAIRE", "idExemplaire");
define("CODE_BARRE", "codeBarre");
define("DESCRIPTION_EXEMPLAIRE", "descriptionExemplaire");
define("PRIX_MDJT", "prixMDJT");
define("DATE_ACHAT", "dateAchat");
define("DATE_FIN_VIE", "dateFinVie");
define("ID_LIEU_REEL", "idLieuReel");
define("ID_LIEU_TEMPO", "idLieuTempo");

// Définition des champs de la table TABLE_EXTENSION
define("ID_EXTENSION", "idExtension");
define("NATURE", "nature");
define("ID_VERSION_BASE", "idVesionBase");
define("ID_VERSION_EXTENSION", "idVersionExtension");

// Définition des champs de la table TABLE_FAIRE_PARTIE_KIT
define("ID_FAIRE_PARTIE_KIT", "idFairePartieKit");

// Définition des champs de la table TABLE_ILLUSTRATEUR
define("ID_ILLUSTRATEUR", "idIllustrateur");
define("NOM_ILLUSTRATEUR", "nomIllustrateur");

// Définition des champs de la table TABLE_INVENTAIRE
define("ID_INVENTAIRE", "idInventaire");
define("DATE_INVENTAIRE", "dateInventaire");
define("COMMENTAIRE_INVENTAIRE", "commentaireInventaire");

// Définition des champs de la table TABLE_JEUX
define("ID_JEU", "idJeu");
define("DESCRIPTION_JEU", "descriptionJeu");
define("AUTEUR", "auteur");

// Définition des champs de la table TABLE_KIT_JEUX
define("ID_KIT_JEU", "idKitJeu");
define("NOM_KIT_JEU", "nomKit");
define("DESCRIPTIOIN_KIT", "descriptionKit");

// Définition des champs de la table TABLE_LANGUE
define("ID_LANGUE", "idLangue");
define("NOM_LANGUE", "nomLangue");

// Définition des champs de la table TABLE_LANGUE_REGLE
define("ID_LANGUE_REGLE", "idLangueRegle");

// Définition des champs de la table TABLE_LIEU
define("ID_LIEU", "idLieu");
define("NOM_LIEU", "nomLieu");

// Définition des champs de la table TABLE_NOM_JEU
define("ID_NOM_JEU", "idNomJeu");
define("NOM_JEU", "nomJeu");

// Définition des champs de la table TABLE_NOTE_VERSION
define("ID_NOTE_VERSION", "idNoteVersion");
define("NOTE_VERSION", "noteVersion");
define("COMMENTAIRE_NOTE_VERSION", "commentaireNoteVersion");

// Définition des champs de la table TABLE_PAYS
define("ID_PAYS", "idPays");
define("NOM_PAYS", "nomPays");

// Définition des champs de la table TABLE_PHOTO
define("ID_PHOTO", "idPhoto");
define("NOM_PHOTO", "nomPhoto");
define("TEXTE_ALTERNATIF", "texteAlternatif");

// Définition des champs de la table TABLE_PHOTO_VERSION
define("ID_PHOTO_VERSION", "idPhotoVERSION");

// Définition des champs de la table TABLE_RESERVATION
define("ID_RESERVATION", "idReversation");
define("DATE_SOUHAITE_EMPRUNT", "dateSouhaiteEmprunt");

// Définition des champs de la table TABLE_SUGGESTION
define("ID_SUGGESTION", "idSuggestion");
define("COMMENTAIRE_SUGGESTION", "commentaireSugeestion");
define("ETAT_SUGGESTION", "etatSuggestion");

// Définition des champs de la table TABLE_VERSION
define("ID_VERSION", "idVersion");
define("NOM_VERSION", "nomVersion");
define("DESCRIPTION_VERSION", "descriptionVersion");
define("AGE_MINIMUM", "ageMinimum");
define("NB_JOUEUR", "nbJoueur");
define("NB_JOUEUR_RECOMMANDE", "nbJoueurRecommande");
define("DUREE_PARTIE", "dureePartie");
define("PRIX_ACHAT", "prixAchat");
define("ANNEE_SORTIE", "anneeSortie");
	


//Définition des signes

define("SUPERIEUR","sup");

define("INFERIEUR","inf");

define("EGAL","egal");

//Définition des états
define("DISPONIBLE","1");

/**

 * Classe de gestion de l'accès à la base de donnée

 * @package common

 */


class AccesAuxDonneesDev
{

	// Attributs

	// Variable de classe stockant le premier objet créé
	// Sert à garantir qu'on ne créera qu'un seul objet
	private static $connexionBase = NULL;
	// Objet d'acces a la base
	private $maBase = NULL;
	// Est-on déjà connecté à la base - sert à éviter les connexions multiples
	private $estConnecte = NULL;

	// Methodes

	/*
	 * Le constructeur d'une connexion à la base
	*/
	public function __construct()
	{
		// A la création de l'objet, on est pas connecté à la base
		$this->estConnecte = FALSE;
	}

	// On interdit le clonage de cet objet	
        public function __clone()
        {
            trigger_error("Clonage d'accès aux données interdit.", E_USER_ERROR);
        }

	// On interdit de reveiller un objet AccesAuxDonnees sérialisé
        public function __wakeup()
        {
            trigger_error("Unserializing is not allowed.", E_USER_ERROR);
        }
	
	//
	// Outils à usage externe
	//
	
	/**
	* Fonction statique de création d'un accès aux données
	* Cette fonction vérifie qu'un accès aux données n'existe pas avant
	* Elle renvoi l'accès pré-existant, ou un nouvel accès
	*
	* C'est cette fonction qui doit être utilisée 
	* chaque fois qu'on veut avoir accès aux données
	*/
	public static function recupAccesDonneesDev()
	{
		// Initialisation de l'accès à la Base de Donnees
		// Si on a pas encore d'objet d'accès aux donnees
		if ( self::$connexionBase == NULL )
		{
			// On en crée un et on stocke cette connexion dans la variable de classe
			self::$connexionBase = new AccesAuxDonneesDev();
			return self::$connexionBase;
		}
		else
		{
			// Sinon, on récupère celle qui existe déjà
			return self::$connexionBase;
		}
	}
  
  //
  // Outils à usage interne
  //

        /**
        * Fonction de connexion à la base de donnée
        * Cette fonction initie la connexion à la base de données
        * Uniquement si ce n'est pas déjà fait.
        * On l'utilise donc au début de chaque requête
        */
        private function connecteBase()
        {
            // On initie la connexion uniquement si elle n'est pas déjà faite
            if ($this->estConnecte == FALSE)
            {
                try 
                {
                    // Connexion en mode debug
                    $option_dev[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                    $this->maBase = new PDO("mysql:host=" . SERVEUR_DEV . ";dbname=" . BASE_DEV, LOGIN_DEV, MDP_DEV,$option_dev);

                    // Connexion normale
                    // $this->maBase = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE, LOGIN, MDP);
                } 
                catch (PDOException $e)
                {
                        // Accès à la base impossible
                        print "Connexion a la base de donnee impossible à la base de développement<br/>";
                        die();
                }
                $this->estConnecte = TRUE;
            }
	}
	
        
	/**
	* Fonction générique de requête type sélection dans la base
	*/
	private function requeteSelect($uneRequeteSQL)
	{
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();	
		// Si on a bien une connexion à la base
		if ($this->estConnecte)
		{
			// On récupère les résultats sous forme d'un objet PDOStatement
			$resultat = $this->maBase->query($uneRequeteSQL);
			if ($resultat == false)
			{
				// La requete a échoué
				return false;
			}
			else
			{
				// On récupère le resultat de la requete sous la forme d'un tableau
				$tableauResultat = $resultat->fetchAll();
				// On ferme l'objet PDOStatement
				$resultat->closeCursor();
				// On renvoie le tableau avec les résultats de la requête
				return $tableauResultat;
			}
		}
		else
		{ // Sinon, pas de connexion à la base
			// La requete a échoué
			return false;
		}
	}
	
	//
	// Requêtes accessibles au reste du site
	//
	
	/**
    * Fonction d'insertion d'un jeu
    * Entrée : la description, l'auteur et l'id de pays du jeu
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableJeu($uneDescription, $unPays)
    {
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_JEUX . " (" . DESCRIPTION_JEU . ", " . ID_PAYS . ") VALUES(?, ?) ;");
		
		if(strcmp($uneDescription, "") == 0)
			$requete->bindValue(1, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(1, $uneDescription, PDO::PARAM_STR);
			
		if($unPays != 0)
			$requete->bindValue(2, $unPays, PDO::PARAM_INT);
		else
			$requete->bindValue(2, null, PDO::PARAM_NULL);
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id du Jeu inséré
		$requete = $this->maBase->prepare("SELECT ? FROM ? WHERE ?='?' AND ?='?'");
		$requete->bindValue(1, ID_JEU, PDO::PARAM_INT);
		$requete->bindValue(2, TABLE_JEUX, PDO::PARAM_STR);
		$requete->bindValue(3, ID_PAYS, PDO::PARAM_STR);
		$requete->bindValue(4, $unPays, PDO::PARAM_STR);
		$requete->bindValue(5, DESCRIPTION_JEU, PDO::PARAM_STR);
		$requete->bindValue(6, $uneDescription, PDO::PARAM_STR);
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_JEU . ") FROM " . TABLE_JEUX . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'une version
    * Entrée : nom, description, age_min, nb_joueur, nb_joueur recommandés, prix achat, année sortie, illustrateur, distributeur, éditeur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableVersion($nom,$description,$age_min,$nb_joueur,$nb_joueur_reco,$duree_partie,$prix_achat,$annee_sortie,$idJeu)
    {
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_VERSION . " (" . NOM_VERSION . ", " . DESCRIPTION_VERSION . ", " . AGE_MINIMUM . 
										", " . NB_JOUEUR ."," . NB_JOUEUR_RECOMMANDE ."," . DUREE_PARTIE ."," . PRIX_ACHAT . ",". ANNEE_SORTIE ."," . ID_JEU .") VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?) ;");	

	
		//nom
		$requete->bindValue(1, $nom, PDO::PARAM_STR);
			
		//description	
		if(strcmp($description, "") == 0)
			$requete->bindValue(2, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(2, $description, PDO::PARAM_STR);
		
		//age min
		if(strcmp($age_min, "") == 0)
			$requete->bindValue(3, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(3, $age_min, PDO::PARAM_INT);
		
		//nombre de joueurs
		if(strcmp($nb_joueur, "") == 0)
			$requete->bindValue(4, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(4, $nb_joueur, PDO::PARAM_STR);
		
		//nombre de joueurs recommandés
		if(strcmp($nb_joueur_reco, "") == 0)
			$requete->bindValue(5, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(5, $nb_joueur_reco, PDO::PARAM_INT);

		//durée partie
		if(strcmp($duree_partie, "") == 0)
			$requete->bindValue(6, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(6, $duree_partie, PDO::PARAM_INT);	

		//prix achat
		if($prix_achat != 0)
			$requete->bindValue(7, $prix_achat, PDO::PARAM_INT);
		else
			$requete->bindValue(7, "", PDO::PARAM_INT);
	
		//année de sortie
		if(strcmp($annee_sortie, "") == 0)
			$requete->bindValue(8, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(8, $annee_sortie, PDO::PARAM_INT);
		
		//id jeu associé
		$requete->bindValue(9, $idJeu, PDO::PARAM_INT);
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id du Jeu inséré
		$requete = "SELECT MAX(" . ID_VERSION . ") FROM " . TABLE_VERSION . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }
	
	/**
    * Fonction d'insertion d'une photo de version
    * Entrée : chemin de la photo
    */
    public function InsertionTablePhoto($chemin,$TexteAlternatif)
	{

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_PHOTO . " (" . NOM_PHOTO . "," . TEXTE_ALTERNATIF .") VALUES(?,?) ;");	
		
		//nom
		$requete->bindValue(1, $chemin, PDO::PARAM_STR);
		
		//nom
		$requete->bindValue(2, $TexteAlternatif, PDO::PARAM_STR);

		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		$requete = "SELECT MAX(" . ID_PHOTO. ") FROM " . TABLE_PHOTO . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
	}
	
	/**
    * Fonction d'insertion d'une photo de version dans TABLE_PHOTO_VERSION
    * Entrée : chemin de la photo
    */
    public function InsertionTablePhotoVersion($idPhotoVersion, $idVersion)
	{

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_PHOTO_VERSION . " (" . ID_PHOTO . "," .ID_VERSION .") VALUES(?,?) ;");	
		
				
		//idPhotoVersion
		$requete->bindValue(1, $idPhotoVersion, PDO::PARAM_INT);
		
		//idVersion
		$requete->bindValue(2, $idVersion, PDO::PARAM_INT);
		
		$resultat = $requete->execute();


	}

	/**
    * Fonction d'insertion d'un exemplaire
    * Entrée : la description, prix achat, date achat
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableExemplaire($unCodeBarre, $uneDescription, $unPrix, $uneDateAchat, $uneDateFinVie, $uneVersion, $unEtatExemplaire, $unLieuReel, $unLieuTempo)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_EXEMPLAIRE . " (" . CODE_BARRE . ", " . DESCRIPTION_EXEMPLAIRE . ", " . PRIX_MDJT . ", " . DATE_ACHAT . ", " . DATE_FIN_VIE . ", " . ID_VERSION . ", " . ID_ETAT_EXEMPLAIRE . ", " . ID_LIEU_REEL . ", " . ID_LIEU_TEMPO . ") VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?) ;");
		
		$requete->bindValue(1, $unCodeBarre, PDO::PARAM_STR);
		
		if(strcmp($uneDescription, "") == 0)
			$requete->bindValue(2, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(2, $uneDescription, PDO::PARAM_STR);
		
		$requete->bindValue(3, $unPrix, PDO::PARAM_STR);
		$requete->bindValue(4, $uneDateAchat, PDO::PARAM_STR);
		
		if(strcmp($uneDateFinVie, "") == 0)
			$requete->bindValue(5, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(5, $uneDateFinVie, PDO::PARAM_STR);
		
		$requete->bindValue(6, $uneVersion, PDO::PARAM_INT);
		$requete->bindValue(7, $unEtatExemplaire, PDO::PARAM_INT);
		$requete->bindValue(8, $unLieuReel, PDO::PARAM_INT);
		$requete->bindValue(9, $unLieuTempo, PDO::PARAM_INT);
			
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_EXEMPLAIRE . ") FROM " . TABLE_EXEMPLAIRE . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }
	
	
	/**
    * Fonction d'insertion du nom d'un jeu
    * Entrée : la description, l'auteur et l'id de pays du jeu
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableNomJeu($unNom, $uneLangue, $unJeu)
    {
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_NOM_JEU . " (" . NOM_JEU . ", " . ID_LANGUE . ", " . ID_JEU . ") VALUES(?, ?, ?) ;");

		$requete->bindValue(1, $unNom, PDO::PARAM_STR);
		$requete->bindValue(2, $uneLangue, PDO::PARAM_INT);
		$requete->bindValue(3, $unJeu, PDO::PARAM_INT);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id du Jeu inséré
		$requete = "SELECT " . ID_PAYS . " FROM " . TABLE_PAYS . " WHERE " . NOM_PAYS . "='" . $unPays . "' ;";
		$resultat = $this->requeteSelect($requete);
		
		//var_dump($resultat);
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][ID_PAYS];
    }

	/**
    * Fonction d'insertion d'un illsutrateur
    * Entrée : le nom de l'illustrateur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableIllustrateur($unIllustrateur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_ILLUSTRATEUR . " (" . NOM_ILLUSTRATEUR . ") VALUES(?) ;");
		
		$requete->bindValue(1, $unIllustrateur, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_ILLUSTRATEUR . ") FROM " . TABLE_ILLUSTRATEUR . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'un distributeur
    * Entrée : le nom du distributeur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableDistributeur($unDistributeur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_DISTRIBUTEUR . " (" . NOM_DISTRIBUTEUR . ") VALUES(?) ;");
		
		$requete->bindValue(1, $unDistributeur, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_DISTRIBUTEUR . ") FROM " . TABLE_DISTRIBUTEUR . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'un éditeur
    * Entrée : le nom de l'éditeur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableEditeur($unEditeur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_EDITEUR . " (" . NOM_EDITEUR . ") VALUES(?) ;");
		
		$requete->bindValue(1, $unEditeur, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_EDITEUR . ") FROM " . TABLE_EDITEUR . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'une catégorie
    * Entrée : le nom de la catégorie
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableCategorie($uneCategorie)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_CATEGORIE . " (" . NOM_CATEGORIE . ") VALUES(?) ;");
		
		$requete->bindValue(1, $uneCategorie, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'exemplaire inséré
		$requete = "SELECT MAX(" . ID_CATEGORIE . ") FROM " . TABLE_CATEGORIE . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'un auteur
    * Entrée : le nom de l'auteur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableAuteur($unAuteur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_AUTEUR . " (" . NOM_AUTEUR . ") VALUES(?) ;");
		
		$requete->bindValue(1, $unAuteur, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id de l'auteur inséré
		$requete = "SELECT MAX(" . ID_AUTEUR . ") FROM " . TABLE_AUTEUR . " ;";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][0];
    }

	/**
    * Fonction d'insertion d'une catégorie à jeu
    * Entrée : l'id de la catégorie que l'on souhaite affecter à un jeu
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableCategorieJeu($uneCategorie, $unJeu)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_CATEGORIE_JEU . " (" . ID_CATEGORIE . ", " . ID_JEU . ") VALUES(?, ?) ;");
		
		$requete->bindValue(1, $uneCategorie, PDO::PARAM_STR);
		$requete->bindValue(2, $unJeu, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		return $resultat;
    }

	/**
    * Fonction d'insertion d'un éditeur d'une version d'un jeu
    * Entrée : l'id de l'éditeur que l'on souhaite affecter à une version
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableEditeurVersion($uneVersion, $unEditeur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_EDITEUR_VERSION . " (" . ID_EDITEUR . ", " . ID_VERSION . ") VALUES(?, ?) ;");
		
		$requete->bindValue(1, $unEditeur, PDO::PARAM_STR);
		$requete->bindValue(2, $uneVersion, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		return $resultat;
    }

	/**
    * Fonction d'insertion d'un distributeur d'une version d'un jeu
    * Entrée : l'id de le distributeur que l'on souhaite affecter à une version
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableDistributeurVersion($uneVersion, $unDistributeur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_DISTRIBUTEUR_VERSION . " (" . ID_DISTRIBUTEUR . ", " . ID_VERSION . ") VALUES(?, ?) ;");
		
		$requete->bindValue(1, $unDistributeur, PDO::PARAM_STR);
		$requete->bindValue(2, $uneVersion, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		return $resultat;
    }

	/**
    * Fonction d'insertion d'un illustrateur d'une version d'un jeu
    * Entrée : l'id de l'illustrateur que l'on souhaite affecter à une version
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableIllustrateurVersion($uneVersion, $unIllustrateur)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_ILLUSTRATEUR_VERSION . " (" . ID_ILLUSTRATEUR . ", " . ID_VERSION . ") VALUES(?, ?) ;");
		
		$requete->bindValue(1, $unIllustrateur, PDO::PARAM_STR);
		$requete->bindValue(2, $uneVersion, PDO::PARAM_STR);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		return $resultat;
    }

	/**
    * Fonction d'insertion d'un auteur d'un jeu
    * Entrée : l'id de l'auteur que l'on souhaite affecter à un jeu
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableAuteurJeu($unAuteur, $unJeu)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_AUTEUR_JEU . " (" . ID_AUTEUR . ", " . ID_JEU . ") VALUES(?, ?) ;");
		
		$requete->bindValue(1, $unAuteur, PDO::PARAM_INT);
		$requete->bindValue(2, $unJeu, PDO::PARAM_INT);
		
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		return $resultat;
    }
    
    /**
    * Fonction d'insertion d'un pays
    * Entrée : nom du pays
    * Sortie : l'id du pays si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTablePays($unPays)
    {
        // Protection contre injection SQL
        if (strval($unPays))
        {
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			// Création de la requete
			$requete = $this->maBase->prepare("INSERT INTO " . TABLE_PAYS . " (" . NOM_PAYS . ") VALUES(?) ;");
			$requete->bindValue(1, $unPays, PDO::PARAM_STR);
			$resultat = $requete->execute();

			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			// Création de la requete pour récupérer l'id du Pays inséré
			$requete = "SELECT " . ID_PAYS . " FROM " . TABLE_PAYS . " WHERE " . NOM_PAYS . "='" . $unPays . "' ;";
			$resultat = $this->requeteSelect($requete);
			
			//var_dump($resultat);
			if(count($resultat) == 0)
				return false;
			else
				return $resultat[0][ID_PAYS];
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Fonction d'insertion d'une langue
    * Entrée : nom de la langue
    * Sortie : l'id de la langue si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableLangue($uneLangue)
    {
        // Protection contre injection SQL
        if (strval($uneLangue))
        {
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			// Création de la requete
			$requete = $this->maBase->prepare("INSERT INTO " . TABLE_LANGUE . " (" . NOM_LANGUE . ") VALUES(?) ;");
			$requete->bindValue(1, $uneLangue, PDO::PARAM_STR);
			$resultat = $requete->execute();

			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			// Création de la requete pour récupérer l'id de la Langue inséré
			$requete = "SELECT " . ID_LANGUE . " FROM " . TABLE_LANGUE . " WHERE " . NOM_LANGUE . "='" . $uneLangue . "' ;";
			$resultat = $this->requeteSelect($requete);
			
			//var_dump($resultat);
			if(count($resultat) == 0)
				return false;
			else
				return $resultat[0][ID_LANGUE];
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Fonction d'insertion d'une langue
    * Entrée : id de l'exemplaire
    * Entrée : id de la langue
    * Sortie : l'id de la régle dans la langue voulue si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableLangueRegle($unExemplaire, $uneLangue)
    {
        // Protection contre injection SQL
        if (strval($uneLangue))
        {
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			// Création de la requete
			$requete = $this->maBase->prepare("INSERT INTO " . TABLE_LANGUE_REGLE . " (" . ID_EXEMPLAIRE . ", ". ID_LANGUE . ") VALUES(?, ?) ;");
			$requete->bindValue(1, $unExemplaire, PDO::PARAM_INT);
			$requete->bindValue(2, $uneLangue, PDO::PARAM_INT);
			$resultat = $requete->execute();

			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			// Création de la requete pour récupérer l'id de la régle pour l'exemplaire et la Langue
			$requete = "SELECT " . ID_LANGUE_REGLE . " FROM " . TABLE_LANGUE_REGLE . " WHERE " . ID_EXEMPLAIRE . "='" . $unExemplaire . "' AND " . ID_LANGUE . "='" . $uneLangue . "' ;";
			$resultat = $this->requeteSelect($requete);
			
			//var_dump($resultat);
			if(count($resultat) == 0)
				return false;
			else
				return $resultat[0][ID_LANGUE_REGLE];
        }
        else
        {
            return false;
        }
    }
	
    /**
	* Fonction de récupération de la liste des jeux ou un jeu en particulier si on lui passe en paramètre l'id d'un jeu
	* Entrée : id d'un jeu pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupJeu($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_JEUX;
		if($idJeu != null)
			$requete .= " WHERE " . ID_JEU . " = '" . $idJeu . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
	/**
	* Fonction de récupération de la liste des versions ou une version en particulier si on lui passe en paramètre l'id d'une version
	* Entrée : id d'une versions pour laquelle on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupVersion($idVersion)
	{
		$requete = "SELECT * FROM " . TABLE_VERSION;
		if($idVersion != null)
			$requete .= " WHERE " . ID_VERSION . " = '" . $idVersion . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	

    /**
	* Fonction de récupération de la liste des catégories disponibles
	* Sortie : le tableau contenant les catégories
	*/
	public function recupLangue()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_LANGUE . " ORDER BY " . NOM_LANGUE);
		return $laListe;
	}
	
	/**
	* Fonction de récupération de la liste des catégories disponibles
	* Sortie : le tableau contenant les catégories
	*/
	/*public function recupCategorie()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_CATEGORIE);
		return $laListe;
	}*/
	
	/**
	* Fonction de récupération de la liste des lieux disponibles
	* Sortie : le tableau contenant les lieux
	*/
	public function recupLieu()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_LIEU);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des nom d'un jeu dans toutes les langues pour un jeu
	* Entrée : id du jeu pour lequel on souhaite récupérer les langues
	* Sortie : le tableau contenant les catégories
	*/
	public function recupNomJeu($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_NOM_JEU;
		if($idJeu != null)
			$requete .= " WHERE " . ID_JEU . "='" . $idJeu . "'";
		$requete .= " ORDER BY " . NOM_JEU . ";";
		$laListe = $this->requeteSelect($requete);
		
		$resultat;
		if($laListe != null)
			foreach($laListe as $idListe => $nomJeu)
				$resultat[$nomJeu[ID_JEU]][] = $nomJeu;
		
		return $resultat;
	}
	
    /**
	* Fonction de récupération l'id d'un jeu à partir du nom d'un jeu
	* Entrée : nom du jeu pour lequel on souhaite récupérer l'id
	* Sortie : l'id du jeu
	*/
	public function recupIdJeu($nomJeu)
	{
		$requete = "SELECT " . ID_JEU . " FROM " . TABLE_NOM_JEU . " WHERE " . NOM_JEU . "='" . $nomJeu . "'";
		$laListe = $this->requeteSelect($requete);
		return $laListe[0][ID_JEU];
	}
	
    /**
	* Fonction de récupération du nom d'une version d'un jeu
	* Entrée : id du jeu pour lequel on souhaite récupérer le nom de la version
	* Sortie : le tableau contenant le nom
	*/
	public function recupNomVersion($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_VERSION;
		if($idJeu != null)
			$requete .= " WHERE " . ID_JEU . "='" . $idJeu . "'";
		$requete .= "ORDER BY " . NOM_VERSION . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération du nom d'une version d'un jeu
	* Entrée : id du jeu pour lequel on souhaite récupérer le nom de la version
	* Sortie : le tableau contenant le nom
	*/
	public function recupNameVersion($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_VERSION;
		if($idJeu != null)
			$requete .= " WHERE " . ID_VERSION . "='" . $idJeu . "'";
		$requete .= "ORDER BY " . NOM_VERSION . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération d'id d'une version d'un jeu
	* Entrée : nom de la version du jeu pour lequel on souhaite récupérer l'id
	* Sortie : l'id de la version
	*/
	public function recupIdVersion($nomVersion)
	{
		$requete = "SELECT " . ID_VERSION . " FROM " . TABLE_VERSION . " WHERE " . NOM_VERSION . "='" . $nomVersion . "'";
		$laListe = $this->requeteSelect($requete);
		return $laListe[0][ID_VERSION];
	}
	
    /**
	* Fonction de récupération de la liste des pays ou un pays en particulier si on lui passe en paramètre l'id d'un pays
	* Entrée : id d'un pays pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupPays($idPays)
	{
		$requete = "SELECT * FROM " . TABLE_PAYS;
		if($idPays != null)
			$requete .= " WHERE " . ID_PAYS . " = '" . $idPays . "'";
		$requete .= " ORDER BY " . NOM_PAYS . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des illustrateurs ou un illustrateur en particulier si on lui passe en paramètre l'id d'un illustrateur
	* Entrée : id de l'illustrateur pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les illustrateurs
	*/
	public function recupIllustrateur($idIllustrateur)
	{
		$requete = "SELECT * FROM " . TABLE_ILLUSTRATEUR;
		if($idPays != null)
			$requete .= " WHERE " . ID_ILLUSTRATEUR . " = '" . $idIllustrateur . "'";
		$requete .= " ORDER BY " . NOM_ILLUSTRATEUR . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des distributeurs ou un distributeur en particulier si on lui passe en paramètre l'id d'un illustrateur
	* Entrée : id du distributeur pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les illustrateurs
	*/
	public function recupDistributeur($idDistributeur)
	{
		$requete = "SELECT * FROM " . TABLE_DISTRIBUTEUR;
		if($idPays != null)
			$requete .= " WHERE " . ID_DISTRIBUTEUR . " = '" . $idDistributeur . "'";
		$requete .= " ORDER BY " . NOM_DISTRIBUTEUR . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des illustrateurs ou un illustrateurs en particulier si on lui passe en paramètre l'id d'un illustrateur
	* Entrée : id de l'illustrateur pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les illustrateurs
	*/
	public function recupEditeur($idEditeur)
	{
		$requete = "SELECT * FROM " . TABLE_EDITEUR;
		if($idPays != null)
			$requete .= " WHERE " . ID_EDITEUR . " = '" . $idEditeur . "'";
		$requete .= " ORDER BY " . NOM_EDITEUR . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des langues des régles pour un exemplaire en particulier si on lui passe en paramètre l'id d'un pays
	* Entrée : id de l'exemplaire pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupReglesLangues($idExemplaire)
	{
		$requete = "SELECT * FROM " . TABLE_LANGUE_REGLE;
		if($idExemplaire != null)
			$requete .= " WHERE " . ID_EXEMPLAIRE . " = '" . $idExemplaire . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des exemplaire ou d'un exemplaire en particulier si on lui passe en paramètre l'id d'un pays
	* Entrée : id de l'exemplaire pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les exemplaires
	*/
	public function recupExemplaire($idExemplaire)
	{
		$requete = "SELECT * FROM " . TABLE_EXEMPLAIRE;
		if($idExemplaire != null)
			$requete .= " WHERE " . ID_EXEMPLAIRE . " = '" . $idExemplaire . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération des catégories d'un jeu
	* Entrée : id du jeu pour lequel on souhaite récupérer les auteurs
	* Sortie : le tableau contenant les auteurs utilisées pour un jeu
	*/
	public function recupAuteurJeu($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_AUTEUR_JEU;
		$requete .= " WHERE " . ID_JEU . " = '" . $idJeu . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération des catégories d'un jeu
	* Entrée : id du jeu pour lequel on souhaite récupérer les catégories
	* Sortie : le tableau contenant les catégories utilisées pour un jeu
	*/
	public function recupCategorieJeu($idJeu)
	{
		$requete = "SELECT * FROM " . TABLE_CATEGORIE_JEU;
		$requete .= " WHERE " . ID_JEU . " = '" . $idJeu . "';";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction des catégories
	* Entrée : id de la catégorie pour laquelle on souhaite avoir le informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupCategorie($idCategorie)
	{
		$requete = "SELECT * FROM " . TABLE_CATEGORIE;
		if($idCategorie != null)
			$requete .= " WHERE " . ID_CATEGORIE . " = '" . $idCategorie . "';";
		$requete .= " ORDER BY " . NOM_CATEGORIE;
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
	/**
	* Fonction de récupération de la liste des lieux
	* Sortie : le tableau contenant les lieux
	*/
	public function recupLieux()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_LIEU);
		return $laListe;
	}
	
	/**
	* Fonction de récupération de la liste des auteurs
	* Sortie : le tableau contenant les auteurs
	*/
	public function recupAuteur($id)
	{
		$requete = "SELECT * FROM " . TABLE_AUTEUR;
		if($id != null)
			$requete .= " WHERE " . ID_AUTEUR . " = '" . $id . "'";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
	}
	
    /**
	* Fonction de récupération de la liste des catégories disponibles
	* Sortie : le tableau contenant les catégories
	*/
	public function recupEtatExemplaire()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_ETAT_EXEMPLAIRE);
		return $laListe;
	}
	
	/**
	* Fonction qui met à jour les informations d'un jeu
	* Entrée : id du jeu à mettre à jour
	* Entrée : nouvelle description du jeu
	* Entrée : nouvel auter du jeu
	* Entrée : id du nouveau pays
	* Sortir : booleen pour savoir si la requête à bien était effectuée
	*/
	public function UpdateTableJeu($unJeu, $uneDescription, $unPays)
	{
		if(intval($unJeu))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			

			// Création de la requete
			$requete = $this->maBase->prepare("UPDATE " . TABLE_JEUX . " SET " . DESCRIPTION_JEU . "=?, " . ID_PAYS . "=? WHERE " . ID_JEU . "=?;");
			$requete->bindValue(1, $uneDescription, PDO::PARAM_STR);
			$requete->bindValue(2, $unPays, PDO::PARAM_INT);
			$requete->bindValue(3, $unJeu, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	
	/**
	* Fonction qui met à jour les informations d'une version
	* Entrée : nouveau attributs à modifier
	* Sortir : booleen pour savoir si la requête à bien était effectuée
	*/
	public function UpdateTableVersion($idVersion,$nom,$description,$age_min,$nb_joueur,$nb_joueur_reco,$duree_partie,$prix_achat,$annee_sortie,$idJeu)
	{
		if(intval($idVersion))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();			
						
			
			// Création de la requete
			$requete = $this->maBase->prepare("UPDATE " . TABLE_VERSION . " SET " . NOM_VERSION . "=?, " . DESCRIPTION_VERSION . "=?, " . AGE_MINIMUM . "=?,
			" . NB_JOUEUR . "=?, " . NB_JOUEUR_RECOMMANDE . "=?, " . DUREE_PARTIE . "=?, " . PRIX_ACHAT . "=?, " . ANNEE_SORTIE . "=?, " . ID_JEU . "=?	WHERE " . ID_VERSION . "=?;");
			
			$requete->bindValue(1, $nom, PDO::PARAM_STR);
			
			//description	
			if(strcmp($description, "") == 0)
				$requete->bindValue(2, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(2, $description, PDO::PARAM_STR);

			//age min
			if(strcmp($age_min, "") == 0)
				$requete->bindValue(3, null, PDO::PARAM_NULL);
			else
			$requete->bindValue(3, $age_min, PDO::PARAM_INT);
			
			//nombre de joueurs recommandés
			if(strcmp($nb_joueur, "") == 0)
				$requete->bindValue(4, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(4, $nb_joueur, PDO::PARAM_INT);
			
			//nombre de joueurs recommandés
			if(strcmp($nb_joueur_reco, "") == 0)
				$requete->bindValue(5, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(5, $nb_joueur_reco, PDO::PARAM_INT);
				
			//durée partie
			if(strcmp($duree_partie, "") == 0)
				$requete->bindValue(6, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(6, $duree_partie, PDO::PARAM_INT);	

			//prix achat
			if($prix_achat == 0)
				$requete->bindValue(7, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(7, $prix_achat, PDO::PARAM_INT);	

			//année de sortie
			if(strcmp($annee_sortie, "") == 0)
				$requete->bindValue(8, null, PDO::PARAM_NULL);
			else
				$requete->bindValue(8, $annee_sortie, PDO::PARAM_INT);
		

			$requete->bindValue(9, $idJeu, PDO::PARAM_INT);
			$requete->bindValue(10, $idVersion, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction qui met à jour les informations d'un exemplaire
	* Entrée : id de l'exemplaire à mettre à jour
	* Entrée : nouvelle description du jeu
	* Entrée : nouvel auter du jeu
	* Entrée : id du nouveau pays
	* Sortir : booleen pour savoir si la requête à bien était effectuée
	*/
	public function UpdateTableExemplaire($unExemplaire, $unCodeBarre, $uneDescription, $unPrixMDJT, $unDateAchat, $uneDateFinVie, $unEtat, $unLieuReel, $unLieuTempo)
	{
		if(intval($unExemplaire))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("UPDATE " . TABLE_EXEMPLAIRE . " SET " . CODE_BARRE . "=?, " . DESCRIPTION_EXEMPLAIRE . "=?, " . PRIX_MDJT . "=?, " . DATE_ACHAT . "=?, " . DATE_FIN_VIE . "=?, " . ID_LIEU_REEL . "=?, " . ID_ETAT_EXEMPLAIRE . "=?, " . ID_LIEU_TEMPO . "=? WHERE " . ID_EXEMPLAIRE . "=?;");
			$requete->bindValue(1, $unCodeBarre, PDO::PARAM_STR);
			$requete->bindValue(2, $uneDescription, PDO::PARAM_STR);
			$requete->bindValue(3, $unPrixMDJT, PDO::PARAM_INT);
			$requete->bindValue(4, $unDateAchat, PDO::PARAM_STR);
			$requete->bindValue(5, $uneDateFinVie, PDO::PARAM_STR);
			$requete->bindValue(6, $unEtat, PDO::PARAM_INT);
			$requete->bindValue(7, $unLieuReel, PDO::PARAM_INT);
			$requete->bindValue(8, $unLieuTempo, PDO::PARAM_INT);
			$requete->bindValue(9, $unExemplaire, PDO::PARAM_INT);
			$resultat = $requete->execute();
			
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des langues d'un jeu
	* Entrée : id du jeu pour lequel on supprime les nom du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableNomJeu($unJeu)
	{
		if(intval($unJeu))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_NOM_JEU . " WHERE " . ID_JEU . "=?;");
			$requete->bindValue(1, $unJeu, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des auteurs d'un jeu
	* Entrée : id du jeu pour lequel on supprime les auteurs du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableAuteurJeu($unJeu)
	{
		if(intval($unJeu))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_AUTEUR_JEU . " WHERE " . ID_JEU . "=?;");
			$requete->bindValue(1, $unJeu, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des langues d'un jeu
	* Entrée : id du jeu pour lequel on supprime les nom du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableLanguesRegles($unExemplaire)
	{
		if(intval($unExemplaire))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_LANGUE_REGLE . " WHERE " . ID_EXEMPLAIRE . "=?;");
			$requete->bindValue(1, $unExemplaire, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des catégories d'un jeu
	* Entrée : id du jeu pour lequel on supprime les catégories du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableCategorieJeu($unJeu)
	{
		if(intval($unJeu))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_CATEGORIE_JEU . " WHERE " . ID_JEU . "=?;");
			$requete->bindValue(1, $unJeu, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des éditeurs d'une version
	* Entrée : id de la version pour laquelle on supprime les éditeurs du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableEditeurVersion($uneVersion)
	{
		if(intval($uneVersion))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_EDITEUR_VERSION . " WHERE " . ID_VERSION . "=?;");
			$requete->bindValue(1, $uneVersion, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des distributeurs d'une version
	* Entrée : id de la version pour laquelle on supprime les distributeurs du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableDistributeurVersion($uneVersion)
	{
		if(intval($uneVersion))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_DISTRIBUTEUR_VERSION . " WHERE " . ID_VERSION . "=?;");
			$requete->bindValue(1, $uneVersion, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	/**
	* Fonction de suppression des illustrateurs d'une version
	* Entrée : id de la version pour laquelle on supprime les illustrateurs du jeu
	* Sortie : booleen pour savoir si la requête à bien était effectuée
	*/
	public function DeleteTableIllustrateurVersion($uneVersion)
	{
		if(intval($uneVersion))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("DELETE FROM " . TABLE_ILLUSTRATEUR_VERSION . " WHERE " . ID_VERSION . "=?;");
			$requete->bindValue(1, $uneVersion, PDO::PARAM_INT);
			$resultat = $requete->execute();
	
			// On termine l'utilisation de la requete
			$requete->closeCursor();
			
			return $resultat;
		}
		else
			return false;
	}
	
	

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagNomJeu($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_JEU . " FROM " . TABLE_NOM_JEU . " WHERE " . NOM_JEU . " LIKE '" . $chaine . "%' " );
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagNomVersion($chaine, $idJeu){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_VERSION . " FROM " . TABLE_VERSION . " WHERE " . NOM_VERSION . " LIKE '" . $chaine . "%' AND " . ID_JEU . " =  '" . $idJeu . "'");
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagCategorie($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_CATEGORIE . " FROM " . TABLE_CATEGORIE . " WHERE " . NOM_CATEGORIE . " LIKE '" . $chaine . "%' " );
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagEditeur($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_EDITEUR . " FROM " . TABLE_EDITEUR . " WHERE " . NOM_EDITEUR . " LIKE '" . $chaine . "%' " );
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagDistributeur($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_DISTRIBUTEUR . " FROM " . TABLE_DISTRIBUTEUR . " WHERE " . NOM_DISTRIBUTEUR . " LIKE '" . $chaine . "%' " );
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagIllustrateur($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_ILLUSTRATEUR . " FROM " . TABLE_ILLUSTRATEUR . " WHERE " . NOM_ILLUSTRATEUR . " LIKE '" . $chaine . "%' " );
	}

	/**
	 * Fonction récupérant les catégories commençant par une chaine de caractère
	 * @param string
	 * @return string
	 */

	public function tagAuteur($chaine){
		$chaine=mysql_real_escape_string($chaine);
		return $this->requeteSelect("SELECT DISTINCT " . NOM_AUTEUR . " FROM " . TABLE_AUTEUR . " WHERE " . NOM_AUTEUR . " LIKE '" . $chaine . "%' " );
	}
        
        /**
         * Fonction permettant de convertir les données stockées en base vers les données réelles
         * notamment en supprimant les caractères d'échappement.
         * @param type $uneVariable 
         */
        public function conversionDepuisBase($uneVariable)
        {
            return stripslashes($uneVariable);
        }


	/**
	 * Fonction récupérant toutes les langues
	 * @return array
	 */

	public function listeLangue(){
		return $this->requeteSelect("SELECT * FROM " . TABLE_LANGUE );
	}

	/**
	 * Fonction récupérant tous les états
	 * @return array
	 */

	public function listeEtat(){
		return $this->requeteSelect("SELECT * FROM " . TABLE_ETAT_EXEMPLAIRE);
	}

	/**
	 * Fonction récupérant tous les lieux
	 * @return array
	 */

	public function listeLieu(){
		return $this->requeteSelect("SELECT * FROM " . TABLE_LIEU);
	}

	/**

	 * Fonction récupérant tous les auteurs

	 * @return array

	 */



	public function listeAuteur(){

		return $this->requeteSelect("SELECT *  FROM " .  TABLE_JEUX);

	}

	/**
	 * Fonction récupérant tous les illustrateurs
	 * @return array
	 */


	public function listeIllustrateur(){

		return $this->requeteSelect("SELECT * FROM " .  TABLE_ILLUSTRATEUR);

	}

	/**

	 * Fonction récupérant tous les distributeurs

	 * @return array

	 */



	public function listeDistributeur(){

		return $this->requeteSelect("SELECT * FROM " .  TABLE_DISTRIBUTEUR);

	}



	/**
	 * Fonction de recherche
	 * @param array $critere Tableau contenant les critères de recherche. Les paramètres sont indexés par un nom identique à ceux du formulaire.
	 * @return array
	 */
	public function rechercheVersion($critere){
		/*
		 Afin de simplifier la construction de la requète,
		nous utiliserons la classe RequeteSQL car c'est assez complexe

		Voir les commentaires dans RequeteSQL pour les méthodes!
		Voir en haut de ce fichier pour les defines.
		Je recommande fortement un IDE.
		*/

		$query=new RequeteSQL();

		$query->setRequete("SELECT " .
				TABLE_PHOTO . "." . NOM_PHOTO .", ".
				TABLE_PHOTO . "." . TEXTE_ALTERNATIF .", ".
				TABLE_VERSION . "." . ID_VERSION .", ".
				TABLE_VERSION . "." . NOM_VERSION .", ".
				TABLE_NOM_JEU . "." . NOM_JEU . ", " .
				TABLE_EXEMPLAIRE . "." .  ID_ETAT_EXEMPLAIRE .
				" , COUNT(" . TABLE_EXEMPLAIRE . "." . ID_EXEMPLAIRE . ") AS nbExemplaire");

		//pour le moment je garde les X de Jeu tant qu'on a pas la nouvelle BDD corrigé
		//Voir les commentaires dans RequeteSQL pour les méthodes

		//On joint les 6 tables nécessaires pour le SELECT DE BASE
		$query->jointureLeft(TABLE_JEUX, ID_JEU, TABLE_VERSION, ID_JEU);

		$query->jointureLeft(TABLE_VERSION,ID_VERSION,TABLE_PHOTO_VERSION,ID_VERSION);

		$query->jointureLeft(TABLE_PHOTO_VERSION,ID_PHOTO,TABLE_PHOTO,ID_PHOTO);

		$query->jointureLeft(TABLE_EXEMPLAIRE,ID_VERSION,TABLE_VERSION,ID_VERSION);
		$query->jointure(TABLE_ETAT_EXEMPLAIRE, ID_ETAT_EXEMPLAIRE, TABLE_EXEMPLAIRE, ID_ETAT_EXEMPLAIRE);
		$query->jointure(TABLE_NOM_JEU,ID_JEU,TABLE_JEUX,ID_JEU);

		$query->setExtra("GROUP BY ". TABLE_VERSION . "." . ID_VERSION . "," . TABLE_EXEMPLAIRE .".". ID_ETAT_EXEMPLAIRE );

		// Création dynamique de la requète maintenant

		//Par nom. On regarde aussi bien le nom du jeu que le nom de la version.
		if($critere[NOM]!=""){
			//comme il y a des LIKE, j'ai pas fait de méthode particulière encore
			$critere[NOM]=mysql_real_escape_string($critere[NOM]);
			$string="AND ( " . TABLE_NOM_JEU . "." . NOM_JEU . " LIKE '%" .$critere[NOM]."%' OR " . TABLE_VERSION . "." . NOM_VERSION . " LIKE '%" .$critere[NOM]. "%')";
			$query->ajoutWhereLibre($string);
		}

		//Par langue. On regarde seulement la langue de la version ( pour le moment )
		if(is_numeric($critere["idLangue"])){
			$query->ajoutAnd("=",TABLE_VERSION, ID_LANGUE, $critere["idLangue"]);
		}

		// Par Etat
		if(is_numeric($critere["idEtatExemplaire"])){
			$query->ajoutAnd("=",TABLE_EXEMPLAIRE, ID_ETAT_EXEMPLAIRE, $critere["idEtatExemplaire"]);
		}

		// Par Lieux
		if(is_numeric($critere["idLieu"])){
			$query->ajoutAnd("=",TABLE_EXEMPLAIRE, ID_LIEU_REEL, $critere["idLieu"]);
			$string="AND (( " . TABLE_EXEMPLAIRE . "." . ID_LIEU_REEL   . "=" .$critere["idLieu"].
			" AND " . TABLE_EXEMPLAIRE . "." . ID_LIEU_TEMPO   ."= 0) OR  "
			. TABLE_EXEMPLAIRE . " . " . ID_LIEU_TEMPO   . "=" .$critere["idLieu"].")";
			$query->ajoutWhereLibre($string);
		}

		// Par Durée
		if(is_numeric($critere["DureeJeu"])){
			$critere["DureeJeu"]=$critere["DureeJeu"]*60;
			$critere["DureeJeu"]=$this->formatTime($critere["DureeJeu"]);
			if($critere["dureeSigne"]==SUPERIEUR){
				$query->ajoutAnd(">",TABLE_VERSION, DUREE_PARTIE, $critere["DureeJeu"]);
			}
			if($critere["dureeSigne"]==INFERIEUR   ){
				$query->ajoutAnd("<",TABLE_VERSION, DUREE_PARTIE, $critere["DureeJeu"]);
			}
			if($critere["dureeSigne"]==EGAL){
				$query->ajoutAnd("=",TABLE_VERSION, DUREE_PARTIE, $critere["DureeJeu"]);
			}
		}


		// Par Nombre De Joueur


		if($critere[j1]=="on"){
			$nbjoueur = " AND ( " . NB_JOUEUR . " LIKE '%1%' " ;
		}

		if($critere[j2]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%2%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%2%' ";
			}
		}

		if($critere[j3]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%3%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%3%' ";
			}
		}

		if($critere[j4]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%4%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%4%' ";
			}
		}

		if($critere[j5]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%5%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%5%' ";
			}
		}


		if($critere[j6]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%6%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%6%' ";
			}
		}

		if($critere[j7]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%7%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%7%' ";
			}
		}

		if($critere[j8]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%8%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%8%' ";
			}
		}

		if($critere[j9]=="on"){
			if($nbjoueur!=""||$nbjoueur!=NULL){
				$nbjoueur.=" OR " . NB_JOUEUR . " LIKE '%+%' ";
			}
			else {
				$nbjoueur=" AND ( " . NB_JOUEUR . " LIKE '%+%' ";
			}
		}

		if($nbjoueur!=NULL){
			$nbjoueur.=" ) ";
			$query->ajoutWhereLibre($nbjoueur);
		}



		// Par Prix MDJT Min et Max

		// Min
		if(is_numeric($critere["prixMin"]))
		{
			$string = "AND " . TABLE_EXEMPLAIRE . "." . PRIX_MDJT   ." > " .$critere["prixMin"] ;
			$query->ajoutWhereLibre($string);
		}

		// Max

		if(is_numeric($critere["prixMax"]))
		{
			$string = "AND " . TABLE_EXEMPLAIRE . "." . PRIX_MDJT   ."<" .$critere["prixMax"];
			$query->ajoutWhereLibre($string);
		}



		//Par Auteur

		if($critere["nomAuteur"]!=""){
			//sans tag
			//$critere["auteur"]=mysql_real_escape_string($critere["auteur"]);
			//$string="AND ( " . TABLE_JEUX. "." . AUTEUR   ." LIKE '%" .$critere["auteur"]."%')";
			//$query->ajoutWhereLibre($string);
			$query->jointure(TABLE_AUTEUR,ID_AUTEUR,TABLE_AUTEUR_JEU,ID_AUTEUR);

			$query->jointure(TABLE_AUTEUR_JEU,ID_JEU,TABLE_JEUX,ID_JEU);

			$string = explode("," , $critere["nomAuteur"]);

			foreach($string as $value ){

				$query->ajoutAndLike(TABLE_AUTEUR,NOM_AUTEUR,$value);

			}
		}

		// Par illustrateur

		if($critere["nomIllustrateur"]!=""){
			//sans tag
			//$query->ajoutAnd("=", TABLE_VERSION, ID_ILLUSTRATEUR, $critere["illustrateur"]);

			$query->jointure(TABLE_ILLUSTRATEUR,ID_ILLUSTRATEUR,TABLE_ILLUSTRATEUR_VERSION,ID_ILLUSTRATEUR);

			$query->jointure(TABLE_ILLUSTRATEUR_VERSION,ID_VERSION,TABLE_VERSION,ID_VERSION);

			$string = explode("," , $critere["illustrateur"]);

			foreach($string as $value ){

				$query->ajoutAndLike(TABLE_ILLUSTRATEUR,NOM_ILLUSTRATEUR,$value);

			}
		}

		//Par distributeur

		if($critere["nomDistributeur"]!=""){

			//$query->ajoutAnd("=", TABLE_VERSION, ID_DISTRIBUTEUR, $critere["distributeur"]);

			$query->jointure(TABLE_DISTRIBUTEUR,ID_DISTRIBUTEUR,TABLE_DISTRIBUTEUR_VERSION,ID_DISTRIBUTEUR);

			$query->jointure(TABLE_DISTRIBUTEUR_VERSION,ID_VERSION,TABLE_VERSION,ID_VERSION);

			$string = explode("," , $critere["distributeur"]);

			foreach($string as $value ){

				$query->ajoutAndLike(TABLE_DISTRIBUTEUR,NOM_DISTRIBUTEUR,$value);

			}

		}

		// Par Année

		if(is_numeric($critere["anneeSortie"])){
			$query->ajoutAnd("=",TABLE_VERSION, ANNEE_SORTIE, $critere["anneeSortie"]);
		}




		//Par Catégorie



		if($critere["nomCategorie"]!=""){
			$query->jointure(TABLE_CATEGORIE,ID_CATEGORIE,TABLE_CATEGORIE_JEU,ID_CATEGORIE);

			$query->jointure(TABLE_CATEGORIE_JEU,ID_JEU,TABLE_JEUX,ID_JEU);

			$string = explode("," , $critere["categorie"]);

			foreach($string as $value ){

				$query->ajoutAndLike(TABLE_CATEGORIE,NOM_CATEGORIE,$value);

			}
		}

		//ainsi de suite!

		//$query->debug();
		$result=$this->requeteSelect($query->compile());

		return $result;
	}

	/**
	 * Fonction de convertion des secondes en time
	 * @param int le temps en seconde
	 * @return string format time HH:MM:SS
	 */

	public function formatTime($secs) {

		$times = array(3600, 60, 1);

		$time = '';

		$tmp = '';

		for($i = 0; $i < 3; $i++) {

			$tmp = floor($secs / $times[$i]);

			if($tmp < 1) {

				$tmp = '00';

			}

			elseif($tmp < 10) {

				$tmp = '0' . $tmp;

			}

			$time .= $tmp;

			if($i < 2) {

				$time .= ':';

			}

			$secs = $secs % $times[$i];

		}

		return $time;

	}
	
	
	// Réquêtes fiche de jeu
	
	
	
	/**
	* Fonction de récupération des informations d'un jeu
	* Entrée : l'id de la version
	* Sortie : le tableau correspondant à cette version
	* Si le jeu n'existe pas en base, renvoi false
	*/
	public function recupInfoJeu($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les info de 
			// la version et le jeu associés à l'idJeu 
			$requete = 			"SELECT v.".ID_JEU.",".DESCRIPTION_JEU.",".ID_PAYS.","
											.NOM_VERSION.",".DESCRIPTION_VERSION.",".AGE_MINIMUM.","
											.NB_JOUEUR_RECOMMANDE.",".DUREE_PARTIE.",".PRIX_ACHAT.","
											.ANNEE_SORTIE."
								FROM ".TABLE_JEUX." j , ".TABLE_VERSION." v
								WHERE ".ID_VERSION." = ".$uneID . "
								AND v.".ID_JEU." = j.".ID_JEU."
								";

			// Execution 
			$monJeu = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeu) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeu[0];
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	* Fonction de récupération du nom du jeu
	* Entrée : l'id du jeu
	* Sortie : le(s) nom(s) du jeu
	* Si le jeu n'existe pas en base, renvoi false
	*/
	public function recupJeuLangue($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
			$requete = 	"SELECT ".NOM_JEU."
						FROM ".TABLE_NOM_JEU." j 
						WHERE ".ID_JEU." = ".$uneID . " ";

			// Execution 
			$monJeuLangue = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuLangue) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuLangue;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Fonction de récupération des auteurs du jeu
	* Entrée : l'id du jeu
	* Sortie : le(s) nom(s) des auteurs
	* Si les auteurs n'existe pas en base, renvoi false
	*/
	public function recupAuteurs($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
			$requete = 	"SELECT ".NOM_AUTEUR."
						FROM ".TABLE_AUTEUR_JEU." aj , ".TABLE_AUTEUR." a
						WHERE ".ID_JEU." = ".$uneID . "
						AND aj.".ID_AUTEUR." = a.".ID_AUTEUR."";

			// Execution 
			$monJeuAuteur = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuAuteur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuAuteur;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Fonction de récupération des catégorie du jeu
	* Entrée : l'id du jeu
	* Sortie : le(s) nom(s) des catégorie
	* Si les catégorie n'existe pas en base, renvoi false
	*/
	public function recupCategorieJeuVersion($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{
			$requete = 	"SELECT ".NOM_CATEGORIE."
						FROM ".TABLE_CATEGORIE_JEU." aj , ".TABLE_CATEGORIE." a
						WHERE ".ID_JEU." = ".$uneID . "
						AND aj.".ID_CATEGORIE." = a.".ID_CATEGORIE."";

			// Execution 
			$monJeuAuteur = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuAuteur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuAuteur;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Fonction de récupération des illustrateurs du jeu
	* Entrée : l'id de la version
	* Sortie : le(s) nom(s) des illustrateurs
	* Si les illustrateurs n'existent pas en base, renvoi false
	*/
	public function recupIllustrateurs($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
			$requete = 	"SELECT ".NOM_ILLUSTRATEUR."
						FROM ".TABLE_ILLUSTRATEUR_VERSION." iv , ".TABLE_ILLUSTRATEUR." i
						WHERE ".ID_VERSION." = ".$uneID . "
						AND iv.".ID_ILLUSTRATEUR." = i.".ID_ILLUSTRATEUR."";

			// Execution 
			$monJeuIllustrateur = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuIllustrateur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuIllustrateur;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Fonction de récupération des distributeurs du jeu
	* Entrée : l'id de la version
	* Sortie : le(s) nom(s) des distributeurs
	* Si les distributeurs n'existent pas en base, renvoi false
	*/
	public function recupDistributeurs($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
			$requete = 	"SELECT ".NOM_DISTRIBUTEUR."
						FROM ".TABLE_DISTRIBUTEUR_VERSION." iv , ".TABLE_DISTRIBUTEUR." i
						WHERE ".ID_VERSION." = ".$uneID . "
						AND iv.".ID_DISTRIBUTEUR." = i.".ID_DISTRIBUTEUR."";

			// Execution 
			$monJeuDistributeur = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuDistributeur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuDistributeur;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	* Fonction de récupération des editeurs du jeu
	* Entrée : l'id de la version
	* Sortie : le(s) nom(s) des editeurs
	* Si les editeurs n'existent pas en base, renvoi false
	*/
	public function recupEditeurs($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
			$requete = 	"SELECT ".NOM_EDITEUR."
						FROM ".TABLE_EDITEUR_VERSION." iv , ".TABLE_EDITEUR." i
						WHERE ".ID_VERSION." = ".$uneID . "
						AND iv.".ID_EDITEUR." = i.".ID_EDITEUR."";

			// Execution 
			$monJeuEditeur = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($monJeuEditeur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monJeuEditeur;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/**
	* Fonction de récupération de la photo de la version
	* Entrée : l'id de la version
	* Sortie : le chemin de l'image (type "image.xxx")
	*/
	public function recupPhotoVersion($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer la photo associée a la version du jeu
			$requete = 	"SELECT ".NOM_PHOTO."
						FROM ".TABLE_PHOTO." p ,".TABLE_PHOTO_VERSION." pv, ".TABLE_VERSION." v 
						WHERE v.".ID_VERSION." = ".$uneID."
						AND	v.".ID_VERSION."=pv.".ID_VERSION."
						AND	pv.".ID_PHOTO."=p.".ID_PHOTO."" ;

			// Execution 
			$maPhotoVersion = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($maPhotoVersion) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $maPhotoVersion;
			}
		}
		else
		{
			return false;
		}
	}

        
    /**
	* Fonction de mise à jour des informations d'un utilisateur
	* Entrée : l'id de cet utilisateur et toutes les informations associées
	* Sortie : true si la mise à jour s'est bien passée, sinon false
	*/
	public function miseAJourInfoUtilisateur($uneID,$unTitre,$unNom,$unPrenom,$unEmail,$actif,$uneAdresse,$unCodePostal,$unTelephone,$unPortable,$dateDeNaissance,$uneProfession,$dateAdhesion,$dateCotisation,$exemptCotisation,$commentaires)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{
                    // On initie la connexion à la base, si ce n'est déjà fait
                    $this->connecteBase();
                    // Création de la requete
                    $requete = $this->maBase->prepare("UPDATE " .
				TABLE_UTILISATEURS .
				" SET " .
                                TITRE .
                                "=?," .
                                NOM .
                                "=?," .
                                PRENOM .
                                "=?," .
                                EMAIL .
                                "=?," .
                                ACTIF .
                                "=?," .
                                ADRESSE .
                                "=?," .
                                TELEPHONE .
                                "=?," .
                                PORTABLE .
                                "=?," .
                                DATE_NAISSANCE .
                                "=?," .
                                PROFESSION .
                                "=?," .
                                DATE_ADHESION .
                                "=?," .
                                DATE_COTISATION .
                                "=?," .
                                EXEMPT_COTISATION .
                                "=?," .
                                COMMENTAIRES .
                                "=? WHERE " .
                                ID_UTILISATEUR .
                                "=?;");
                    $requete->bindValue(1, $unTitre, PDO::PARAM_STR);
                    $requete->bindValue(2, $unNom, PDO::PARAM_STR);
                    $requete->bindValue(3, $unPrenom, PDO::PARAM_STR);
                    $requete->bindValue(4, $unEmail, PDO::PARAM_STR);
                    $requete->bindValue(5, $actif, PDO::PARAM_BOOL);
                    $requete->bindValue(6, $uneAdresse, PDO::PARAM_STR);
                    $requete->bindValue(7, $unTelephone, PDO::PARAM_STR);
                    $requete->bindValue(8, $unPortable, PDO::PARAM_STR);
                    $requete->bindValue(9, $dateDeNaissance, PDO::PARAM_STR);
                    $requete->bindValue(10, $uneProfession, PDO::PARAM_STR);
                    $requete->bindValue(11, $dateAdhesion, PDO::PARAM_STR);
                    $requete->bindValue(12, $dateCotisation, PDO::PARAM_STR);
                    $requete->bindValue(13, $exemptCotisation, PDO::PARAM_BOOL);
                    $requete->bindValue(14, $commentaires, PDO::PARAM_STR);
                    $requete->bindValue(15, $uneID, PDO::PARAM_INT);
                    $resultat = $requete->execute();

                    // On termine l'utilisation de la requete
                    $requete->closeCursor();
		}
		else
		{
			return false;
		}
	}
        
        
	/**
	* Fonction de récupération de la liste des types d'adhérents disponibles
	* Sortie : le tableau contenant cette liste
	*/
	public function recupTypesAdherent()
	{
		$laListe = $this->requeteSelect(
			"SELECT " .
			TYPE_ADHERENT .
			" FROM " .
			TABLE_TYPE_ADHERENT
			);
		return $laListe;
	}
	
	/**
     * Fonction d'affichage du formulaire de modification des groupes d'un utilisateur
     */
    public function afficheFormulaireUtilisateur()
    {
        // Récupération de l'id et du nom du groupe depuis POST
        $tableau = explode("ø", $_POST["utilisateur"]);
        $idUtilisateur = $tableau[0];
        $prenom = $tableau[1];
        $nom = $tableau[2];
        
        // On affiche le contenu du formulaire	
        $this->ouvreBloc("<form method='post' action='" .
		MODULE_GROUPES . "'>");
        
        // On affiche la liste des groupes
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend> " .
            $this->convertiTexte("Modifier les groupes de " . $prenom . " " . $nom) .
            "</legend>");		
        $this->ouvreBloc("<ol>");
        // Afficher les groupes
        
        // On récupère la liste des groupes de l'utilisateur
        $listeGroupes = $this->maBase->recupGroupesUtilisateurAvecID($idUtilisateur);
        
        // On affiche la liste des groupes
        foreach ($this->maBase->recupGroupes() as $unGroupe) 
        {
            $this->ouvreBloc("<li>");
            $this->ajouteLigne("<label for='" . $unGroupe[ID_GROUPE] . "'>" .
			$this->convertiTexte($unGroupe[NOM_GROUPE] ) .
	  		"</label>");
            // Si l'utilisateur fait partie de la liste des Utilisateur du groupe
            if (in_array($unGroupe, $listeGroupes))
            {
                // On le coche
                $this->ajouteLigne("<input type='checkbox' name='" . $unGroupe[ID_GROUPE] . "' checked='checked'/></p>");
            }
            else
            {
                // On ne le coche pas
                $this->ajouteLigne("<input type='checkbox' name='" . $unGroupe[ID_GROUPE] . "' /></p>");
            }	
            $this->fermeBloc("</li>");
        }
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<input type='hidden' name='idUtilisateur' value='" . $idUtilisateur . "' />");
        $this->ajouteLigne("<button type='submit' name='modifierUtilisateur'>Modifier les groupes</button>");
        $this->fermeBloc("</fieldset>");
        $this->fermeBloc("</form>");   
    }

		
		
	/**
	* Fonction de récupération des exemplaires
	* Entrée : l'id de la version
	* Sortie : le(s) exemplaires(s) du jeu
	* Si le jeu n'existe pas en base, renvoi false
	*/
	public function recupExemplaireJeu($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{			
			// construction de la requete SQL permettant de recuperer les langues associées au jeu
				
			$requete = 	"SELECT ".DESCRIPTION_EXEMPLAIRE.",".PRIX_MDJT.",".DATE_ACHAT.",".DATE_FIN_VIE.",".NOM_LIEU."
						FROM ".TABLE_EXEMPLAIRE." ex, ".TABLE_LIEU." l
						WHERE ex.".ID_VERSION." = ".$uneID . "
						AND  ex.".ID_LIEU_REEL." = l.".ID_LIEU."
						 
						AND ex.".ID_EXEMPLAIRE." NOT IN ( SELECT ".ID_EXEMPLAIRE."
															FROM ".TABLE_EMPRUNT."
															WHERE now() NOT BETWEEN ".DATE_EMPRUNT." AND ".DATE_RETOUR_SOUHAITE." 
															);
						";
			//AND ".DATE_FIN_VIE." = '0000-00-00'			
			// Execution 
			$mesExemplaires = $this->requeteSelect($requete);
			
			// Si l'utilisateur n'existe pas dans la base
			if (count($mesExemplaires) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $mesExemplaires;
			}
		}
		else
		{
			return false;
		}
	}

}

?>
