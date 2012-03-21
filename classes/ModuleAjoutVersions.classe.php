<?php
/**
* Classe du module "AjoutVersions"
* Le module AjoutVersions permet la gestion des verions, c'est à dire :
*   - La création des occurences des Versions
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_AJOUT_VERSIONS", RACINE_SITE . "module.php?idModule=AjoutVersions");

//Constantes formulaire
define("NOM_V", "nom_version");
define("DESCRIPTION_V", "description_version");
define("AGE_MIN_V", "age_min_version");
define("NB_JOUEUR_V", "nb_joueur_min");
define("NB_JOUEUR_R_V", "nb_joueur_reco");
define("DUREE_V", "duree_jeu");
define("PRIX_V", "prix_version");
define("ANNEE_V", "annee_sortie");
define("ILLUST_V", "illustrateur");
define("DISTRIB_V", "distributeur");
define("EDITEUR_V", "editeur");



class ModuleAjoutVersions extends Module
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
        $this->ouvreBloc("<form method='post' action='" . MODULE_AJOUT_VERSIONS . "' id='formProfil'>");
        
        // First fieldset : Nom de la versions
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Nom de la version</legend>");
        $this->ouvreBloc("<ol>");
        
        // Nom
         $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NOM_V . "'>" . $this->convertiTexte("Nom de la version") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . NOM_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
 
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        
        // Second fieldset : Informations sur la version
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend>Informations sur la version</legend>");
        $this->ouvreBloc("<ol>");
        
        // Description
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DESCRIPTION_V . "'>" . $this->convertiTexte("Description") . "</label>");
        $this->ajouteLigne("<textarea rows='3' name='" . DESCRIPTION_V . "'>" . VIDE . "</textarea>");
        $this->fermeBloc("</li>");
        
        // Age minimum
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . AGE_MIN_V . "'>" . $this->convertiTexte("Age min") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . AGE_MIN_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Nombre Joueur
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NB_JOUEUR_V . "'>" . $this->convertiTexte("Nombre de joueurs") . "</label>");
        $this->ajouteLigne("<input type='text' maxlength='2' name='"  . NB_JOUEUR_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		
		 // Nombre Joueur recommandés
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . NB_JOUEUR_R_V . "'>" . $this->convertiTexte("Joueurs recommandés") . "</label>");
        $this->ajouteLigne("<input type='text' maxlength='2' name='"  . NB_JOUEUR_R_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		 // Durée partie
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DUREE_V . "'>" . $this->convertiTexte("Durée d'une partie") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . DUREE_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		
		 // Prix achat
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . PRIX_V . "'>" . $this->convertiTexte("Prix d'achat") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . PRIX_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		 //Année de sortie
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . ANNEE_V . "'>" . $this->convertiTexte("Année de sortie") . "</label>");
        $this->ajouteLigne("<input type='text' maxlength='4' name='"  . ANNEE_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		//Illustrateur
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . ILLUST_V . "'>" . $this->convertiTexte("Illustrateur") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . ILLUST_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		
		//Distributeur
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . DISTRIB_V . "'>" . $this->convertiTexte("Distributeur") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . DISTRIB_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
		
		//Editeur
        $this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . EDITEUR_V . "'>" . $this->convertiTexte("Editeur") . "</label>");
        $this->ajouteLigne("<input type='text' name='"  . EDITEUR_V . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");
        
        // Catégories
        /*$this->ouvreBloc("<li>");
        $this->ajouteLigne("<label for='" . CATEGORIE_J . "'>" . $this->convertiTexte("Catégorie") . "</label>");
        $this->ajouteLigne("<input type='text' name='" . CATEGORIE_J . "' value='" . VIDE . "' />");
        $this->fermeBloc("</li>");*/
        
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
		
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='modifier' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Modifier'>Valider</button>");
		$this->fermeBloc("</fieldset>");
        
        $this->fermeBloc("</form>");
    }
    
}

?>
