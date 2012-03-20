<?php
/**
* Classe de la session PHP et des paramètres d'un utilisateur
*
*/

// Inclusions
require_once("classes/AccesAuxDonnees.classe.php");
require_once("classes/AccesAuxDonneesDev.classe.php");

//Constantes
// Pour les variables de session PHP
define("MES_GROUPES", "mesGroupes");
// Liste des groupes disponibles
define("GROUPE_ADMINISTRATEUR", "Administrateurs");

class SessionUtilisateur
{

// Attributs
	// accès aux données (Base de donnée)
	private $baseDonnees = NULL;
	// Attributs issus de la session phpbb3
	private $idPhpbb3 = NULL; // l'id 1 est celui de l'utilisateur anonyme (deconnecté)
	private $idSessionPhpbb3 = NULL;
	private $login = NULL;
	private $estConnecte= NULL;
	// Attributs propre au site MDJT
	// ==> Ces informations se trouvent dans la session PHP


// Méthodes

	/**
	* Constructeur
	*/
	public function __construct()
	{		
		// Demarrage de la session PHP, permet la récupération des variables de session   
		session_start();
		
		// On regarde si l'utilisateur est connecté sur le forum
		// Si il est connecté sur le forum
		if ( $this->recupInfoPhpbb() )
		{
			// On vérifie si l'utilisateur est déjà connecté
			if ($_SESSION["estConnecte"])
			{
				// Il est déjà connecté
				$this->estConnecte = true;
			}
			else
			{
				// Il n'est pas déjà connecté
				// Si on sais déjà que c'est un utilisateur du forum qui n'existe pas sur le site
				if ($_SESSION["forumOnly"])
				{
					// Il n'est pas connecté
					$this->estConnecte = false;
				}
				else
				{
					// On ne sait pas, on fait une requete sur la base
					$this->initUtilisateur();
				}
			}
		}
		// Si il n'est pas connecté sur le forum
		else
		{
			// On détruit la session, pour gérer les deconnexions
			// Les deconnexions consistant uniquement à se déconnecter du forum
			$this->detruireSession();
			$this->estConnecte = false;
		}
	}
  
	/**
	* Le destructeur
	*/
	public function __destruct()
	{
	  		
	}
	
	//
	// Outils internes
	//	
  
   /**
   * Cette fonction permet d'aller récupérer les informations de connexion
   * depuis phpbb
   * Elle renvoie true si l'utilisateur est connecté sur le forum
   * false sinon
   * Si l'utilisateur est connecté sur le forum : elle initialise les attributs :
   * idPhpbb3
   * login
   * idSessionPhpbb3
   */
	private function recupInfoPhpbb()
	{
		// Utilisation des sessions phpbb3
		global $phpbb_root_path, $phpEx, $user, $db, $config, $cache, $template;      
		define('IN_PHPBB', true);
		$phpbb_root_path = 'forum/';
		$phpEx = substr(strrchr(__FILE__, '.'), 1);
		include($phpbb_root_path . 'common.' . $phpEx);
		$user->session_begin();
		if ($user->data['is_registered'])
		{
			// Initialisation des variables de l'utilisateur à partir de la session phpbb3
			$this->idPhpbb3 = $user->data['user_id'];
			$this->login = $user->data['username'];
			$this->idSessionPhpbb3 = $user->data['session_id'];
			return true;
		}
		else
		{
			return false;
		}
	}   
   
	/**
	* Fonction d'initialisation d'un utilisateur
	* Cette fonction vérifie que l'utilisateur est valide pour le site
	* Elle range les paramètres d'un utilisateur dans la session
	* Permet la jonction entre les utilisateurs Forum uniquement 
	* et ceux déclaré sur le site 
	*/
	private function initUtilisateur()
	{
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->baseDonnees = AccesAuxDonnees::recupAccesDonnees();
		// On récupère les informations liée à l'id de l'utilisateur
		// dans la base
		$this->informationsUtilisateur = $this->baseDonnees->recupInfoUtilisateur($this->idPhpbb3);
				
		// Si notre utilisateur existe dans la base MDJT
		if ($this->informationsUtilisateur != false)
		{
			// On connecte l'utilisateur
			$_SESSION["estConnecte"] = true;
			$this->estConnecte = true;
			// On initialise la session avec les paramètres de l'utilisateur
			foreach($this->informationsUtilisateur as $variable => $valeur)
			{
				// Pour toutes les cases avec un nom
				// on élimine les cases indicées par des entiers
				if(!is_int($variable))
				{
                                    $_SESSION[$variable]=$this->baseDonnees->conversionDepuisBase($valeur);
				}
			}
                        // On récupère la liste des groupes auxquels il appartient
                        $listeGroupes = $this->baseDonnees->recupGroupesUtilisateur($this->idPhpbb3);
                        // On nettoie le tableau des groupes
			foreach($listeGroupes as $valeur)
			{
                            $tableauGroupes[]=$valeur[0];
			}
                        // On stocke le tableau dans la session
                        $_SESSION[MES_GROUPES]=$tableauGroupes;
                        
		}
		// Sinon, c'est un utilisateur déclaré uniquement sur le forum
		else
		{
			// Ce n'est pas un utilisateur du site
			$this->estConnecte = false;
			// On le note dans la session
			$_SESSION["forumOnly"] = true;
		}
	}
	
	/**
	* Fonction de destruction de la session
	* Réinitialise la session php
	*/
	private function detruireSession()
	{
		// On détruit toute la session
		foreach ($_SESSION as $variable => $valeur)
		{
			unset($_SESSION[$variable]);
		}	
	}
  

	//
	// Méthodes publiques
	//
	  
	/**
	* Fonction indiquant si l'utilisateur est connecté
	*/
	public function estConnecte()
	{
	 	return $this->estConnecte;
	}
		
	/**
	* Fonction indiquant si l'utilisateur est un utilisateur connecté sur le forum
	* Et inexistant sur le site
	*/
	public function estForumOnly()
	{
		if (isset($_SESSION["forumOnly"]))
		{
			return $_SESSION["forumOnly"];
		}
		else
		{
			return false;
		}
	}
  
	/**
	* Fonction permettant la récupération du login d'un utilisateur
	*/ 
	public function recupLogin()
	{
		 return $this->login;
	}
  
	/**
	* Fonction permettant la récupération d'identificateur de session phpbb3
	*/ 
	public function recupSessionIdPhpbb3()
	{
		 return $this->idSessionPhpbb3;
	}
  
	/**
	* Fonction permettant la récupération de l'identifiant de l'utilisateur
	* issu de phpBB
	* Utilisé comme id dans la base du site
	*/
	public function recupID()
	{
		return $this->idPhpbb3;
	}
	
	/**
	* Fonction de récupération du titre de l'utilisateur
	* Depuis la session php
	*/
	public function recupTitre()
	{
		return $_SESSION[TITRE];
	}
	
	/**
	* Fonction de modification du titre de l'utilisateur
	*/
	public function changeTitre($nouveauTitre)
	{
		$_SESSION[TITRE] = $nouveauTitre;	
	}
	
	/**
	* Fonction de récupération du prénom
	* Depuis la session php
	*/
	public function recupPrenom()
	{
		return $_SESSION[PRENOM];
	}

         /**
         * Fonction de changement du prenom
         */
        public function changePrenom($unPrenom)
        {
            $_SESSION[PRENOM]=$unPrenom;
        }
	
	/**
	* Fonction de récupération du nom
	* Depuis la session php
	*/
	public function recupNom()
	{
		return $_SESSION[NOM];
	}

        /**
         * Fonction de changement du nom
         */
        public function changeNom($unNom)
        {
            $_SESSION[NOM]=$unNom;
        }
	
	/**
	* Fonction de récupération de l'email
	* Depuis la session php
	*/
	public function recupEmail()
	{
		return $_SESSION[EMAIL];
	}

         /**
         * Fonction de changement de l'adresse mail
         */
        public function changeEmail($unMail)
        {
            $_SESSION[EMAIL]=$unMail;
        }

	/**
	* Fonction de récupération du statut actif
	* Depuis la session php
	*/
	public function recupActif()
	{
		return $_SESSION[ACTIF];
	}	

	/**
	* Fonction de récupération de l'adresse
	* Depuis la session php
	*/
	public function recupAdresse()
	{
		return $_SESSION[ADRESSE];
	}

         /**
         * Fonction de changement de l'adresse
         */
        public function changeAdresse($uneAdresse)
        {
            $_SESSION[ADRESSE]=$uneAdresse;
        }
	
	/**
	* Fonction de récupération du code postal
	* Depuis la session php
	*/
	public function recupCodePostal()
	{
		return $_SESSION[CODEPOSTAL];
	}

         /**
         * Fonction de changement de code postal
         */
        public function changeCodePostal($unCode)
        {
            $_SESSION[CODEPOSTAL]=$unCode;
        }
	
	/**
	* Fonction de récupération de la ville
	* Depuis la session php
	*/
	public function recupVille()
	{
		return $_SESSION[VILLE];
	}

         /**
         * Fonction de changement de la ville
         */
        public function changeVille($uneVille)
        {
            $_SESSION[VILLE]=$uneVille;
        }
        
	/**
	* Fonction de récupération du numéro de téléphone fixe
	* Depuis la session php
	*/
	public function recupTelephoneFixe()
	{
		return $_SESSION[TELEPHONE];
	}

        /**
         * Fonction de changement de telephone fixe
         */
        public function changeTelephoneFixe($unNumero)
        {
            $_SESSION[TELEPHONE]=$unNumero;
        }
	
	/**
	* Fonction de récupération du numéro de téléphone portable
	* Depuis la session php
	*/
	public function recupTelephonePortable()
	{
		return $_SESSION[PORTABLE];
	}

        /**
         * Fonction de changement de telephone portable
         */
        public function changeTelephonePortable($unNumero)
        {
            $_SESSION[PORTABLE]=$unNumero;
        }
	
	/**
	* Fonction de récupération de la date de naissance
	* Depuis la session php
	*/
	public function recupDateNaissance()
	{
		return $_SESSION[DATE_NAISSANCE];
	}
        /**
         * Fonction de changement de la date de naissance
         */
        public function changeDateNaissance($uneDate)
        {
            $_SESSION[DATE_NAISSANCE]=$uneDate;
        }

	/**
	* Fonction de récupération de la profession
	* Depuis la session php
	*/
	public function recupProfession()
	{
		return $_SESSION[PROFESSION];
	}
        
        /**
         * Fonction de changement de la profession
         */
        public function changeProfession($uneProfession)
        {
            $_SESSION[PROFESSION]=$uneProfession;
        }
	
	/**
	* Fonction de récupération de la date de première cotisation
	* Depuis la session php
	*/
	public function recupDateCotisation()
	{
		return $_SESSION[DATE_COTISATION];
	}
	
	/**
	* Fonction de récupération de la date de première adhésion
	* Depuis la session php
	*/
	public function recupDateAdhesion()
	{
		return $_SESSION[DATE_ADHESION];
	}

	/**
	* Fonction de récupération du statut exempt de cotisation
	* Depuis la session php
	*/
	public function recupExemptCotisation()
	{
		return $_SESSION[EXEMPT_COTISATION];
	}		

	/**
	* Fonction de récupération du type d'adhérent
	* Depuis la session php
	*/
	public function recupTypeAdherent()
	{
		return $_SESSION[TYPE_ADHERENT];
	}
				
	/**
	* Fonction de récupération des commentaires
	* Depuis la session php
	*/
	public function recupCommentaires()
	{
		return $_SESSION[COMMENTAIRES];
	}
        
        /**
	* Fonction de récupération des groupes
	* Depuis la session php
	*/
	public function recupGroupes()
	{
		return $_SESSION[MES_GROUPES];
	}
        
	/**
	* Fonction de mise à jour de l'utilisateur dans la base
        * Cette fonction ecrit toutes les données stockées dans l'objet dans la base.
	*/
	public function mettreAJour()
	{
            // On a besoin d'un accès à la base - On utilise la fonction statique prévue
            $this->baseDonnees = AccesAuxDonnees::recupAccesDonnees();
            // On utilise la fonction de mise à jour prévue
            $this->baseDonnees->miseAJourInfoUtilisateur(
                    $this->idPhpbb3,
                    $this->recupTitre(),
                    $this->recupNom(),
                    $this->recupPrenom(),
                    $this->recupEmail(),
                    $this->recupActif(),
                    $this->recupAdresse(),
                    $this->recupCodePostal(),
                    $this->recupTelephoneFixe(),
                    $this->recupTelephonePortable(),
                    $this->recupDateNaissance(),
                    $this->recupProfession(),
                    $this->recupDateAdhesion(),
                    $this->recupDateCotisation(),
                    $this->recupExemptCotisation(),
                    $this->recupCommentaires());
	}
        
        //
        // Fonctions pour la gestion des droits
        //
        
        /**
         * L'utilisateur a-t-il accès à la page Groupes ?
         * Cet accès est offert par le groupe administrateur
         */
        public function accesGroupes()
        {
            return in_array(GROUPE_ADMINISTRATEUR, $this->recupGroupes());
        }
        
	
}


/* Contenu de $user->data (Récupération des infos de session phpbb) -- pour mémoire
	array(91) { 
	["user_id"]=> string(1) "1" 
	["user_type"]=> string(1) "2" 
	["group_id"]=> string(3) "318" 
	["user_permissions"]=> string(299) "00000000003khra3nk hre9z4000000 hre9z4000000 hre9z4000000 hrbf28000000 hrbf28000000 hre9z4000000 hrbf28000000 hrbf28000000 mh7dhc000000 mh7dhc000000 mh4ikg000000 mh7dhc000000 mh7dhc000000 hrctmo000000 qlc4pi000000 qlc4pi000000 qlc4pi000000 i1cjyo000000 i1cjyo000000 qlc4pi000000" 
	["user_perm_from"]=> string(1) "0" 
	["user_ip"]=> string(0) "" 
	["user_regdate"]=> string(10) "1263474127" 
	["username"]=> string(9) "Anonymous" 
	["username_clean"]=> string(9) "anonymous" 
	["user_password"]=> string(0) "" 
	["user_passchg"]=> string(1) "0" 
	["user_pass_convert"]=> string(1) "0" 
	["user_email"]=> string(0) "" 
	["user_email_hash"]=> string(1) "0" 
	["user_birthday"]=> string(0) "" 
	["user_lastvisit"]=> string(1) "0" 
	["user_lastmark"]=> string(1) "0" 
	["user_lastpost_time"]=> string(1) "0" 
	["user_lastpage"]=> string(0) "" 
	["user_last_confirm_key"]=> string(10) "2M7MZ5TVSQ" 
	["user_last_search"]=> string(10) "1277575343" 
	["user_warnings"]=> string(1) "0" 
	["user_last_warning"]=> string(1) "0" 
	["user_login_attempts"]=> string(1) "0" 
	["user_inactive_reason"]=> string(1) "0" 
	["user_inactive_time"]=> string(1) "0" 
	["user_posts"]=> string(1) "0" 
	["user_lang"]=> string(2) "en" 
	["user_timezone"]=> string(4) "0.00" 
	["user_dst"]=> string(1) "0" 
	["user_dateformat"]=> string(9) "d M Y H:i" 
	["user_style"]=> string(1) "2" 
	["user_rank"]=> string(1) "0" 
	["user_colour"]=> string(0) "" 
	["user_new_privmsg"]=> string(1) "0" 
	["user_unread_privmsg"]=> string(1) "0" 
	["user_last_privmsg"]=> string(1) "0" 
	["user_message_rules"]=> string(1) "0" 
	["user_full_folder"]=> string(2) "-3" 
	["user_emailtime"]=> string(1) "0" 
	["user_topic_show_days"]=> string(1) "0" 
	["user_topic_sortby_type"]=> string(1) "t" 
	["user_topic_sortby_dir"]=> string(1) "d" 
	["user_post_show_days"]=> string(1) "0" 
	["user_post_sortby_type"]=> string(1) "t" 
	["user_post_sortby_dir"]=> string(1) "a" 
	["user_notify"]=> string(1) "0" 
	["user_notify_pm"]=> string(1) "1" 
	["user_notify_type"]=> string(1) "0" 
	["user_allow_pm"]=> string(1) "1" 
	["user_allow_viewonline"]=> string(1) "1" 
	["user_allow_viewemail"]=> string(1) "1" 
	["user_allow_massemail"]=> string(1) "0" 
	["user_options"]=> string(6) "230271" 
	["user_avatar"]=> string(0) "" 
	["user_avatar_type"]=> string(1) "0" 
	["user_avatar_width"]=> string(1) "0" 
	["user_avatar_height"]=> string(1) "0" 
	["user_sig"]=> string(0) "" 
	["user_sig_bbcode_uid"]=> string(0) "" 
	["user_sig_bbcode_bitfield"]=> string(0) "" 
	["user_from"]=> string(0) "" 
	["user_icq"]=> string(0) "" 
	["user_aim"]=> string(0) "" 
	["user_yim"]=> string(0) "" 
	["user_msnm"]=> string(0) "" 
	["user_jabber"]=> string(0) "" 
	["user_website"]=> string(0) "" 
	["user_occ"]=> string(0) "" 
	["user_interests"]=> string(0) "" 
	["user_actkey"]=> string(0) "" 
	["user_newpasswd"]=> string(0) "" 
	["user_form_salt"]=> string(16) "988af9590a8cd57e" 
	["user_new"]=> string(1) "1" 
	["user_reminded"]=> string(1) "0" 
	["user_reminded_time"]=> string(1) "0" 
	["session_id"]=> string(32) "fe46bf3a4b0962b267be8ebe7914116b" 
	["session_user_id"]=> string(1) "1" 
	["session_forum_id"]=> string(1) "0" 
	["session_last_visit"]=> string(10) "1298298618" 
	["session_start"]=> string(10) "1298298618" 
	["session_time"]=> string(10) "1298299468" 
	["session_ip"]=> string(14) "193.52.208.233" 
	["session_browser"]=> string(100) "Mozilla/5.0 (X11; U; Linux i686; fr; rv:1.9.2.11) Gecko/20101013 Ubuntu/9.04 (jaunty) Firefox/3.6.11" 
	["session_forwarded_for"]=> string(0) "" 
	["session_page"]=> string(15) "../v2/index.php" 
	["session_viewonline"]=> string(1) "1" 
	["session_autologin"]=> string(1) "0" 
	["session_admin"]=> string(1) "0" 
	["is_registered"]=> bool(false) 
	["is_bot"]=> bool(false) } */

?>
