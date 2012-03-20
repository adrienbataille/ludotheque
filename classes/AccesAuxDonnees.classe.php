<?php
/**
* Classe de gestion de l'accès à la base de donnée
*
*/

// Inclusions

//Constantes - paramètre du système
define("SERVEUR","localhost");
define("LOGIN","ludotheque");
define("MDP","ludo");
define("BASE","mdjtufjjpdoc");
define("TABLE_PREFIX","MDJT_");

// Constantes - Definition des Tables SQL
define("TABLE_UTILISATEURS", TABLE_PREFIX . "UTILISATEURS");
define("TABLE_VILLES", TABLE_PREFIX . "VILLES");
define("TABLE_TYPE_ADHERENT", TABLE_PREFIX . "TYPE_ADHERENT");
define("TABLE_GROUPES", TABLE_PREFIX . "GROUPES");
define("TABLE_LIEN_UTILISATEURS_GROUPES", TABLE_PREFIX . "LIEN_UTILISATEURS_GROUPES");

// Définition des champs de la table TABLE_UTILISATEURS
define("ID_UTILISATEUR", "idUtilisateur");
define("TITRE", "titre");
define("NOM", "nom");
define("PRENOM", "prenom");
define("EMAIL", "email");
define("ACTIF", "actif");
define("ADRESSE", "adresse");
define("TELEPHONE", "telephone");
define("PORTABLE", "portable");
define("DATE_NAISSANCE", "dateNaissance");
define("PROFESSION", "profession");
define("DATE_ADHESION", "dateAdhesion");
define("DATE_COTISATION", "dateCotisation");
define("EXEMPT_COTISATION", "exemptCotisation");
define("COMMENTAIRES", "commentaires");
// Définition des tailles des champs
define("TAILLE_CHAMPS_TELEPHONE",20);
define("TAILLE_CHAMPS_COURT",50);
define("TAILLE_CHAMPS_LONG",255);

// Définition des champs de la table TABLE_VILLES
define("ID_VILLE", "idVille");
define("VILLE", "nomVille");
define("CODEPOSTAL", "codePostal");

// Définition des champs de la table TABLE_TYPE_ADHERENT
define("ID_TYPE_ADHERENT", "idTypeAdherent");
define("TYPE_ADHERENT", "typeAdherent");

// Définition des champs de la table TABLE_GROUPES
define("ID_GROUPE", "idGroupe");
define("NOM_GROUPE", "nomGroupe");



class AccesAuxDonnees
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
			self::$connexionBase = new AccesAuxDonnees();
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
                    $this->maBase = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE, LOGIN, MDP,$option);
                    // Connexion normale
                    // $this->maBase = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE, LOGIN, MDP);
                } 
                catch (PDOException $e)
                {
                        // Accès à la base impossible
                        print "Connexion a la base de donnee impossible <br/>";
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
	* Fonction de récupération des informations d'un utilisateur
	* Entrée : l'id de cet utilisateur
	* Sortie : le tableau correspondant à cet utilisateur
	* Si l'utilisateur n'existe pas en base, renvoi false
	*/
	public function recupInfoUtilisateur($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{
			// construction de la requete SQL
			$requete = "SELECT * FROM " .
				TABLE_UTILISATEURS .
				" NATURAL JOIN " .
				TABLE_VILLES .
				" NATURAL JOIN " .
				TABLE_TYPE_ADHERENT .
				" WHERE " .
                                ID_UTILISATEUR .
                                "= '" .
				$uneID . "'";
			// Execution 
			$monUtilisateur = $this->requeteSelect($requete);
				
			// Si l'utilisateur n'existe pas dans la base
			if (count($monUtilisateur) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie juste la ligne le concernant
				// Il ne doit pas exister 2 utilisateurs de même id 
				// donc le tableau fait toujours 1 ligne
				return $monUtilisateur[0];
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	* Fonction de récupération des groupes d'un utilisateur
	* Entrée : l'id de cet utilisateur
	* Sortie : le tableau des groupes auxquels l'utilisateur appartient
	* Si l'utilisateur n'existe pas en base, renvoi false
	*/
	public function recupGroupesUtilisateur($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{
			// construction de la requete SQL
			$requete = "SELECT " .
                                NOM_GROUPE .
                                " FROM " .
				TABLE_GROUPES .
				" NATURAL JOIN " .
				TABLE_LIEN_UTILISATEURS_GROUPES .
				" NATURAL JOIN " .
				TABLE_UTILISATEURS .
				" WHERE " .
                                ID_UTILISATEUR .
                                "= '" .
				$uneID . "'";
			// Execution 
			$mesGroupes = $this->requeteSelect($requete);
				
			// Si l'utilisateur n'existe pas dans la base
			if (count($mesGroupes) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie le tableau des groupes auxquels il appartient
				return $mesGroupes;
			}
		}
		else
		{
			return false;
		}
	}

        
	/**
	* Fonction de récupération des groupes d'un utilisateur Nom et ID
	* Entrée : l'id de cet utilisateur
	* Sortie : le tableau des groupes auxquels l'utilisateur appartient
	* Si l'utilisateur n'existe pas en base, renvoi false
	*/
	public function recupGroupesUtilisateurAvecID($uneID)
	{
		// Protection contre injection SQL
		if ( intval($uneID) )
		{
			// construction de la requete SQL
			$requete = "SELECT " .
                              ID_GROUPE .
                                ", " .
                                NOM_GROUPE .
                                " FROM " .
				TABLE_GROUPES .
				" NATURAL JOIN " .
				TABLE_LIEN_UTILISATEURS_GROUPES .
				" NATURAL JOIN " .
				TABLE_UTILISATEURS .
				" WHERE " .
                                ID_UTILISATEUR .
                                "= '" .
				$uneID . "'";
			// Execution 
			$mesGroupes = $this->requeteSelect($requete);
				
			// Si l'utilisateur n'existe pas dans la base
			if (count($mesGroupes) == 0)
			{
				return false;
			}
			else // L'utilisateur existe dans la base
			{
				// On renvoie le tableau des groupes auxquels il appartient
				return $mesGroupes;
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
	* Fonction de récupération de la liste des utilisateurs
	* Sortie : le tableau contenant cette liste
	*/
	public function recupUtilisateurs()
	{
		$laListe = $this->requeteSelect(
			"SELECT " .
			ID_UTILISATEUR .
                        ", " .
                        NOM .
                        ", " .
                        PRENOM .
			" FROM " .
			TABLE_UTILISATEURS
			);
		return $laListe;
	}
        
        /**
	* Fonction de récupération de la liste des groupes
	* Sortie : le tableau contenant cette liste
	*/
	public function recupGroupes()
	{
		$laListe = $this->requeteSelect(
			"SELECT " .
			ID_GROUPE .
                        ", " .
                        NOM_GROUPE .
			" FROM " .
			TABLE_GROUPES
			);
		return $laListe;
	}
        
        /**
	* Fonction de récupération de la liste des utilisateurs d'un groupe
	* Sortie : le tableau contenant cette liste
	*/
	public function recupUtilisateursDansUnGroupe($unGroupe)
	{
            // Protection contre injection SQL
            if ( intval($unGroupe) )
            {
		$laListe = $this->requeteSelect(
			"SELECT " .
			ID_UTILISATEUR .
                        ", " .
                        NOM .
                        ", " .
                        PRENOM .
                        " FROM " .
                        TABLE_LIEN_UTILISATEURS_GROUPES .
                        " NATURAL JOIN " .
                        TABLE_UTILISATEURS .
                        " WHERE " .
                        ID_GROUPE .
                        "= '" .
                        $unGroupe . "'"
			);
		return $laListe;
            }
            else
            {
                return false;
            }
	}
        
        /**
	* Fonction de récupération de la liste des villes et codes postaux associés
	* Sortie : le tableau contenant cette liste
	*/
	public function recupVillesEtCodePostaux()
	{
		$laListe = $this->requeteSelect(
			"SELECT " .
			ID_VILLE .
                        ", " .
                        VILLE .
                        ", " .
                        CODEPOSTAL .
			" FROM " .
			TABLE_VILLES
			);
		return $laListe;
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
