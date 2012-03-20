<?php
/**
* Classe du module "AjoutJeux"
* Le module AjoutJeux permet la gestion des jeux, c'est à dire :
*   - La création des occurences des Jeux
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_JEUX", RACINE_SITE . "module.php?idModule=AjoutJeux");

//Constantes formulaire
define("NOM_J", "nom");
define("LANGUE_J", "langue");
define("DESCRIPTION_J", "description");
define("AUTEUR_J", "auteur");
define("PAYS_J", "pays");
define("CATEGORIE_J", "catégorie");

define("VIDE", "");

class ModuleAjoutJeux extends Module
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
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		
		// On affiche le contenu du module
		// On affiche le formulaire d'ajout des informations propres à un jeux
		$this->afficheFormulaire();		
    }
    
    public function afficheFormulaire()
    {	
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_JEUX . "' id='formProfil'>");
        
        // First fieldset : Nom du jeu
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Nom du jeux</legend>");
        $this->ouvreBloc("<ol>");
        
        // Nom
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NOM_J . "'>" . $this->convertiTexte("Nom") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . NOM_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Langue
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . LANGUE_J . "'>" . $this->convertiTexte("Langue du nom") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . LANGUE_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        
        // Second fieldset : Information sur le jeux
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Information sur le jeux</legend>");
        $this->ouvreBloc("<ol>");
        
        // Description
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DESCRIPTION_J . "'>" . $this->convertiTexte("Description") . "</label>");
        $this->ajouteLigne("<textarea rows='3' name='" . DESCRIPTION_J . "'>" . VIDE . "</textarea>");
        $this->fermeBloc("</li>");
        
        // Auteur
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . AUTEUR_J . "'>" . $this->convertiTexte("Auteur") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . AUTEUR_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Pays
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . PAYS_J . "'>" . $this->convertiTexte("Pays d'origine") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . PAYS_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Catégories
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . CATEGORIE_J . "'>" . $this->convertiTexte("Catégorie") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . CATEGORIE_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        
        // Bouton valider
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='modifier' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Modifier'>Je valide mes modifications</button>");
		$this->fermeBloc("</fieldset>");
        
        $this->fermeBloc("</form>");
    }
    
}

?>
