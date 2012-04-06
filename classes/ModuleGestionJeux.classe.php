<?php
/**
* Classe du module "AjoutJeux"
* Le module AjoutJeux permet la gestion des jeux, c'est à dire :
*   - La création des occurences des Jeux
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_GESTION_JEUX", RACINE_SITE . "module.php?idModule=GestionJeux");

class ModuleGestionJeux extends Module
{

// Attributs
	private $infoJeu = false;
	private $infoVersion = false;
	private $infoExemplaire = false;
    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($jeu, $version, $exemplaire)
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
		
		if($jeu)
			$this->infoJeu = true;
		if($version)
			$this->infoVersion = true;
		if($exemplaire)
			$this->infoExemplaire = true;
		
		// On affiche le contenu du module
		// On affiche le formulaire d'ajout des informations propres à un jeux
		$this->afficheFormulaire();		
    }
    
	/**
	  *	Fonction d'affichage du formulaire
	  */
    public function afficheFormulaire()
    {
    	
		if($this->infoJeu)
			$this->ajouteLigne("<p class='ajoutOk'>Votre jeu a bien été ajouté</p>");
		if($this->infoVersion)
			$this->ajouteLigne("<p class='ajoutOk'>Votre version de jeu a bien été ajouté</p>");
		if($this->infoExemplaire)
			$this->ajouteLigne("<p class='ajoutOk'>Votre exemplaire de jeu a bien été ajouté</p>");
    	
    	
		$this->ouvreBloc("<div id='menu_gestion_jeux'>");
		
    	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_JEUX . "' id='formProfil'>");
        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterJeu' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterJeu' value='true'>" . $this->convertiTexte("Ajouter un jeu") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
    	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_VERSIONS . "' id='formProfil'>");
        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterJeu' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterJeu' value='true'>" . $this->convertiTexte("Ajouter une version") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
    	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_EXEMPLAIRES . "' id='formProfil'>");
        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='ajouterJeu' value='true' />");
		$this->ajouteLigne("<button type='submit' name='AjouterJeu' value='true'>" . $this->convertiTexte("Ajouter un exemplaire") . "</button>");
		$this->fermeBloc("</fieldset>");
		
		$this->fermeBloc("</form>");
		
		
		$this->fermeBloc("</div>");
        
        /*
		$this->ouvreBloc("<ul id='menu_gestion_jeux'>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<a href='" . MODULE_AJOUT_JEUX . "' title='" . $this->convertiTexte("Ajouter un jeu") . "'>" . $this->convertiTexte("Ajouter un jeu") . "</a>");
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<a href='" . MODULE_AJOUT_VERSIONS . "' title='" . $this->convertiTexte("Ajouter une version") . "'>" . $this->convertiTexte("Ajouter une version") . "</a>");
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<a href='" . MODULE_AJOUT_EXEMPLAIRES . "' title='" . $this->convertiTexte("Ajouter un exemplaire") . "'>" . $this->convertiTexte("Ajouter un exemplaire") . "</a>");
		$this->fermeBloc("</li>");
		
		$this->fermeBloc("</ul>");
		*/
		
		$this->ouvreBloc("<div id='livre_en_retard'>");
		$this->ouvreBloc("<p>");
		$this->ajouteLigne("Ici, on affichera la liste des jeux en retard");
		$this->fermeBloc("</p>");
		$this->fermeBloc("</div>");
    }
}

?>
