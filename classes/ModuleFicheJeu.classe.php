<?php
/**
* Classe du module "FicheJeu"
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_FICHEJEU", RACINE_SITE . "module.php?idModule=FicheJeu");
define("ADMINISTRATEUR", "Administrateur");

class ModuleFicheJeu extends Module
{

// Attributs
/*
	private $monUtilisateur = NULL;
	private $monJeu = NULL;
	private $monJeuLangue = NULL;
	private $baseDonnees = NULL;
	private $maPhotoVersion = NULL;*/

// Methodes

	/**
	* Le constructeur du module FicheJeu
	*/
	public function __construct($unUtilisateur)
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();

		// On récupère l'utilisateur et le jeu
		$this->monUtilisateur = $unUtilisateur;
		$this->monJeu = 4;
		
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		
		
		// On affiche le contenu du module

		
		$this->baseDonnees = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		
		
		// En entrée : l'idJeu
		$this->monJeuLangue = $this->baseDonnees->recupJeuLangue(4);
		// En entrée : l'idVersion
		$this->monJeu = $this->baseDonnees->recupInfoJeu(2);
		$this->maPhotoVersion = $this->baseDonnees->recupPhotoVersion(2);
		$this->afficheInfoJeu();
		
		//Affichage des liens de modifications en fonction du type de l'utilisateur
		if($this->utilisateurEstAdmin())
			$this->afficherModifier();
	}
	
	
	/**
	* Fonction permettant de verifier que l'utilisateur est un ADMINISTRATEUR
	*/
	private function utilisateurEstAdmin()
	{
		if ($this->monUtilisateur->recupTypeAdherent() == ADMINISTRATEUR ) return 1;
		else return 0;
	}
	
	/**
	* Fonction permettant d'afficher un bouton "modifier"
	*/
	private function afficherModifier()
	{
		$this->ajouteLigne(/*<href>..........*/$this->convertiTexte("Modifier!"));
	}
	
	/**
	* Fonction d'affichage des differents noms du jeu
	*/
	/*
	private function afficheJeuLangue()
	{
	$this->ouvreBloc("<form method='post' action='" .MODULE_PROFIL . "' id='formProfil'>");
		$this->ouvreBloc("<p>");
			$this->ouvreBloc("<fieldset>");
				$this->ajouteLigne("<legend>Fiche du jeu</legend>");
				$this->ouvreBloc("<ol>");
					$this->ouvreBloc("<li>");
						$this->ajouteLigne("<label>" .$this->convertiTexte("Nom du jeu") ."</label>");
						
						$iBoucle=0;
						$bool=1;
						while ($bool==1) {
							if ($this->convertiTexte($this->recupNomLangue($iBoucle)) != null){
								
								$this->ajouteLigne($this->convertiTexte($this->recupNomLangue($iBoucle))."<br/>");		
								$iBoucle++;
							}
							else $bool=0;
						}
					$this->fermeBloc("</li>");
				$this->fermeBloc("</ol>");
			$this->fermeBloc("</fieldset>");			
		$this->fermeBloc("</p>");
	$this->fermeBloc("</form>");
	}
	*/

	
	/**
	* Fonction d'affichage des informations non modifiables
	*/
	private function afficheInfoJeu()
	{
		$this->ouvreBloc("<form method='post' action='" .MODULE_PROFIL . "' id='formProfil'>");
		$this->ouvreBloc("<p>");
			$this->ouvreBloc("<fieldset>");
				$this->ajouteLigne("<legend>Fiche du jeu</legend>");
				$this->ouvreBloc("<ol>");
					$this->ouvreBloc("<li>");
						$this->ajouteLigne("<label>" .$this->convertiTexte("Nom du jeu") ."</label>");
						
						$iBoucle=0;
						$bool=1;
						while ($bool==1) {
							if ($this->convertiTexte($this->recupNomLangue($iBoucle)) != null){
								
								$this->ajouteLigne($this->convertiTexte($this->recupNomLangue($iBoucle))."<br/>");		
								$iBoucle++;
							}
							else $bool=0;
						}
						//$this->fermeBloc("</li>");

					
						//Bloc Nom du Jeu & Nom de Version
						//$this->ouvreBloc("<li>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Nom de la version") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupNomVersion())."<br/>");
						$this->fermeBloc("</li>");
						
						//Bloc de la Photo associée à la Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Photo !!") ."</label>");
							$this->ajouteLigne("<img src=images/photo/".$this->convertiTexte($this->recupPhotoVersion()).">");
						$this->fermeBloc("</li>");
						
						//Bloc Info Jeu & Info Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Auteur") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupAuteur())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Age min.") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupAgeMinimum())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Joueurs recommandés") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupNbJoueurRecommande())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Durée moyenne") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupDureePartie())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Prix d'achat") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupPrixAchat())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Année de sortie") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupAnneeSortie())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Illustrateur") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupIllustrateur())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Distributeur") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupDistributeur())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Editeur") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupEditeur())."<br/>");	
						$this->fermeBloc("</li>");
						
						//Bloc Info Jeu & Info Version
						$this->ouvreBloc("<li>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Description du jeu") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupDescriptionJeu())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Description de la version") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupDescriptionVersion())."<br/>");
						$this->fermeBloc("</li>");
						
					$this->fermeBloc("</ol>");
				$this->fermeBloc("</fieldset>");			
			$this->fermeBloc("</p>");
		$this->fermeBloc("</form>");
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
	* Fonction permettant la récupération de l'editeur d'une version
	*/ 
	public function recupPhotoVersion()
	{
		 return $this->maPhotoVersion[0][NOM_PHOTO];
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
