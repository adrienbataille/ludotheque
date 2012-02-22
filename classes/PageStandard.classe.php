<?php
/**
* Cette classe permet de créer des pages web au format MDJT
*/

// Inclusion des fichiers utiles
require_once("classes/Page.classe.php");
require_once("classes/Calendrier.classe.php");

// Constante

class PageStandard extends Page 
{
// Attributs
	private $calendrier;

// Méthodes

	/**
	* Constructeur
	*/
	public function __construct()
	{
		// Initialisation du calendrier
		$this->initCalendrier();
		// On utilise le constructeur de la classe mère
		parent::__construct();		
	}
	
	/**
	* Destructeur de la classe
	* Le destructeur termine la construction de la page et l'affiche
	*/
	public function __destruct()
	{
		// On utilise le destructeur de la classe mère
		parent::__destruct();
	}
	
	//
	// Outils internes
	//
	
	/**
	* Fonction d'initialisation du calendrier
	*/
	private function initCalendrier()
	{
		// On créer un objet calendrier
		$this->calendrier = new Calendrier();
	}

	
	//
	// Création du squelette d'une page
	//
	
	/**
	* Fonction d'ouverture de la zone de gauche - contenant la partie éditoriale
	*/
	public function ouvreBlocGauche()
	{
		$this->ouvreBloc("<section id=\"blocGauche\">");		
	}

	/**
	* Fonction de fermeture de la zone de gauche
	*/	
	public function fermeBlocGauche()
	{
		$this->fermeBloc("</section> <!-- Fermeture div#blocGauche -->");	
	}
	
	
	/**
	* Fonction d'ouverture de la zone de droite - contenant le menu et le calendrier
	*/	
	public function ouvreBlocDroit()		
	{
		$this->ouvreBloc("<section id=\"blocDroit\">");		
	}
	
	/**
	* Fonction de fermeture de la zone de Droite
	*/	
	public function fermeBlocDroit()
	{
		$this->fermeBloc("</section> <!-- Fermeture div#blocDroit -->");	
	}

	

	//
	// Remplissage du squelette d'une page
	//

	protected function afficheMiniActu() 
	{
		// On récupère le premier evenement
		$prochainEvenement = $this->calendrier->recupEvenement(0);
		$this->ajouteLigne("<h2>"
			. $this->convertiTexte($prochainEvenement["titre"])
			. "</h2><br />");
		$this->ouvreBloc("<p>");			
		$this->ajouteLigne("Le "
		. $prochainEvenement["dateDebut"]
		. " à partir de "
		. $prochainEvenement["heureDebut"]
		. "<br /><br />");
		$this->ajouteLigne($prochainEvenement["lieu"]
		. "<br /><br />");
		$this->ajouteLigne($prochainEvenement["description"]);
		$this->fermeBloc("</p>");
	}
	
	/**
	* Fonction d'affichage du mini calendrier
	*/	
	public function afficheMiniCalendrier()
	{
		// Initialisation du calendrier
		$this->initCalendrier();
		// Affichage
		$this->ajouteLigne("<!-- balise contenant le calendrier -->");
		$this->ouvreBloc("<aside id=\"calendrier\">");
		$this->ajouteLigne("<h2>Prochainement</h2>");
		$this->ouvreBloc("<ul>");
		// Premier essai d'affichage du calendrier -- Pour test de récupération des informations
		foreach($this->calendrier->recupEvenements() as $unEvenement)
		{ 		
			$this->ajouteLigne("<li><a href=\"" . 
			$unEvenement["lien"]
			 . "\" target=\"_blank\">"
			 . $this->convertiTexte($unEvenement["titre"])
			 . "<br />"
			 . "Le "
			 . $unEvenement["dateDebut"]
			 . " à "
			 . $unEvenement["heureDebut"]
			 . "</a></li>");
		}
		// Fin du test
		$this->fermeBloc("</ul>");
		$this->fermeBloc("</aside>");	
	}



	/**
	* Fonction d'affichage du menu
	*/
	public function afficheMenu()
	{
		// Initialisation du cycle des couleurs
		$this->indexStyleMenu = 1;
		
		$this->ajouteLigne("<!-- balise contenant le menu -->");
		$this->ouvreBloc("<nav id=\"menu\">");
		$this->ajouteLigne("<h2>" .
			$this->convertiTexte("Menu Principal") .
			"</h2>");
		$this->ouvreBloc("<ol>");
		$this->ajouteElementMenu(PAGE_INDEX,"Accueil");
		$this->ajouteElementMenu(PAGE_INDEX,"L'association");
		$this->ajouteElementMenu(PAGE_INDEX,"Nos actions");
		$this->ajouteElementMenu(PAGE_INDEX,"Dominion - la ligue");		
		$this->ajouteElementMenu(PAGE_INDEX,"Nos partenaires");
		$this->ajouteElementMenu(PAGE_INDEX,"Liens");
		$this->ajouteElementMenu(FORUM,"Notre forum");
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</nav>");
	}		
			
	/**
	* Fonction d'affichage du bloc d'invite de connexion ou de deconnexion
	*/	
	public function afficheLogin()
	{
		// Vérification l'utilisateur est-il authentifié
		if ($this->monUtilisateur->estConnecte())
		{
			$this->ajouteLigne("<p>" .
				$this->convertiTexte("Vous êtes déjà connecté") .
				"</p>");
		}
		else
		{
		// Si l'utilisateur n'est pas connecté, on affiche l'invite de connexion
			$this->ouvreBloc("<form method='post' action='" .
				PAGE_LOGIN_PHPBB . "' id=\"login\">");
			$this->ouvreBloc("<fieldset>");
			$this->ajouteLigne("<legend>Connexion</legend>");
			$this->ouvreBloc("<ol>");
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for=\"username\">" .
				$this->convertiTexte("Identifiant") .
				"</label>");
			$this->ajouteLigne("<input type=\"text\" id=\"username\" name=\"username\" placeholder=\"identifiant\" required autofocus /> <br />");
			$this->fermeBloc("</li>");			
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for=\"password\">" .
				$this->convertiTexte("Mot de passe") .
				"</label>");
			$this->ajouteLigne("<input type='password' name='password' placeholder=\"mot de passe\" required /> <br />");
			$this->fermeBloc("</li>");
			$this->ouvreBloc("<li>");
			$this->ajouteLigne("<label for=\"autologin\">" .
				$this->convertiTexte("Rester connecté") .
				"</label>");
			$this->ajouteLigne("<input type=\"checkbox\" name=\"autologin\" id=\"autologin\" />");
			$this->fermeBloc("</li>");
			$this->fermeBloc("</ol>");		
			$this->ajouteLigne("<button type='submit' name='login'>Je me connecte</button>");
			// Redirection sur la page cible après login
			$this->ajouteLigne("<input type='hidden' name='redirect' value='" .
				REDIRECTION_PHPBB .
				"' />");

			$this->fermeBloc("</fieldset>");
			$this->fermeBloc("</form>");
		}
	}
	
	/**
	* Fonction d'affichage de la page contact
	*/
	public function afficheContact()
	{
		$this->ouvreBloc("<div>");
		$this->ajouteLigne("<p>Ceci est une page de contact</p>");
		$this->fermeBloc("</div>");
	}
	
	/**
	* Fonction d'affichage de la page des mentions légales
	*/
	public function afficheMentions()
	{
		$this->ouvreBloc("<div>");
		$this->ajouteLigne("<p>Ceci est une page de mentions légales</p>");
		$this->fermeBloc("</div>");	
	}
}
?>