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
define("MAIL_OBJECT","MDJT - Retard");
define("MAIL_BODY","Bonjour, vous recevez ce message car vous avez emprunté un ou plusieurs jeux à la MDJT et vous avez depassé la date de retour prévue.");

class ModuleGestionJeux extends Module
{

// Attributs
	private $infoJeu = false;
	private $infoVersion = false;
	private $infoExemplaire = false;
    
	private $baseDonnees =NULL;
	private $tabJeuxNonRendu=NULL;
	
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
		$this->baseDonnees = AccesAuxDonneesDev::recupAccesDonneesDev();
		
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
		
		$this->ouvreBloc("<div id='livre_en_retard'>");
		$this->ouvreBloc("<p>");
		$this->ajouteLigne("Liste des jeux en retard");
		$this->ajouteLigne("<br/>");

		
		 
		$this->ajouteLigne("<br/>");
	
		$this->tabJeuxNonRendu = $this->baseDonnees->selectJeuxNonRendus();
		$this->afficherJeuxNonRendu($this->tabJeuxNonRendu);
		
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne("Légende : ");

		$this->ouvrebloc("<TABLE>");
			$this->ouvrebloc("<TR>");
				$this->ouvrebloc("<TD class='retard1'>");
					$this->ajouteLigne($this->convertiTexte("3 semaines et plus"));
				$this->fermebloc("</TD>");
				$this->ouvrebloc("<TD class='retard2'>");
					$this->ajouteLigne($this->convertiTexte("2 semaines "));
				$this->fermebloc("</TD>");
				$this->ouvrebloc("<TD class='retard3'>");
					$this->ajouteLigne($this->convertiTexte("1 semaine"));
				$this->fermebloc("</TD>");
				$this->ouvrebloc("<TD class='retard4'>");
					$this->ajouteLigne($this->convertiTexte("moins d'une semaine"));
				$this->fermebloc("</TD>");			
			$this->fermebloc("</TR>");
		$this->fermebloc("</TABLE>");
		$this->fermeBloc("</p>");
		$this->fermeBloc("</div>");
		
		
		
    }
	
	
	/**
	* Fonction permettant la récupération de la description d'un jeu
	*/ 
	public function afficherTableau($tableau,$nomColonne,$typeLien)
	{
		$iBoucle=0;
		$bool=1;
		while ($bool==1) {
			if ($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,$nomColonne)) != null){
				if ($typeLien!=null){
					$this->ajouteLigne("<a href=".MODULE_RECHERCHE."&".$typeLien."=".$this->convertiTexte(str_replace(' ','+',$this->recupColonnes($tableau,$iBoucle,$nomColonne))).">".$this->convertiTexte($this->recupColonnes($tableau,$iBoucle,$nomColonne))."</a>"."<br/>");		
				}
				else{
					$this->ajouteLigne($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,$nomColonne))."<br/>");		
				}
				$iBoucle++;
			}	
			else $bool=0;
		}
	}
	/**
	* Fonction permettant la récupération du nom (=langue)
	* mettre une variable en param, et un while dans affiche!
	*/ 
	public function recupColonnes($tableau,$ligneNumero,$nomColonne)
	{
		if ($tableau[$ligneNumero][$nomColonne]!=null)
 		 return $tableau[$ligneNumero][$nomColonne];
		 else return null;
	}
	
	
	/**
	* Fonction permettant la récupération de la description d'un jeu
	*/ 
	public function afficherJeuxNonRendu($tableau)
	{
		$iBoucle=0;
		$bool=1;
		$retard;
		$this->ouvrebloc("<TABLE>");
			$this->ouvrebloc("<TR>");
				$this->ouvrebloc("<TH>");
					$this->ajouteLigne($this->convertiTexte("Date Retour "));
				$this->fermebloc("</TH>");
				$this->ouvrebloc("<TH>");
					$this->ajouteLigne($this->convertiTexte("Nom d'utilisateur "));
				$this->fermebloc("</TH>");
				$this->ouvrebloc("<TH>");
					$this->ajouteLigne($this->convertiTexte("Nom Jeu"));
				$this->fermebloc("</TH>");
				$this->ouvrebloc("<TH>");
					$this->ajouteLigne($this->convertiTexte("Nom Version "));
				$this->fermebloc("</TH>");
				$this->ouvrebloc("<TH>");
					$this->ajouteLigne($this->convertiTexte("e-mail "));
				$this->fermebloc("</TH>");
			
			$this->fermebloc("</TR>");
		
		
		
		while ($bool==1) {
			if ($this->recupColonnes($tableau,$iBoucle,ID_EXEMPLAIRE) != null){
				
				if (round((strtotime($this->recupColonnes($tableau,$iBoucle,DATE_ACTUELLE))-
				strtotime($this->recupColonnes($tableau,$iBoucle,DATE_RETOUR_SOUHAITE)))/(60*60*24)) > 21)
					$retard="retard1";
				elseif (round((strtotime($this->recupColonnes($tableau,$iBoucle,DATE_ACTUELLE))-
				strtotime($this->recupColonnes($tableau,$iBoucle,DATE_RETOUR_SOUHAITE)))/(60*60*24)) > 14)
					$retard="retard2";
				elseif (round((strtotime($this->recupColonnes($tableau,$iBoucle,DATE_ACTUELLE))-
				strtotime($this->recupColonnes($tableau,$iBoucle,DATE_RETOUR_SOUHAITE)))/(60*60*24)) > 7)
					$retard="retard3";
				else $retard="retard4";
				$this->ouvreBloc("<TR>");
					$this->ouvrebloc("<TD class='".$retard."'>");
						$this->ajouteLigne($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,DATE_RETOUR_SOUHAITE)));
					$this->fermebloc("</TD>");
					$this->ouvrebloc("<TD class='".$retard."'>");
						$this->ajouteLigne($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,USERNAME)));
					$this->fermebloc("</TD>");
					$this->ouvrebloc("<TD class='".$retard."'>");
					$this->ajouteLigne($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,NOM_JEU)));
					$this->fermebloc("</TD>");
					$this->ouvrebloc("<TD class='".$retard."'>");
						$this->ajouteLigne($this->convertiTexte($this->recupColonnes($tableau,$iBoucle,NOM_VERSION)));
					$this->fermebloc("</TD>");
					$this->ouvrebloc("<TD class='".$retard."'>");
						$this->ajouteLigne("<a href=\"mailto:".$this->convertiTexte($this->recupColonnes($tableau,$iBoucle,USER_EMAIL))."?subject= ".MAIL_OBJECT." &body=".MAIL_BODY."\">".$this->recupColonnes($tableau,$iBoucle,USER_EMAIL)."</a>");
					$this->fermebloc("</TD>");
				$this->fermebloc("</TR>");
		
			$iBoucle++;		
			}	
			else $bool=0;
		}
		$this->fermebloc("</TABLE>");
		
		
		
	}
	
}

?>
