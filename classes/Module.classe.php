<?php
/**
* Classe mère des classes modules
* Elle définit les fonctions qu'un module doit avoir pour s'afficher correctement
* @package module
*/

// Inclusions

//Constantes

class Module
{

// Attributs
	// La chaine de caractères qui contient la page HTML qu'on génère
	protected $contenuHTML;
	// Un entier qui garde mémoire du niveau actuel, pour une identation propre
	private $niveauIndentation;

// Methodes

	/*
	* Le constructeur d'un module
	*/
	public function __construct()
	{
		// Initialisation du contenu HTML du module
		$this->contenuHTML = "";
		// Le niveau d'indentation d'une page neuve est 0
		$this->niveauIndentation = 0;
	}
 
 	
	/*
	* Fonction permettant de récupérer le contenu HTML d'un module, pour l'afficher
	*/ 
	public function recupContenu()
	{
		return $this->contenuHTML;
	}

 	//
 	// Outils à usage des classes filles
 	//

	
	/**
	* Fonction d'indentation du code HTML en fonction du niveau courant
	* Renvoie les espaces nécessaires à indenter
	*/
	private function indente()
	{
		$espace = "";
		for ($i=0; $i<$this->niveauCourant; $i++)
		{
			$espace .= TABULATION;
		}
		return $espace;			
	}
	
	/**
	* Fonction d'ouverture d'un bloc HTML
	*/
	protected function ouvreBloc($HTML)
	{
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $HTML;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";
		// Augmentation du niveau d'indentation courant
		$this->niveauCourant = $this->niveauCourant + 1;
	}
	
	/**
	* Fonction de fermeture d'un bloc HTML
	*/
	protected function fermeBloc($html)
	{
		// Diminution du niveau d'indentation courant
		$this->niveauCourant = $this->niveauCourant - 1;
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $html;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";	
	}

	/**
	* Fonction d'ajout de balise dans un bloc
	*/
	protected function ajouteLigne($html)
	{
		// Ajout de l'indentation
		$this->contenuHTML .= $this->indente();
		// Affichage de la balise HTML
		$this->contenuHTML .= $html;
		// Ajout d'un saut de ligne
		$this->contenuHTML .= "\n";
	}
	
	/**
	* Fonction de conversion texte -> HTML
	* Renvoie le texte au format HTML
	*/
	protected function convertiTexte($texte)
	{
		return htmlentities($texte, ENT_QUOTES, "UTF-8");
	}

}

?>
