<?php
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_JEU", RACINE_SITE . "module.php?idModule=Jeu");
define("DESCRIPTION_J","description");
define("AUTEUR_J","auteur");
define("NOM_J","nom");

class ModuleJeu extends Module
{

    public function __construct()
    {
        // On utilise le constructeur de la classe mère
        parent::__construct();
        $this->affiche();

    }
    private function affiche()
    {
	
		$this->ouvreBloc("<form method='post' action='" .MODULE_JEU . "' id='formProfil'>");
		$this->ouvreBloc("<fieldset>");	

		$this->ajouteLigne("<legend>Ajout un jeu</legend>");
		$this->ouvreBloc("<ol>");
		
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM_J . "'>" .$this->convertiTexte("Nom") ."</label>");
		$this->ajouteLigne("<input type='text' name'" . NOM_J ."'></input>");
		$this->fermeBloc("</li>");
		
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . AUTEUR_J . "'>" .$this->convertiTexte("Auteur") ."</label>");
		$this->ajouteLigne("<input type='text' name'" . AUTEUR_J ."'></input>");
		$this->fermeBloc("</li>");
		
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DESCRIPTION_J . "'>" . $this->convertiTexte("Description")."</label>");
		$this->ajouteLigne("<textarea rows='3' name'" . DESCRIPTION_J ."'></textarea>");
		$this->fermeBloc("</li>");
		
		

		
		$this->fermeBloc("</ol>");		
		$this->fermeBloc("</fieldset>");
		$this->fermeBloc("</form>");
    }
}
?>