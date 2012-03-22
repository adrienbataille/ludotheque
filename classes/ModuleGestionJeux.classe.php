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

    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct()
    {
        // On utilise le constructeur de la classe mère
		parent::__construct();
		
		// On affiche le contenu du module
		// On affiche le formulaire d'ajout des informations propres à un jeux
		$this->afficheFormulaire();		
    }
    
	/**
	  *	Fonction d'affichage du formulaire
	  */
    public function afficheFormulaire()
    {
    	//$this->ouvreBloc("<nav>");
    	
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
		
		//$this->fermeBloc("</nav>");
		
		$this->ouvreBloc("<div id='livre_en_retard'>");
		$this->ouvreBloc("<p>");
		$this->ajouteLigne("Ici, on affichera la liste des jeux en retard");
		$this->fermeBloc("</p>");
		$this->fermeBloc("</div>");
    }
}

?>
