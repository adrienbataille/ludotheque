<?php
/**
* Classe du module "FicheJeu"
*/

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_FICHEJEU", RACINE_SITE . "module.php?idModule=FicheJeu");
define("MODULE_RECHERCHE",RACINE_SITE."/module.php?idModule=Recherche");
define("ADMINISTRATEUR", "Administrateur");
define("DIEU","Dieu");


class ModuleFicheJeu extends Module
{

// Attributs

	private $monUtilisateur = NULL;
	private $monJeu = NULL;
	private $infosJeu = NULL;
	private $maVersion = NULL;
	private $monJeuLangue = NULL;
	private $baseDonnees = NULL;
	private $maPhotoVersion = NULL;

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
		
		//if (intval($_GET["idVersion"])
		//http://127.0.0.1/ludotheque/module.php?idModule=FicheJeu&idVersion=1
		$this->maVersion = $_GET["idVersion"];
		if ($this->maVersion==null){
			header('Location:' . PAGE_INDEX);
		}
		//$this->maVersion=1;
			
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		
		
		// On affiche le contenu du module
		$this->baseDonnees = AccesAuxDonneesDevFicheJeu::recupAccesDonneesDev();
		
		// En entrée : l'idVersion
		$this->infosJeu = $this->baseDonnees->recupInfoJeu($this->maVersion);
		$this->maVersionIllustrateur = $this->baseDonnees->recupIllustrateurs($this->maVersion);
		$this->maVersionDistributeur = $this->baseDonnees->recupDistributeurs($this->maVersion);
		$this->maVersionEditeur = $this->baseDonnees->recupEditeurs($this->maVersion);
		$this->mesExemplaires = $this->baseDonnees->recupExemplaire($this->maVersion);
		$this->maPhotoVersion = $this->baseDonnees->recupPhotoVersion($this->maVersion);
		$this->maCategorie = $this->baseDonnees->recupCategorie($this->maVersion);
		
		// On recupere l'id du jeu dans la version
		$this->monJeu = $this->recupIdJeu();
		
		// En entrée : l'idJeu
		$this->monJeuLangue = $this->baseDonnees->recupJeuLangue($this->monJeu);
		$this->monJeuAuteur = $this->baseDonnees->recupAuteurs($this->monJeu);
		
		// On affiche les informations
		$this->afficheInfoJeu();
		
		//Affichage des liens de modifications en fonction du type de l'utilisateur
		if($this->testGroupe())
			$this->afficherModifier();		
	
	}
	
	
	
	/**
	* Fonction permettant de verifier que l'utilisateur est un ADMINISTRATEUR
	*/
	private function testGroupe()
	{
		$var=$this->monUtilisateur->recupGroupes();
		if ($var[0] == DIEU ) return 1;
		else return 0;
	}
	
	/**
	* Fonction permettant de verifier que l'utilisateur est un ADMINISTRATEUR
	*/
	private function utilisateurEstAdmin2()
	{
		if ($this->monUtilisateur->recupTypeAdherent() == ADMINISTRATEUR ) return 1;
		else return 0;
	}
	
	/**
	* Fonction permettant d'afficher un bouton "modifier"
	*/
	private function afficherModifier()
	{
		$this->ajouteLigne(/*<a href>..........*/"<button>".$this->convertiTexte("Modifier!")."</button>");
	}
	
	
	/**
	* Fonction d'affichage des informations 
	*/
	private function afficheInfoJeu()
	{
		$this->ouvreBloc("<form method='post' action='" .MODULE_JEU . "' id='formJeu'>");
			$this->ouvreBloc("<p>");
				$this->ouvreBloc("<fieldset>");
					$this->ajouteLigne("<legend>Fiche du jeu</legend>");
					//$this->ouvreBloc("<ol>");
						//Bloc Nom du Jeu & Nom de Version
						$this->ouvreBloc("<div>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Nom du jeu") ."</label>");
							$this->afficherTableau($this->monJeuLangue,NOM_JEU,null);
							$this->ajouteLigne("<label>" .$this->convertiTexte("Nom de la version") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupNomVersion())."<br/>");
						$this->fermeBloc("</div>");
						
						// Block central qui contient le block photo et le block info
						$this->ouvreBloc("<div id=".bloc_cent." >");
							//Bloc de la Photo associée à la Version
							$this->ouvreBloc("<div id=".photo."  >");		
								$this->ajouteLigne("<img src=images/photo/".$this->convertiTexte($this->recupPhotoVersion()).">");
							$this->fermeBloc("</div>");
							
							//Bloc Info Jeu & Info Version
							$this->ouvreBloc("<div id=".info." >");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Auteur(s)") ."</label>");
								$this->afficherTableau($this->monJeuAuteur,NOM_AUTEUR,nom);		
								$this->ajouteLigne("<label>" .$this->convertiTexte("Catégorie(s)") ."</label>");
								$this->afficherTableau($this->maCategorie,NOM_CATEGORIE,nomCategorie);	
								$this->ajouteLigne("<label>" .$this->convertiTexte("Age min.") ."</label>");
								$this->ajouteLigne($this->convertiTexte($this->recupAgeMinimum())." ans"."<br/>");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Joueurs recommandés") ."</label>");
								$this->ajouteLigne($this->convertiTexte($this->recupNbJoueurRecommande())." joueurs"."<br/>");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Durée moyenne") ."</label>");
								$this->ajouteLigne($this->convertiTexte($this->recupDureePartie())."<br/>");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Prix d'achat") ."</label>");
								$this->ajouteLigne($this->convertiTexte($this->recupPrixAchat())." euros"."<br/>");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Année de sortie") ."</label>");
								$this->ajouteLigne($this->convertiTexte($this->recupAnneeSortie())."<br/>");
								$this->ajouteLigne("<label>" .$this->convertiTexte("Illustrateur(s)") ."</label>");
								$this->afficherTableau($this->maVersionIllustrateur,NOM_ILLUSTRATEUR,nomIllustrateur);
								$this->ajouteLigne("<label>" .$this->convertiTexte("Distributeur(s)") ."</label>");
								$this->afficherTableau($this->maVersionDistributeur,NOM_DISTRIBUTEUR,nomDistributeur);
								$this->ajouteLigne("<label>" .$this->convertiTexte("Editeur(s)") ."</label>");
								$this->afficherTableau($this->maVersionEditeur,NOM_EDITEUR,nomEditeur);
							$this->fermeBloc("</div>");
						$this->fermeBloc("</div>");
						
						//Bloc Description Jeu & Description Version
						$this->ouvreBloc("<div id=".description.">");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Description du jeu") ."</label>");
							$this->ajouteLigne($this->convertiTexte($this->recupDescriptionJeu())."<br/>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Description de la version") ."</label>");
							
								$this->ajouteLigne($this->convertiTexte($this->recupDescriptionVersion())."<br/>");
						
						$this->fermeBloc("</div>");
						
						//Bloc Disponibilité
						$this->ouvreBloc("<div>");
							$this->ajouteLigne("<label>" .$this->convertiTexte("Disponibilité") ."</label>");
							$this->afficheMesExemplaires();							
						$this->fermeBloc("</div>");
						
					//$this->fermeBloc("</ol>");
				$this->fermeBloc("</fieldset>");			
			$this->fermeBloc("</p>");
		$this->fermeBloc("</form>");
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
	* Fonction permettant la récupération de la description d'un jeu
	*/ 
	public function recupDescriptionJeu()
	{
		 return $this->infosJeu[DESCRIPTION_JEU];
	}
	
	/**
	* Fonction permettant la récupération de l'auteur d'un jeu
	*/ 
	public function recupAuteur()
	{
		 return $this->infosJeu[AUTEUR];
	}
	
	/**
	* Fonction permettant la récupérer l'id du Jeu
	*/ 
	public function recupIdJeu()
	{
		 return $this->infosJeu[idJeu];
	}
	
	/**
	* Fonction permettant la récupération de la description d'une version
	*/ 
	public function recupDescriptionVersion()
	{
		 return $this->infosJeu[DESCRIPTION_VERSION];
	}
	
	/**
	* Fonction permettant la récupération du nom d'une version
	*/ 
	public function recupNomVersion()
	{
		 return $this->infosJeu[NOM_VERSION];
	}
	
	/**
	* Fonction permettant la récupération de l'age minimum
	*/ 
	public function recupAgeMinimum()
	{
		 return $this->infosJeu[AGE_MINIMUM];
	}
	
	/**
	* Fonction permettant la récupération du nombre de joueurs recommandé
	*/ 
	public function recupNbJoueurRecommande()
	{
		 return $this->infosJeu[NB_JOUEUR_RECOMMANDE];
	}
	
	/**
	* Fonction permettant la récupération de la durée d'un partie
	*/ 
	public function recupDureePartie()
	{
		 return $this->infosJeu[DUREE_PARTIE];
	}
	
	/**
	* Fonction permettant la récupération du prix d'achat
	*/ 
	public function recupPrixAchat()
	{
		 return $this->infosJeu[PRIX_ACHAT];
	}
	
	/**
	* Fonction permettant la récupération de l'année de sortie de la version
	*/ 
	public function recupAnneeSortie()
	{
		 return $this->infosJeu[ANNEE_SORTIE];
	}
	
	/**
	* Fonction permettant la récupération de l'illustrateur d'une version
	*/ 
	public function recupIllustrateur()
	{
		 return $this->infosJeu[NOM_ILLUSTRATEUR];
	}
	
	/**
	* Fonction permettant la récupération du distributeur d'une version
	*/ 
	public function recupDistributeur()
	{
		 return $this->infosJeu[NOM_DISTRIBUTEUR];
	}
	
	/**
	* Fonction permettant la récupération de l'editeur d'une version
	*/ 
	public function recupEditeur()
	{
		 return $this->infosJeu[NOM_EDITEUR];
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
	public function recupColonnes($tableau,$ligneNumero,$nomColonne)
	{
		if ($tableau[$ligneNumero][$nomColonne]!=null)
 		 return $tableau[$ligneNumero][$nomColonne];
		 else return null;
	}

	/**
	* Fonction d'affichage des informations sur les exemplaires
	*/
	private function afficheMesExemplaires()
	{
		$this->ouvreBloc("<p>");
			//Affiche le nombre d'exemplaires dispo
			$iBoucle=0;
			$bool=1;
			while ($bool==1) {
				if ($this->convertiTexte($this->recupDescriptionExemplaire($iBoucle)) != null){
					$iBoucle++;
				}
				else $bool=0;
			}
			$this->ajouteLigne($this->convertiTexte($iBoucle)." exemplaire(s) disponible(s) <br/>");
			
			// Affichage des (noms = )langues du jeu
			$iBoucle=0;
			$bool=1;
			while ($bool==1) {
				
				if ($this->convertiTexte($this->recupDescriptionExemplaire($iBoucle)) != null){
					$this->ajouteLigne(($iBoucle+1)."- ");
					$this->ajouteLigne("lieu: ".$this->convertiTexte($this->recupNomLieuJeu($iBoucle)).", ");
					if($this->testGroupe())
					{
						$this->ajouteLigne("prix MDJT: ".$this->convertiTexte($this->recupPrixMDJT($iBoucle)));
					}
					$this->ajouteLigne("<br/>");
					$iBoucle++;
				}
				else $bool=0;
			}
		$this->fermeBloc("</p>");
	}
	
	/**
	* Fonction permettant la récupération du prix MDJT
	*/ 
	public function recupPrixMDJT($iBoucle)
	{
		 return $this->mesExemplaires[$iBoucle][PRIX_MDJT];
	}
	
	/**
	* Fonction permettant la récupération de l'emplacement d'un jeu
	*/ 
	public function recupNomLieuJeu($exemplaireNumero)
	{
		if ($this->mesExemplaires[$exemplaireNumero][NOM_LIEU]!=null)
 		 return $this->mesExemplaires[$exemplaireNumero][NOM_LIEU];
		 else return null;
	}
	
	/**
	* Fonction permettant la récupération de la description d'un exemplaire
	*/ 
	public function recupDescriptionExemplaire($exemplaireNumero)
	{
		if ($this->mesExemplaires[$exemplaireNumero][DESCRIPTION_EXEMPLAIRE]!=null)
 		 return $this->mesExemplaires[$exemplaireNumero][DESCRIPTION_EXEMPLAIRE];
		 else return null;
	}
}
?>
