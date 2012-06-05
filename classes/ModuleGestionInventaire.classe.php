<?php
/** 
 * Module Emprunt
 * @package composant
 */
// Inclusions
require_once("classes/Module.classe.php");


//Constantes
define("MODULE_GESTION_INVENTAIRE", RACINE_SITE . "module.php?idModule=GestionInventaire");

/**
 * Module GestionEmprunt
 * @author Romain Laï-King
 * @version 0.1
 * @package module
 */


class ModuleGextionInventaire extends Module
{
	/**
	 * @var AccesAuxDonneesDev Connexion BDD
	 */
	private $maBase = NULL;

	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
		$this->afficheFormulaire();		

	}
	/**
	 * Affiche le formulaire de recherche
	 */
	private function afficheFormulaire()
	{
		$this->ouvreBloc("<div id='module_emprunter'>");
			
		$this->ouvreBloc("<form method='post' action='" . MODULE_INVENTAIRE . "' id='formProfil'>");        
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<input type='hidden' name='inventaire' value='true' />");
		$this->ajouteLigne("<button type='submit' name='inventaire' value='true'>" . $this->convertiTexte("Inventaire") . "</button>");
		$this->fermeBloc("</fieldset>");		
		$this->fermeBloc("</form>");
		
		$listeIdExemplaireAInventorier = $this->maBase->recupListeInventaireNonFait();
		if(sizeof($listeIdExemplaireAInventorier) > 0) {
			$this->ouvreBloc("<table>");
			
			$this->ouvreBloc("<tr>");
			
			$this->ouvreBloc("<td>");
			$this->ajouteLigne("Nom du jeu");
			$this->fermeBloc("</td>");
			
			$this->ouvreBloc("<td>");
			$this->ajouteLigne("Code barre");
			$this->fermeBloc("</td>");
			
			$this->ouvreBloc("<td>");
			$this->ajouteLigne("Date du dernier inventaire");
			$this->fermeBloc("</td>");
			
			$this->ouvreBloc("<td>");
			$this->ajouteLigne("Dernier état connu");
			$this->fermeBloc("</td>");
			
			$this->fermeBloc("</tr>");
			
			foreach($listeIdExemplaireAInventorier as $myIdExemplaire) {
				$myExemplaire = $this->maBase->recupExemplaire($myIdExemplaire[ID_EXEMPLAIRE]);
				
				$this->ouvreBloc("<tr>");
				
				$idVersion = $this->maBase->recupVersion($myExemplaire[ID_VERSION]);
				$idJeu = $this->maBase->recupNomJeu($idVersion[0][ID_JEU]);
				$this->ouvreBloc("<td>");
				$this->ajouteLigne($idJeu[$idVersion[0][ID_JEU]][0][NOM_JEU] . " - " . $idVersion[0][NOM_VERSION]);
				$this->fermeBloc("</td>");
				
				$this->ouvreBloc("<td>");
				$this->ajouteLigne("<a href='" . MODULE_INVENTAIRE . "&idExemplaire=" . $myExemplaire[0][ID_EXEMPLAIRE] . "' title='Inventaire de l'exemplaire'>" . $myExemplaire[0][CODE_BARRE] . "</a>");
				$this->fermeBloc("</td>");
				
				$this->ouvreBloc("<td>");
				$this->ajouteLigne($myIdExemplaire[1]);
				$this->fermeBloc("</td>");
				
				$etat = $this->maBase->recupEtatPhysique($myExemplaire[0][ID_ETAT_PHYSIQUE]);
				$this->ouvreBloc("<td>");
				$this->ajouteLigne($etat[0][NOM_ETAT]);
				$this->fermeBloc("</td>");
				
				$this->fermeBloc("</tr>");
			}
			$this->fermeBloc("</table>");
		}
		
				
		$this->fermeBloc("</div>");
	}


}


?>