<?php
/**
* Classe de gestion de l'accès à la base de donnée
*
*/

// Inclusions
require_once("classes/AccesAuxDonnees.classe.php");

//Constantes - paramètre du système
define("BASE_DEV","mdjtufjjpdev");

// Constantes - Definition des Tables SQL
define("TABLE_CATEGORIE", TABLE_PREFIX . "CATEGORIE");
define("TABLE_CATEGORIE_JEUX", TABLE_PREFIX . "CATEGORIE_JEUX");
define("TABLE_EMPRUNT", TABLE_PREFIX . "EMPRUNT");
define("TABLE_ETAT_EXEMPLAIRE", TABLE_PREFIX . "ETAT_EXEMPLAIRE");
define("TABLE_EXEMPLAIRE", TABLE_PREFIX . "EXEMPLAIRE");
define("TABLE_EXTENSION", TABLE_PREFIX . "EXTENSION");
define("TABLE_FAIRE_PARTIE_KIT", TABLE_PREFIX . "FAIRE_PARTIE_KIT");
define("TABLE_INVENTAIRE", TABLE_PREFIX . "INVENTAIRE");
define("TABLE_JEUX", TABLE_PREFIX . "JEUX");
define("TABLE_KIT_JEUX", TABLE_PREFIX . "KIT_JEUX");
define("TABLE_LANGUE", TABLE_PREFIX . "LANGUE");
define("TABLE_LANGUE_REGLE", TABLE_PREFIX . "LANGUE_REGLE");
define("TABLE_LIEU", TABLE_PREFIX . "LIEU");
define("TABLE_NB_JOUEUR", TABLE_PREFIX . "NB_JOUEUR");
define("TABLE_NB_JOUEUR_VERSION_JEU", TABLE_PREFIX . "NB_JOUEUR_VERSION_JEU");
define("TABLE_NOM_JEU", TABLE_PREFIX . "NOM_JEU");
define("TABLE_NOTE_VERSION", TABLE_PREFIX . "NOTE_VERSION");
define("TABLE_PAYS", TABLE_PREFIX . "PAYS");
define("TABLE_PHOTO", TABLE_PREFIX . "PHOTO");
define("TABLE_PHOTO_VERSION", TABLE_PREFIX . "PHOTO_VERSION");
define("TABLE_RESERVATION", TABLE_PREFIX . "RESERVATION");
define("TABLE_SUGGESTION", TABLE_PREFIX . "SUGGESTION");
define("TABLE_VERSION", TABLE_PREFIX . "VERSION");

// Définition des champs de la table TABLE_CATEGORIE
define("ID_CATEGORIE", "idCategorie");
define("NOM_CATEGORIE", "nomCategorie");
define("DESCRIPTION_CATEGORIE", "descriptionCategorie");

// Définition des champs de la table TABLE_CATEGORIE_JEU
define("ID_CATEGORIE_JEU", "idCategorieJeu");

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
define("DESCRIPTION_EXEMPLAIRE", "descriptionExemplaire");
define("PRIX_MDJT", "prixMJDT");
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

// Définition des champs de la table TABLE_NB_JOUEUR
define("ID_NB_JOUEUR", "idNbJoueur");
define("NB_JOUEUR", "nbJoueur");

// Définition des champs de la table TABLE_NB_JOUEUR_VERSION_JEU
define("ID_NB_JOUEUR_VERSION_JEU", "idNbJoueurJeu");

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
define("NB_JOUEUR_RECOMMANDE", "nbJoueurRecommande");
define("DUREE_PARTIE", "dureePartie");
define("PRIX_ACHAT", "prixAchat");
define("ANNEE_SORTIE", "anneeSortie");
define("ILLUSTRATEUR", "illustrateur");
define("DISTRIBUTEUR", "distributeur");
define("EDITEUR", "editeur");




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
	public static function recupAccesDonnees()
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
                    $option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                    $this->maBase = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE_DEV, LOGIN, MDP,$option);
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
    public function InsertionTableJeu($uneDescription, $unAuteur, $unPays)
    {
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_JEUX . " (" . DESCRIPTION_JEU . ", " . AUTEUR . ", " . ID_PAYS . ") VALUES(?, ?, ?) ;");
		
		if(strcmp($uneDescription, "") == 0)
			$requete->bindValue(1, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(1, $uneDescription, PDO::PARAM_STR);
			
		if(strcmp($unAuteur, "") == 0)
			$requete->bindValue(2, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(2, $unAuteur, PDO::PARAM_STR);
			
		if($unPays != 0)
			$requete->bindValue(3, $unPays, PDO::PARAM_INT);
		else
			$requete->bindValue(3, null, PDO::PARAM_NULL);
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id du Jeu inséré
		$requete = $this->maBase->prepare("SELECT ? FROM ? WHERE ?='?' AND ?='?' AND ?='?'");
		$requete->bindValue(1, ID_JEU, PDO::PARAM_INT);
		$requete->bindValue(2, TABLE_JEUX, PDO::PARAM_STR);
		$requete->bindValue(3, ID_PAYS, PDO::PARAM_STR);
		$requete->bindValue(4, $unPays, PDO::PARAM_STR);
		$requete->bindValue(5, AUTEUR, PDO::PARAM_STR);
		$requete->bindValue(6, $unAuteur, PDO::PARAM_STR);
		$requete->bindValue(5, DESCRIPTION_JEU, PDO::PARAM_STR);
		$requete->bindValue(6, $uneDescription, PDO::PARAM_STR);
		
		$requete = "SELECT " . ID_JEU . " FROM " . TABLE_JEUX . " WHERE " . ID_PAYS . "='" . $unPays . "' AND " . AUTEUR . " = '". $unAuteur . "';";
		
		$resultat = $this->requeteSelect($requete);
		
		if(count($resultat) == 0)
			return false;
		else
			return $resultat[0][ID_JEU];
    }

	/**
    * Fonction d'insertion d'une version
    * Entrée : nom, description, age_min, nb_joueur, nb_joueur recommandés, prix achat, année sortie, illustrateur, distributeur, éditeur
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableVersion($nom,$description,$age_min,$nb_joueur_reco,$duree_partie,$prix_achat,$annee_sortie,
											$illustrateur,$distributeur,$editeur,$idJeu)
    {
		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_VERSION . " (" . NOM_VERSION . ", " . DESCRIPTION_VERSION . ", " . AGE_MINIMUM . 
										", " . NB_JOUEUR_RECOMMANDE ."," . DUREE_PARTIE ."," . PRIX_ACHAT . ",". ANNEE_SORTIE ."," . ILLUSTRATEUR .
										"," . DISTRIBUTEUR . "," .EDITEUR . "," . ID_JEU .") VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ;");	

	
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
		/*if(strcmp($nb_joueur, "") == 0)
			$requete->bindValue(4, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(4, $nb_joueur, PDO::PARAM_INT);*/
			
		
		//nombre de joueurs recommandés
		if(strcmp($nb_joueur_reco, "") == 0)
			$requete->bindValue(4, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(4, $nb_joueur_reco, PDO::PARAM_INT);

		//durée partie
		if(strcmp($duree_partie, "") == 0)
			$requete->bindValue(5, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(5, $duree_partie, PDO::PARAM_INT);	

		//prix achat
		$requete->bindValue(6, $prix_achat, PDO::PARAM_INT);	

		//année de sortie
		if(strcmp($annee_sortie, "") == 0)
			$requete->bindValue(7, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(7, $annee_sortie, PDO::PARAM_INT);	

		//illustrateur
		if(strcmp($illustrateur, "") == 0)
			$requete->bindValue(8, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(8, $illustrateur, PDO::PARAM_STR);	


		//distributeur
		if(strcmp($distributeur, "") == 0)
			$requete->bindValue(9, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(9, $distributeur, PDO::PARAM_STR);

		//éditeur
		$requete->bindValue(10, $editeur, PDO::PARAM_STR);
		
		//id jeu associé
		$requete->bindValue(11, $idJeu, PDO::PARAM_INT);
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
    }

	/**
    * Fonction d'insertion d'un exemplaire
    * Entrée : la description, prix achat, date achat
    * Sortie : true si l'insertion s'est bien passée, sinon false
    */
    public function InsertionTableExemplaire($uneDescription, $unPrix, $uneDateAchat, $uneDateFinVie, $uneVersion, $unEtatExemplaire, $unLieuReel, $unLieuTempo)
    {

		// On initie la connexion à la base, si ce n'est déjà fait
		$this->connecteBase();
		// Création de la requete
		$requete = $this->maBase->prepare("INSERT INTO " . TABLE_EXEMPLAIRE . " (" . DESCRIPTION_EXEMPLAIRE . ", " . PRIX_MDJT . ", " . DATE_ACHAT . ", " . DATE_FIN_VIE . ", " . ID_VERSION . ", " . ID_ETAT_EXEMPLAIRE . ", " . ID_LIEU_REEL . ", " . ID_LIEU_TEMPO . ") VALUES(?, ?, ?, ?, ?, ?, ?, ?) ;");
		
		if(strcmp($uneDescription, "") == 0)
			$requete->bindValue(1, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(1, $uneDescription, PDO::PARAM_STR);
		
		$requete->bindValue(2, $unPrix, PDO::PARAM_STR);
		$requete->bindValue(3, $uneDateAchat, PDO::PARAM_STR);
		
		if(strcmp($uneDateFinVie, "") == 0)
			$requete->bindValue(4, null, PDO::PARAM_NULL);
		else
			$requete->bindValue(4, $uneDateFinVie, PDO::PARAM_STR);
		
		$requete->bindValue(5, $uneVersion, PDO::PARAM_INT);
		$requete->bindValue(6, $unEtatExemplaire, PDO::PARAM_INT);
		$requete->bindValue(7, $unLieuReel, PDO::PARAM_INT);
		$requete->bindValue(8, $unLieuTempo, PDO::PARAM_INT);
			
			
		$resultat = $requete->execute();

		// On termine l'utilisation de la requete
		$requete->closeCursor();
		
		// Création de la requete pour récupérer l'id du Jeu inséré
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
	* Fonction de récupération de la liste des catégories disponibles
	* Sortie : le tableau contenant les catégories
	*/
	public function recupLangue()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_LANGUE);
		return $laListe;
	}
	
	/**
	* Fonction de récupération de la liste des catégories disponibles
	* Sortie : le tableau contenant les catégories
	*/
	public function recupCategorie()
	{
		$laListe = $this->requeteSelect("SELECT * FROM " . TABLE_CATEGORIE);
		return $laListe;
	}
	
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
		$requete = "SELECT * FROM " . TABLE_LANGUE . " l JOIN " . TABLE_NOM_JEU . " n";
		$requete .= " ON (l." . ID_LANGUE . "=n." . ID_LANGUE . ")";
		if($idJeu != null)
			$requete .= " WHERE " . ID_JEU . "='" . $idJeu . "'";
		$requete .= "ORDER BY " . NOM_JEU . ";";
		$laListe = $this->requeteSelect($requete);
		return $laListe;
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
	* Fonction de récupération de la liste des pays ou un pays en particulier si on lui passe en paramètre l'id d'un pays
	* Entrée : id d'un pays pour lequel on veut récupérer des informations (paramètre optionnel)
	* Sortie : le tableau contenant les catégories
	*/
	public function recupPays($idPays)
	{
		$requete = "SELECT * FROM " . TABLE_PAYS;
		if($idPays != null)
			$requete .= " WHERE " . ID_PAYS . " = '" . $idPays . "';";
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
	public function UpdateTableJeu($unJeu, $uneDescription, $unAuteur, $unPays)
	{
		if(intval($unJeu))
		{
			// On initie la connexion à la base, si ce n'est déjà fait
			$this->connecteBase();
			
			// Création de la requete
			$requete = $this->maBase->prepare("UPDATE " . TABLE_JEUX . " SET " . DESCRIPTION_JEU . "=?, " . AUTEUR . "=?, " . ID_PAYS . "=? WHERE " . ID_JEU . "=?;");
			$requete->bindValue(1, $uneDescription, PDO::PARAM_STR);
			$requete->bindValue(2, $unAuteur, PDO::PARAM_STR);
			$requete->bindValue(3, $unPays, PDO::PARAM_INT);
			$requete->bindValue(4, $unJeu, PDO::PARAM_INT);
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
         * Fonction permettant de convertir les données stockées en base vers les données réelles
         * notamment en supprimant les caractères d'échappement.
         * @param type $uneVariable 
         */
        public function conversionDepuisBase($uneVariable)
        {
            return stripslashes($uneVariable);
        }

}

?>
