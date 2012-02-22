<?php
/**
* Classe du module "Groupes"
* Le module Groupes permet la gestion des groupes, c'est à dire :
*   - L'affectation des utilisateurs à un groupe
* Les groupes servent à définir les droits des utilisateurs sur le site 
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_GROUPES", RACINE_SITE . "module.php?idModule=Groupes");
define("FORMULAIRE_CHOIX",0);
define("FORMULAIRE_GROUPE",1);
define("FORMULAIRE_UTILISATEUR",2);

class ModuleGroupes extends Module
{

// Attributs
    // Objet stockant l'utilisateur courant
    private $monUtilisateur = NULL;
    // Objet stockant l'accès à la base de données
    private $maBase = NULL;
    // Variable servant à savoir le type de formulaire à afficher
    private $typeFormulaire = 0;
    
// Methodes

    /**
    * Le constructeur du module Mon Profil
    */
    public function __construct($unUtilisateur)
    {
        // On utilise le constructeur de la classe mère
	parent::__construct();
	
        // On récupère l'utilisateur
	$this->monUtilisateur = $unUtilisateur;
		
	// On a besoin d'un accès à la base - On utilise la fonction statique prévue
	$this->maBase = AccesAuxDonnees::recupAccesDonnees();
		
	// On traite le formulaire, le cas échéant
	$this->traiteFormulaire();
		
	// On affiche le contenu du module
	// On affiche le formulaire de consultation/modification des informations propres à l'utilisateur
	$this->afficheFormulaire();		
    }
    
    //
    // Méthodes privées pour la construction et le traitement de la  page
    //
    
    public function afficheFormulaire()
    {
        switch ($this->typeFormulaire) 
        {
            case FORMULAIRE_CHOIX :
                $this->afficheFormulaireChoix();
                break;
            case FORMULAIRE_GROUPE :
                $this->afficheFormulaireGroupe();
                break;
            case FORMULAIRE_UTILISATEUR :
                $this->afficheFormulaireUtilisateur();
                break;
            default:
                break;
        }
    }
    
    /**
     * Fonction d'affichage du formulaire de modification des groupes d'un utilisateur
     */
    public function afficheFormulaireUtilisateur()
    {
        // Récupération de l'id et du nom du groupe depuis POST
        $tableau = explode("ø", $_POST["utilisateur"]);
        $idUtilisateur = $tableau[0];
        $prenom = $tableau[1];
        $nom = $tableau[2];
        
        // On affiche le contenu du formulaire	
        $this->ouvreBloc("<form method='post' action='" .
		MODULE_GROUPES . "'>");
        
        // On affiche la liste des groupes
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend> " .
            $this->convertiTexte("Modifier les groupes de " . $prenom . " " . $nom) .
            "</legend>");		
        $this->ouvreBloc("<ol>");
        // Afficher les groupes
        
        // On récupère la liste des groupes de l'utilisateur
        $listeGroupes = $this->maBase->recupGroupesUtilisateurAvecID($idUtilisateur);
        
        // On affiche la liste des groupes
        foreach ($this->maBase->recupGroupes() as $unGroupe) 
        {
            $this->ouvreBloc("<li>");
            $this->ajouteLigne("<label for='" . $unGroupe[ID_GROUPE] . "'>" .
			$this->convertiTexte($unGroupe[NOM_GROUPE] ) .
	  		"</label>");
            // Si l'utilisateur fait partie de la liste des Utilisateur du groupe
            if (in_array($unGroupe, $listeGroupes))
            {
                // On le coche
                $this->ajouteLigne("<input type='checkbox' name='" . $unGroupe[ID_GROUPE] . "' checked='checked'/></p>");
            }
            else
            {
                // On ne le coche pas
                $this->ajouteLigne("<input type='checkbox' name='" . $unGroupe[ID_GROUPE] . "' /></p>");
            }	
            $this->fermeBloc("</li>");
        }
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<input type='hidden' name='idUtilisateur' value='" . $idUtilisateur . "' />");
        $this->ajouteLigne("<button type='submit' name='modifierUtilisateur'>Modifier les groupes</button>");
        $this->fermeBloc("</fieldset>");
        $this->fermeBloc("</form>");   
    }
    
    /**
     * Fonction d'affichage du formulaire de modification des utilsiateurs d'un groupes
     */
    public function afficheFormulaireGroupe()
    {
        // Récupération de l'id le nom et le prenom de l'utilisateur depuis POST
        $tableau = explode("ø", $_POST["groupe"]);
        $idGroupe = $tableau[0];
        $nomGroupe = $tableau[1];
        
        
        // On affiche le contenu du formulaire	
        $this->ouvreBloc("<form method='post' action='" .
		MODULE_GROUPES . "'>");
        
        // On affiche la liste des utilisateurs
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend> " .
            $this->convertiTexte("Modification du groupe " . $nomGroupe) .
            "</legend>");		
        $this->ouvreBloc("<ol>");
        // Afficher les utilisateurs
        
        // On récupère la liste des utilisateurs qui sont dans ce groupe
        $listeUtilisateurDuGroupe = $this->maBase->recupUtilisateursDansUnGroupe($idGroupe);
        
        // On 
        foreach ($this->maBase->recupUtilisateurs() as $unUtilisateur) 
        {
            $this->ouvreBloc("<li>");
            $this->ajouteLigne("<label for='" . $unUtilisateur[ID_UTILISATEUR] . "'>" .
			$this->convertiTexte($unUtilisateur[PRENOM] . " " . $unUtilisateur[NOM] ) .
	  		"</label>");
            // Si l'utilisateur fait partie de la liste des Utilisateur du groupe
            if (in_array($unUtilisateur,$listeUtilisateurDuGroupe))
            {
                // On le coche
                $this->ajouteLigne("<input type='checkbox' name='" . $unUtilisateur[ID_UTILISATEUR] . "' checked='checked'/></p>");
            }
            else
            {
                // On ne le coche pas
                $this->ajouteLigne("<input type='checkbox' name='" . $unUtilisateur[ID_UTILISATEUR] . "' /></p>");
            }	
            $this->fermeBloc("</li>");
        }
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<input type='hidden' name='idGroupe' value='" . $idGroupe . "' />");
        $this->ajouteLigne("<button type='submit' name='modifierGroupe'>Modifier les utilisateurs</button>");
        $this->fermeBloc("</fieldset>");
        $this->fermeBloc("</form>");           
    }    
    
    /**
     * Fonction d'affichage du formulaire de choix entre la modification d'un groupe et celle d'un utilisateur
     */
    public function afficheFormulaireChoix()
    {
      
	// On affiche le contenu du formulaire	
        $this->ouvreBloc("<form method='post' action='" .
		MODULE_GROUPES . "' id='formGroupes'>");
        // On affiche le titre du formulaire
	$this->ouvreBloc("<p>");
	$this->ajouteLigne("Gestion des groupes" );
	$this->fermeBloc("</p>");
        
        // Première option, selectionner un utilisateur
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend> " .
            $this->convertiTexte("Modifier les groupes d'un utilisateur") .
            "</legend>");		
        $this->ajouteLigne("<label for='utilisateur'>" .
                        $this->convertiTexte("Utilisateur") .
                        "</label>");
        $this->ouvreBloc("<select name='utilisateur'>");
	// Un premier choix vide
	$this->ajouteLigne("<option value=''>Choisissez un utilisateur</option>");        
         // On parcourt la liste des Utilisateurs
        foreach ($this->maBase->recupUtilisateurs() as $unUtilisateur) 
        {
            // Pour chaque utilisateur, on ajoute une ligne dans la liste déroulante
            $this->ajouteLigne("<option value='" .
                    $unUtilisateur[ID_UTILISATEUR] .
                    "ø" .
                    $unUtilisateur[PRENOM] .
                    "ø" .
                    $unUtilisateur[NOM] .
                    "'>" .
                    $this->convertiTexte($unUtilisateur[PRENOM] . " " . $unUtilisateur[NOM] ) .
                    "</option>");
        }
        $this->fermeBloc("</select>");
        $this->fermeBloc("</fieldset>");
        /*
        $this->ouvreBloc("<fieldset>");
        $this->ouvreBloc("<ol>");
        // On parcourt la liste des Groupes
        foreach ($this->maBase->recupGroupes() as $unGroupe) 
        {
          $this->ouvreBloc("<li>");
          // Pour chaque groupe, on ajoute le nom en label
          $this->ajouteLigne("<label for='" . $unGroupe[ID_GROUPE] . "'>" . $this->convertiTexte($unGroupe[NOM_GROUPE]) . "</label>");            
          // puis une case à cocher
					$this->ajouteLigne("<input type=\"checkbox\" name='". $unGroupe[ID_GROUPE] . "' id='" . $unGroupe[ID_GROUPE] . "' />");
          $this->fermeBloc("</li>");
        }         
        $this->fermeBloc("</ol>");
        $this->fermeBloc("</fieldset>");
         */
        $this->ouvreBloc("<fieldset>");        
        $this->ajouteLigne("<button type='submit' name='modifierParUtilisateur'>Afficher ses groupes</button>");
        $this->fermeBloc("</fieldset>");
        $this->fermeBloc("</form>");
                
        // Seconde option, selectionner un groupe
        $this->ouvreBloc("<form method='post' action='" .
		MODULE_GROUPES . "' id='formGroupes'>"); 
        $this->ouvreBloc("<fieldset>");
        $this->ajouteLigne("<legend> " .
            $this->convertiTexte("Modifier les utilisateurs d'un groupe") .
            "</legend>");		
        $this->ajouteLigne("<label for='groupe'>" .
                        $this->convertiTexte("Groupe") .
                        "</label>");
        $this->ouvreBloc("<select name='groupe'>");
	// Un premier choix vide
	$this->ajouteLigne("<option value=''>Choisissez un groupe</option>"); 
        // On parcours la liste des Groupes
        foreach ($this->maBase->recupGroupes() as $unGroupe) 
        {
            // Pour chaque groupe, on ajoute une ligne dans la liste déroulante
            $this->ajouteLigne("<option value='" .
                    $unGroupe[ID_GROUPE] .
                    "ø" .
                    $unGroupe[NOM_GROUPE] .
                    "'>" .
                    $this->convertiTexte($unGroupe[NOM_GROUPE]) .
                    "</option>");
        }
        $this->fermeBloc("</select>");
        $this->ouvreBloc("<fieldset>");  
	$this->ajouteLigne("<button type='submit' name='modifierParGroupe'>Affecter les utilisateurs</button>");
        $this->fermeBloc("</fieldset>");
        $this->fermeBloc("</form>");	

    }
    
    

    
    /**
     * Fonction de traitement des données du formulaire
     */
    public function traiteFormulaire()
    {
        // Traitement du formulaire -- On veut modifier un utilisateur
        if (isset ($_POST["modifierParUtilisateur"]))
        {
            $this->typeFormulaire = FORMULAIRE_UTILISATEUR;
            // Vérification des données POST
            // On a un nom d'utilisateur à notre format
            if(!((preg_match("/^[0-9]+ø\w+ø\w+$/i", $_POST["utilisateur"]) == 1) 
                    AND (strcmp($_SERVER["HTTP_REFERER"], PAGE_MODULE . "?idModule=Groupes" ) == 0)))
            {
                // La requete n'est pas valide
                // On revient sur la page de choix de départ
                $this->typeFormulaire = FORMULAIRE_CHOIX; 
            } 
        }
        // Traitement du formulaire -- On veut modifier un groupe
        elseif (isset ($_POST["modifierParGroupe"])) 
        {
            $this->typeFormulaire = FORMULAIRE_GROUPE;
            // Vérification des données POST
            // On a un nom de groupe à notre format
            if(!((preg_match("/^[0-9]+ø\w+$/i", $_POST["groupe"]) == 1) 
                    AND (strcmp($_SERVER["HTTP_REFERER"], PAGE_MODULE . "?idModule=Groupes" ) == 0)))
            {
                // La requete n'est pas valide
                // On revient sur la page de choix de départ
                $this->typeFormulaire = FORMULAIRE_CHOIX; 
            } 
            
        }
        // Sinon, pas de formulaire à traiter
    }
    
        
        

}

?>
