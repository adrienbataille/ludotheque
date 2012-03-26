<?php
/**
* Classe du module "FicheJeu"
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_FICHEJEU", RACINE_SITE . "module.php?idModule=FicheJeu");

class ModuleFicheJeu extends Module
{

// Attributs
	private $monJeu = NULL;
	private $monJeuLangue = NULL;
	private $baseDonnees = NULL;

// Methodes

	/**
	* Le constructeur du module FicheJeu
	*/
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		
		// On récupère l'utilisateur
		$this->monJeu = 1;
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		
		
		// On affiche le contenu du module
			// On affiche le formulaire de consultation/modification des informations propres à l'utilisateur
		
		$this->baseDonnees = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		

		$this->monJeu = $this->baseDonnees->recupInfoJeu(1);
		$this->afficheInfoJeu();
		$this->monJeuLangue = $this->baseDonnees->recupJeuLangue(1);
		$this->afficheJeuLangue();
		
		
		
		//$this->affiche();

		
	}
	
	private function affiche()
    {
        $this->ouvreBloc("<p>");
        $this->ajouteLigne("Hello World");
        $this->fermeBloc("</p>");
    }

	
	/**
	* Fonction d'affichage des informations non modifiables
	*/
	private function afficheInfoJeu()
	{
		$this->ouvreBloc("<form method='post' action='" .
			MODULE_PROFIL . "' id='formProfil'>");
			$this->ouvreBloc("<p>");
			
				$this->ouvreBloc("<fieldset>");
					$this->ouvreBloc("<ol>");
						//Bloc Nom du Jeu & Nom de Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne($this->convertiTexte($this->recupNomVersion())."<br/>");

						$this->fermeBloc("</li>");
						
						//Bloc Info Jeu & Info Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne($this->convertiTexte($this->recupAuteur())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupAgeMinimum())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupNbJoueurRecommande())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupDureePartie())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupPrixAchat())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupAnneeSortie())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupIllustrateur())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupDistributeur())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupEditeur())."<br/>");
							
							
						$this->fermeBloc("</li>");
						
						//Bloc Info Jeu & Info Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne($this->convertiTexte($this->recupDescriptionJeu())."<br/>");
							$this->ajouteLigne($this->convertiTexte($this->recupDescriptionVersion())."<br/>");
						$this->fermeBloc("</li>");
					
				
				

				
					
					$this->fermeBloc("</ol>");
				$this->fermeBloc("</fieldset>");			
			$this->fermeBloc("</p>");
		$this->fermeBloc("</form>");
	}
	
	/**
	* Fonction d'affichage des informations non modifiables
	*/
	private function afficheJeuLangue()
	{
		$this->ouvreBloc("<p>");
		// Affichage des (noms = )langues du jeu
		$iBoucle=0;
		$bool=1;
		while ($bool==1) {
			if ($this->convertiTexte($this->recupNomLangue($iBoucle)) != null){
				$this->ajouteLigne($this->convertiTexte($this->recupNomLangue($iBoucle))."<br/>");
				$iBoucle++;
			}
			else $bool=0;
		}
		
	$this->fermeBloc("</p>");
	}
	
	/**
	* Fonction permettant la récupération de la description d'un jeu
	*/ 
	public function recupDescriptionJeu()
	{
		 return $this->monJeu[DESCRIPTION_JEU];
	}
	
	/**
	* Fonction permettant la récupération de l'auteur d'un jeu
	*/ 
	public function recupAuteur()
	{
		 return $this->monJeu[AUTEUR];
	}
	
	
	/**
	* Fonction permettant la récupération de la description d'une version
	*/ 
	public function recupDescriptionVersion()
	{
		 return $this->monJeu[DESCRIPTION_VERSION];
	}
	
	/**
	* Fonction permettant la récupération du nom d'une version
	*/ 
	public function recupNomVersion()
	{
		 return $this->monJeu[NOM_VERSION];
	}
	
	/**
	* Fonction permettant la récupération de l'age minimum
	*/ 
	public function recupAgeMinimum()
	{
		 return $this->monJeu[AGE_MINIMUM];
	}
	/**
	* Fonction permettant la récupération du nombre de joueurs recommandé
	*/ 
	public function recupNbJoueurRecommande()
	{
		 return $this->monJeu[NB_JOUEUR_RECOMMANDE];
	}
	/**
	* Fonction permettant la récupération de la durée d'un partie
	*/ 
	public function recupDureePartie()
	{
		 return $this->monJeu[DUREE_PARTIE];
	}
	/**
	* Fonction permettant la récupération du prix d'achat
	*/ 
	public function recupPrixAchat()
	{
		 return $this->monJeu[PRIX_ACHAT];
	}
	/**
	* Fonction permettant la récupération de l'année de sortie de la version
	*/ 
	public function recupAnneeSortie()
	{
		 return $this->monJeu[ANNEE_SORTIE];
	}
	/**
	* Fonction permettant la récupération de l'illustrateur d'une version
	*/ 
	public function recupIllustrateur()
	{
		 return $this->monJeu[ILLUSTRATEUR];
	}
	/**
	* Fonction permettant la récupération du distributeur d'une version
	*/ 
	public function recupDistributeur()
	{
		 return $this->monJeu[DISTRIBUTEUR];
	}
	/**
	* Fonction permettant la récupération de l'editeur d'une version
	*/ 
	public function recupEditeur()
	{
		 return $this->monJeu[EDITEUR];
	}
	
	/**
	* Fonction permettant la récupération du nom (=langue)
	* mettre une variable en param, et un while dans affiche!
	*/ 
	public function recupNomLangue($langueNumero)
	{
		if ($this->monJeuLangue[$langueNumero][NOM_JEU]!=null)
 		 return $this->monJeuLangue[$langueNumero][NOM_JEU];
		 else return null;
	}
}



?>
