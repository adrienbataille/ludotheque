<?php
/**
* Cette classe permet de créer des pages web au format MDJT
*/

// Inclusion des fichiers utiles
require_once("classes/AccesAuxDonnees.classe.php");
require_once("classes/SessionUtilisateur.classe.php");
require_once("classes/AccesAuxDonneesDev.classe.php");

// Constante de définition des URL
define("RACINE_SITE", ""); // Racine originale du site http://www.mdjt.org/v2/
define("CSS_MDJT", "css/mdjt.css");
define("CSS_RESET", "css/reset.css");
define("PAGE_MODULE", RACINE_SITE . "module.php");
define("PAGE_INDEX", RACINE_SITE . "index.php");
define("PAGE_MENTIONS", RACINE_SITE . "mentions.php");
define("PAGE_CONTACT", RACINE_SITE . "contact.php");
define("PAGE_CONNEXION", RACINE_SITE . "connexion.php");
define("FORUM", RACINE_SITE . "../forum/");
define("IMAGES", RACINE_SITE . "images/");
define("DECONNEXION", RACINE_SITE . "deconnexion.php");

// Constantes pour le lien avec PHPBB
// Constante permettant la redirection depuis PHPBB, pour les login
// Elle doit être l'emplacement du fichier module.php en relatif depuis l'emplacement du forum
define ("REDIRECTION_PHPBB", "../module.php");
// Page de PHPBB interceptant le formulaire de connexion
define ("PAGE_LOGIN_PHPBB", "forum/ucp.php?mode=login");
// Test à supprimer define ("PAGE_LOGOUT_PHPBB", "http://mdjt.org/forum/ucp.php?mode=logout");

// Constante - nombre d'espace d'indentation
define("TABULATION", "  ");

// Constantes liées au style

abstract class Page
{
// Attributs
	// La chaine de caractères qui contient la page HTML qu'on génère
	protected $contenuHTML;
	// Un entier qui garde mémoire du niveau actuel, pour une identation propre
	private $niveauIndentation;
	// Objet utilisateur, qui gère la session et les paramètres individuels
	protected $monUtilisateur;
	// Indice, pour faire un cycle entre les éléments de listes colorés
	protected $indexStyleMenu;
	

// Méthodes


	/**
	 * Constructeur
	 * Le constructeur initialise la construction d'une page, il crée notamment la session utilisateur et l'entête de la page
         * @param cssAdditionnels : tableau contenant la liste des fichiers css supplémentaires qu'on souhaite inclure
	*/
	public function __construct($cssAdditionnels=NULL)
	{
		// On commence par vérifier l'existence de la session
		$this->monUtilisateur = new SessionUtilisateur();
		
		// Le niveau d'indentation d'une page neuve est 0
		$this->niveauIndentation = 0;
		
		// On crée l'entête de la page
		// La balise body est ouverte, le remplissage de la page peut commencer
		$this->ouvrePage($cssAdditionnels);
		
		// On ajoute le haut de page standard
		$this->ajouteHautPage();		
	}
	
	/**
	* Destructeur de la classe
	* Le destructeur termine la construction de la page et l'affiche
	*/
	public function __destruct()
	{
		// Ajout du pied de page standard
		$this->ajouteBasPage();
		// Fermeture du body
		$this->fermePage();
		
		// Affichage de la page
		echo $this->contenuHTML;
	}
	
	//
	// Outils internes
	//
	
	/**
	* Fonction d'indentation du code HTML en fonction du niveau courant
	* Renvoie les espaces nécessaires à indenter
	*/
	private function indente()
	{
		$espace = "";
		for ($i=0; $i<$this->niveauCourant; $i++)
		{
			$espace .= TABULATION;
		}
		return $espace;			
	}
	
	/**
	* Fonction d'ouverture d'un bloc HTML
	*/
	protected function ouvreBloc($HTML)
	{
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $HTML;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";
		// Augmentation du niveau d'indentation courant
		$this->niveauCourant = $this->niveauCourant + 1;
	}
	
	/**
	* Fonction de fermeture d'un bloc HTML
	*/
	protected function fermeBloc($html)
	{
		// Diminution du niveau d'indentation courant
		$this->niveauCourant = $this->niveauCourant - 1;
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $html;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";	
	}

	/**
	* Fonction d'ajout de balise dans un bloc
	*/
	protected function ajouteLigne($html)
	{
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $html;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";
	}
	
	/**
	* Fonction de conversion texte -> HTML
	* Renvoie le texte au format HTML
	*/
	protected function convertiTexte($texte)
	{
		return htmlentities($texte, ENT_NOQUOTES, "UTF-8");
	}
	
	/**
	* Fonction d'ajout d'un élément de menu
	* Permet le cyle des couleurs dans les éléments de menus
	* @parameter : $cible : l'URL vers laquelle pointe l'élément de menu
	* @parameter : $texte : le texte qu'affiche l'élément 
	*/
	protected function ajouteElementMenu($cible, $texte)
	{
		switch ($this->indexStyleMenu)
		{
			case 1 :
			{
				$style = "puceJaune";
				$this->indexStyleMenu = 2;
				break;
			}
			case 2 :
			{
				$style = "puceVert";
				$this->indexStyleMenu = 3;
				break;
			}
			case 3 :
			{
				$style = "puceBleu";
				$this->indexStyleMenu = 4;
				break;
			}
			default :
			{
				$style = "puceGris";
				$this->indexStyleMenu = 1;
				break;
			}
		}		
		$this->ajouteLigne("<li><a href=\"" . 
			$cible .
			"\" class=\"" .
			$style .
			"\">" .
			$this->convertiTexte($texte) .
			"</a></li>");
	}
	
	/**
	* Fonction ajoutant le menu connexion (afficher en bas de page)
	* propose la connexion à un utilisateur non connecté
	* ou d'aller sur la partie privé à un utilisateur connecté
	*/
	protected function ajouteMenuConnexion()
	{
		// Si l'utilisateur est connecté
		if ($this->monUtilisateur->estConnecte())
		{
			// On affiche son login, un lien vers la partie privée et un lien de deconnexion
			$this->ouvreBloc("<p id=\"connexion\">");
			$this->ajouteLigne(
				$this->convertiTexte($this->monUtilisateur->recupLogin())
				);
			$this->ajouteLigne("<span><a href=\"" .
				PAGE_MODULE . 
				"\" title=\"" .
				$this->convertiTexte("Accès partie privée") .
				"\">" .
				$this->convertiTexte("Accès partie privée") .
				"</a></span>");
			$this->ajouteLigne("<span><a href=\"" .
				DECONNEXION .
				"\" title=\"" .
				$this->convertiTexte("Déconnexion du site et du forum") .
				"\">" .
				$this->convertiTexte("Déconnexion") .
				"</a></span>");
			$this->fermeBloc("</p>");			
		}
		else
		{
			// On vérifie le cas ou l'utilisateur existe sur le forum
			// Mais pas sur le site
			if ($this->monUtilisateur->estForumOnly() )
			{
				// Dans ce cas, on ne lui propose pas de se connecter
				// Il l'est déjà
				$this->ouvreBloc("<p id=\"connexion\">");
				$this->ajouteLigne(
					$this->convertiTexte("Votre connexion au forum ne permet pas une connexion à ce site")
					);
				$this->ajouteLigne("<a href=\"" .
				DECONNEXION .
				"\" title=\"" .
				$this->convertiTexte("Déconnexion du forum") .
				"\">" .
				$this->convertiTexte("Déconnexion du forum") .
				"</a>");
				$this->fermeBloc("</p>");				
			}
			else
			{
				// Sinon, on affiche un lien pour se connecter
				$this->ouvreBloc("<p id=\"connexion\">");
				$this->ajouteLigne(
					$this->convertiTexte("Vous n'êtes pas connecté.")
					);
				$this->ajouteLigne("<span><a href=\"" .
					PAGE_CONNEXION . 
					"\" title=\"" .
					$this->convertiTexte("Connexion au site et au forum MDJT") .
					"\">" .
					$this->convertiTexte("Connexion") .
					"</a></span>");
				$this->fermeBloc("</p>");
			}
		}
	}
	
	/**
	* Fonction d'affichage de la zone mini actu
	* Cette fonction est à définir dans les classes filles
	*/ 
	abstract protected function afficheMiniActu();
	
	

	//
	// Création du squelette d'une page
	//


	
	/**
         * Fonction d'initialisation de l'entête de la page
	 * La page est créée jusqu'à l'ouverture de la balise body
         * @param $cssAdditionnels : tableau contenant la liste des fichiers css qu'on souhaite ajouter
	*/
	private function ouvrePage($cssAdditionnels = NULL)
	{
		// Création du DOCTYPE
		$this->ajouteLigne("<!DOCTYPE HTML>");
		// Ouverture de html
		$this->ouvreBloc("<html lang=\"fr\">");	
		// Ouverture header
		$this->ouvreBloc("<head>");
		// Balises meta
		$this->ajouteLigne("<meta charset=\"UTF-8\" />");		
		// Titre
		$this->ajouteLigne("<title>" . 
			$this->convertiTexte("Maison Des Jeux de Touraine") .
			"</title>");
		// Icon
		$this->ajouteLigne("<link rel=\"icon\" type=\"image/gif\" href=\"" .
			RACINE_SITE . IMAGES . "mini.gif\" />");
		// Style
		$this->ajouteLigne("<link rel=\"stylesheet\" type=\"text/css\" href=\"" .
			RACINE_SITE . CSS_MDJT . "\" />");
		$this->ajouteLigne("<link rel=\"stylesheet\" type=\"text/css\" href=\"" .
			RACINE_SITE . CSS_RESET . "\" />");
                // Si il y a des styles additionnels, on les ajoute
                if ($cssAdditionnels != NULL)
                {
                    // On parcours le tableau des styles
                    foreach ($cssAdditionnels as $style) 
                    {
                        $this->ajouteLigne("<link rel=\"stylesheet\" type=\"text/css\" href=\"" .
			RACINE_SITE . $style . "\" />");
                    }
                }
		// Fermeture header
		$this->fermeBloc("</head>");
		// Ouverture de body
		$this->ouvreBloc("<body>");
	}

	
	/**
	* Fonction de fermeture de la page
	* Ferme body et html
	*/
	private function fermePage()
	{
		// Fermeture de body
		$this->fermeBloc("</body>");		
		// Fermeture de html
		$this->fermeBloc("</html>");
	}	
	
	/**
	* Fonction d'ajout du Haut d'une page standard
	*/
	private function ajouteHautPage()
	{
		$this->ouvreBloc("<div id=\"conteneur\">");
		$this->ouvreBloc("<header id=\"headerPage\">");
		$this->ouvreBloc("<div id=\"logo\">");
		$this->ajouteLigne("<h1>" .
			$this->convertiTexte("Maison des Jeux de Touraine") .
			"</h1>");
		$this->ajouteLigne("<a href=\"" .
			PAGE_INDEX . 
			"\"><img src=\"" .
			IMAGES . 
			"header.jpg\" alt=\"Logo MDJT\" /></a>");
		$this->fermeBloc("</div>");
		$this->ouvreBloc("<div id=\"actualite\">");
		// Affichage de la zone MiniActu, cette zone différent selon les classes filles, donc la méthode est abstraite
		$this->afficheMiniActu();
		$this->fermeBloc("</div>");
		$this->fermeBloc("</header>");   
    	$this->ouvreBloc("<div id=\"contenuPrincipal\">");
	}
	
	/**
	* Fonction d'ajout du Bas d'une page standard
	*/ 
	private function ajouteBasPage()
	{
		$this->ajouteLigne("<div class=\"blocClear\"></div>");
		$this->ouvreBloc("</div> <!-- fermeture div#contenuPrincipal -->");
		$this->ouvreBloc("<footer id=\"footerPage\">");

		$this->ajouteMenuConnexion();

		$this->ouvreBloc("<p id=\"menuPied\">");
		$this->ajouteLigne("<a href=\"" .
			PAGE_MENTIONS . 
			"\">" .
			$this->convertiTexte("Mentions légales") .
			"</a>");
		$this->ajouteLigne("<span><a href=\"" .
			PAGE_CONTACT . 
			"\">" .
			$this->convertiTexte("Contact") .
			"</a></span>");
		$this->fermeBloc("</p>");

		$this->fermeBloc("</footer>");
		$this->fermeBloc("</div> <!-- fermeture div#conteneur -->");
	}
	
	
	
	//
	// Remplissage du squelette d'une page
	//

}
?>