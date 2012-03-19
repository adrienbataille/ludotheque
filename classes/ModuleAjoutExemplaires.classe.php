<?php
/**
* Classe du module "AjoutExemplaires"
* Le module AjoutVersions permet la gestion des verions, c'est à dire :
*   - La création des occurences des Versions
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_EXEMPLAIRES", RACINE_SITE . "module.php?idModule=AjoutExemplaires");

//Constantes formulaire
define("DESCRIPTION_E", "description_version");
define("PRIX_MDJT", "prix_mdjt");
define("DATE_ACHAT", "date_achat");
define("DATE_FIN_VIE" , "date_fin_vie");


/* REMARQUES :
Je pense que Date fin de vie n'esst pas un champs possible à l'insertion dès la premiere insertion, mais seulement à la modification
*/



class ModuleAjoutExemplaires extends Module
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
		// On affiche le formulaire d'ajout des informations propres à une version
		$this->afficheFormulaire();		
    }
    
    public function afficheFormulaire()
    {	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_EXEMPLAIRES . "' id='formProfil'>");
        
        
        // Second fieldset : Informations sur l'exemplaire
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Informations sur l'exemplaire</legend>");
        $this->ouvreBloc("<ol>");
        
        // Description
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DESCRIPTION_E . "'>" . $this->convertiTexte("Description") . "</label>");
        $this->ajouteLigne("<textarea rows='3' name='" . DESCRIPTION_E . "'>" . VIDE . "</textarea>");
        $this->fermeBloc("</li>");
		
				
		 // Prix mdjt
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . PRIX_MDJT . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . PRIX_MDJT . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Data achat
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DATE_ACHAT . "'>" . $this->convertiTexte("Date Achat") . "</label>");
        $this->ajouteLigne("<input type='text' maxlength='10' name='" . DATE_ACHAT . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
				
        // Data fin de vie
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DATE_FIN_VIE . "'>" . $this->convertiTexte("Date fin de vie") . "</label>");
        $this->ajouteLigne("<input type='text' maxlength='10' name='" . DATE_FIN_VIE . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
		
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        
        $this->fermeBloc("</form>");
    }
    
}

?>
