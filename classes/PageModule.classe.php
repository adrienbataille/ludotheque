<?php
/**
 * Cette classe permet de créer les pages web interne au format MDJT
 * Partie privée avec affichage des modules 
*/

// Inclusion des fichiers utiles
require_once("classes/Page.classe.php");
require_once("classes/ModuleProfil.classe.php");
require_once("classes/ModuleGroupes.classe.php");
require_once("classes/ModuleRecherche.classe.php");

// Constantes

class PageModule extends Page
{
// Attributs
        // Le module que la page va effectivement afficher
	private $unModule;

// Méthodes

	/**
	* Constructeur
	* Le constructeur initialise la construction d'une page, il crée notamment la session utilisateur et l'entête de la page
	*/
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		
		// Vérification des droits
		if (!$this->monUtilisateur->estConnecte())
		{
			// Si l'utilisateur n'est pas connecté
			header('Location:' . PAGE_INDEX);
			exit();
		}
		
		// On initialise le module utilisé
		$this->initModule();		
	}
	
	/**
	* Destructeur de la classe
	* Le destructeur termine la construction de la page et l'affiche
	*/
	public function __destruct()
	{
		// Utilisation du destructeur de la classe mère
		parent::__destruct();
	}
	
	//
	// Outils internes
	//
	
	/**
	* Fonction d'initialisation du module que va afficher la page
	*/
	private function initModule()
	{
		// Si on essaye d'acceder à un module particulier
		if (isset($_GET["idModule"]))
		{
			switch ($_GET["idModule"])
			{
				case "Profil" :
				// On créé l'objet chargé de gerer le module profil
				$this->unModule = new ModuleProfil($this->monUtilisateur);
				break;
				case "Groupes" :
				// On vérifie si l'utilisateur à accès à ce module
				if ($this->monUtilisateur->accesGroupes())
				{
					// Si oui, on l'affiche
					// On créé l'objet chargé de gerer le module Groupes
					$this->unModule = new ModuleGroupes($this->monUtilisateur);
				}
				else
				{
					// Si non, on redirige sur la page d'accueil du site
					header('Location:' . PAGE_INDEX);
					exit();
				}

				break;
				case "Recherche" :
				// On créé l'objet chargé de faire des recherches. Ceci est une page de test.
				$this->unModule = new ModuleRecherche();
				break;
			}
		}
		else
		{
			// On accède au module par défaut
			$this->unModule = new Module();
		}
	}
	
	
	//
	// Création du squelette d'une page
	//
	
	
	
	//
	// Remplissage du squelette d'une page
	//
	
	/**
	* Fonction d'affichage de la zone mini actu
	* 
	*/ 
	protected function afficheMiniActu()
	{
		$this->ouvreBloc("<p>");
		$this->ajouteLigne("Ceci est une miniActu (partie privée)");
		$this->fermeBloc("</p>");		
	}


	/**
	* Fonction d'affichage du menu
	* 
	*/ 	
	public function afficheMenuModule()
	{
		$this->ouvreBloc("<nav id=\"menuModules\">");
		$this->ouvreBloc("<ol>");
		$this->ajouteLigne("<li><a href=\"" . MODULE_PROFIL ."\">Mon profil</a></li>");
		$this->ajouteLigne("<li><a href=\"\">Utilisateurs</a></li>");
                // Si l'utilisateur à accès au module Groupes
                if ($this->monUtilisateur->accesGroupes())
                {
                    // On lui affiche le lien
                    $this->ajouteLigne("<li><a href=\"" . MODULE_GROUPES . "\">Groupes</a></li>");
                }
		$this->ajouteLigne("<li><a href=\"" . RACINE_SITE . "\">Retour Accueil</a></li>");	
		$this->ajouteLigne("<li><a href=\"" . MODULE_RECHERCHE . "\">Recherche</a></li>");
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</nav>");
	}


	/**
	* Fonction d'affichage du contenu du module
	*/
	public function afficheModule()
	{
		$this->ouvreBloc("<section id=\"contenuModule\">");
		$this->ajouteLigne($this->unModule->recupContenu());
		$this->fermeBloc("</section> <!-- Fermeture section#contenuModule -->");	
	}

}
?>