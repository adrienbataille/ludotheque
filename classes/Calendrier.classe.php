<?php
/**
* Classe de gestion du calendrier MDJT
* 
*
* 
*/

// Inclusions

//Constantes
define("EMPLACEMENT_CALENDRIER", "http://www.google.com/calendar/feeds/agenda%40mdjt.org/public/full?futureevents=true&sortorder=ascending");

class Calendrier
{

// Attributs
	// Le chargement du calendrier depuis google est-il réussi ?
	// Pour pallier aux potentielles indisponibilités du google calendar
	private $chargementReussi;
	// Titre du calendrier
	private $titre;
	// Sous-titre du calendrier
	private $sousTitre;
	// Lien vers le calendrier
	private $lien;
	// Tableau des évènements récurrents
	private $evenementsRecurrents;
	// Tableau des évènements
	private $evenements;
	// Filtre des évènements - 
	// les évènements dont le titre contient les chaines du tableau ne sont pas affichés 
	private $filtre = array("permanence");
  

// Méthodes


/*
* Le constructeur d'un calendrier
* Le constructeur récupère les informations sur le calendrier google
*/
	public function __construct()
	{
		// Chargement du calendrier
		$this->chargeCalendrier();
		// Si l'agenda google est accessible
		if ($this->chargementReussi)
		{
			// Filtrage des évenements
			$this->evenements = $this->filtreListe($this->evenements);
			// Trie du calendrier
			$this->trieListe();
			// Conversion des dates en un format affichable
			$this->evenements = $this->convertiDatesListe($this->evenements);
		}	
	}
	
	//
	// Outils à usage interne
	//
	
	/**
	* Fonction d'extraction de date dans la chaine xml
	* Converti la date au format google en date dans un format triable
	* AAAA-MM-JJ -> AAAAMMJJ
	*/
	private function extraitDateComparable($uneDate)
	{
		$annee = substr($uneDate,0,4);
		$mois = substr($uneDate,5,2);
		$jour = substr($uneDate,8,2);
		$date = $annee . $mois . $jour;
		return $date;				
	}
	
	/**
	* Fonction de validation de date
	* retourne true si la date est posterieur à la date actuelle
	* Necessite une date comparable (au format AAAAMMJJ)
	*/
	private function verifieDate($uneDate)
	{
		$unEntier = strcmp(date("Ymd"),$uneDate);
		if ($unEntier <=0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	
	/**
	* Fonction de filtrage des évènements
	* Cette fonction renvoie faux si l'évènement contient la chaine FILTRE
	*/
	private function estValide($evenement)
	{		
		$compteur = 0;
		foreach ($this->filtre as $unFiltre)
		{
			$compteur += substr_count(strtolower($evenement["titre"]),$unFiltre);
		}
		if ($compteur == 0)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	/**
	* Fonction de conversion des dates
	* Converti les dates comparables en date affichable
	* AAAAMMJJ -> jj/mm/aaaa
	*/
	private function formateDate($uneDate)
	{
		$annee = substr($uneDate,0,4);
		$mois = substr($uneDate,4,2);
		$jour = substr($uneDate,6,2);
		$date = $jour . "/" . $mois . "/" . $annee;
		return $date;
	}
	
	/**
	* Fonction de récupération de l'heure dans une date
	*/
	private function extraitHeure($uneDate)
	{
		return substr($uneDate,11,5);
		
	}
	

	/**
	* Fonction de récupération du calendrier depuis google
	*/
	private function chargeCalendrier()
	{
		// Récupération du calendrier depuis google
		// sous la forme d'une chaine de caractères
		$contenuCalendrier = file_get_contents(EMPLACEMENT_CALENDRIER);
		// On vérifie si le chargement s'est bien passé
		if ($contenuCalendrier != false)
		{
			// Filtrage, on remplace les gd: par gd pour leur permettre de s'afficher aux balises gd d'apparaitre dans le XML
			$contenuCalendrier = str_replace("gd:","gd",$contenuCalendrier);
			// Création d'un objet SimpleXML qui va nous servir à manipuler le calendrier
			$contenuCalendrier = new SimpleXMLElement($contenuCalendrier);
			// Récupération des informations globales du calendrier			
			// Récupération du titre du calendrier
			$this->titre = (String)$contenuCalendrier->title;
			// Récupération du sous titre
			$this->sousTitre = (String)$contenuCalendrier->subtitle;
			// Récupération du lien vers le calendrier
			$this->lien = (String)$contenuCalendrier->link->attributes()->href;
			// On récupère les entrées du calendrier - sous la forme d'un tableau
			// Balise <entry> du document xml
			$entreesCalendrier = $contenuCalendrier->entry;
			// On parcours l'ensemble des entrées
			foreach($entreesCalendrier as $entree)
			{
				// On regarde si l'évènement est récurrent
				if ((String)$entree->gdrecurrence != "")
				{
					// Si l'évènement est récurrent
					// Remise à zero du tableau 
					$evenement = NULL;
					// On crée un tableau pour récupérer l'évènement
					$evenement["lien"] = (String)$entree->link->attributes()->href;
					$evenement["titre"] = (String)$entree->title;
					$evenement["description"] = (String)$entree->content;
					$evenement["lieu"] = (String)$entree->gdwhere->attributes()->valueString;
					$evenement["recurrence"] = (String)$entree->gdrecurrence;
					// On rentre cet évènement dans le tableau des évènements récurrents
					$this->evenementsRecurrents[]=$evenement;
					// On rajoute toutes les dates de l'évènement récurrent dans les évènements
					$listeDate = $entree->gdwhen;
					foreach ($listeDate as $date)
					{
						$evenement["dateDebut"] = $this->extraitDateComparable((String)$date->attributes()->startTime);
						$evenement["heureDebut"] = $this->extraitHeure((String)$date->attributes()->startTime);
						$evenement["dateFin"] = $this->extraitDateComparable((String)$date->attributes()->endTime);
						$evenement["heureFin"] = $this->extraitHeure((String)$date->attributes()->endTime);
						// Si la date de début est une date future (donc valide)
						if ($this->verifieDate($evenement["dateDebut"]))
						{
							// On ajoute l'évènement					
							$this->evenements[]=$evenement;
						}
						// Sinon, rien - on ajoute pas les évènements passés
					}
				}
				else // Si c'est un évènement unique 
				{
					// Remise à zero du tableau
					$evenement = NULL;
					// On crée un tableau pour récupérer l'évènement
					$evenement["lien"] = (String)$entree->link->attributes()->href;
					$evenement["titre"] = (String)$entree->title;
					$evenement["description"] = (String)$entree->content;
					$evenement["lieu"] = (String)$entree->gdwhere->attributes()->valueString;
					$evenement["dateDebut"] = $this->extraitDateComparable((String)$entree->gdwhen->attributes()->startTime);
					$evenement["heureDebut"] = $this->extraitHeure((String)$entree->gdwhen->attributes()->startTime);
					$evenement["dateFin"] = $this->extraitDateComparable((String)$entree->gdwhen->attributes()->endTime);
					$evenement["heureFin"] = $this->extraitHeure((String)$entree->gdwhen->attributes()->endTime);
					// On rentre cet évènement dans le tableau des évènements
					$this->evenements[]=$evenement;
				}				
			}
			$this->chargementReussi = true;
		}
		// Si le chargement du calendrier n'a pas réussi
		else
		{
			$this->chargementReussi = false;
		}
	}
	
	/**
	* Fonction de filtrage des evenements
	* Renvoie la liste des événements sans ceux dont le titre correspond au filtre défini
	*/
	private function filtreListe($uneListe)
	{
		$listeFiltree=null;
		foreach ($uneListe as $unEvenement)
		{
			// Si l'evenement est valide
			if ($this->estValide($unEvenement))
			{
				// On le garde
				$listeFiltree[]=$unEvenement;
			}
		}
		return $listeFiltree;
	}

	/**
	* Fonction de comparaison d'évènement
	* cette fonction compare les dates de début, puis les heures de début
	* renvoie un entier <0 si le premier évènement est plus petit (avant) le second
	* =0 si les deux évènements sont simultanées
	* >0 si le premier est plus grand (après) le second)
	*/
	static function compareEvenement($unEvenement, $unAutreEvenement)
	{
		$differenceDate = strcmp($unEvenement["dateDebut"],$unAutreEvenement["dateDebut"]);
		// Si les deux evenements ont lieu le même jour
		if ($differenceDate == 0)
		{
			// On compare leur heure de debut
			return strcmp($unEvenement["heureDebut"],$unAutreEvenement["heureDebut"]);
		}
		else 
		{
			return $differenceDate;
		}
	}
	
	/**
	* Fonction de tri des événements
	*/
	private function trieListe()
	{
		usort($this->evenements, "Calendrier::compareEvenement");
	}
	
	/**
	* Fonction de formatage des dates des evenements
	* Renvoie le tableau des evenements ou toutes les dates ont été convertie
	* en date affichable
	*/
	private function convertiDatesListe($uneListe)
	{
		$listeFormatee = NULL;
		foreach($uneListe as $unEvenement)
		{
			$unEvenement["dateDebut"] = $this->formateDate($unEvenement["dateDebut"]);
			$unEvenement["dateFin"] = $this->formateDate($unEvenement["dateFin"]);
			$listeFormatee[] = $unEvenement;
		}
		return $listeFormatee;
	} 
	
		

	//
	// Récupération des informations
	//
			
	/**
	* Fonction de récupération des évènements
	* un evenement est un tableau de la forme :
	* ["lien"] => (String)
	* ["titre"] => (String)
	* ["description"] => (String)
	* ["lieu"] => (String)
	* ["dateDebut"] => (String)
	* ["heureDebut"] => (String)
	* ["dateFin"] => (String)
	* ["heureFin" => (String)
	*/
	public function recupEvenements()
	{
		if ($this->chargementReussi)
		{
			return $this->evenements;
		}
		else 
		{
			return array(array("lien" => RACINE_SITE, 
			"titre" => "Pas d'évènements", 
			"description" => "",
			"lieu" => "", 
			"dateDebut" => "",
			"heureDebut" => "",
			"dateFin" => "",
			"heureFin" => ""));
		}
	}

	/**
	* Fonction de récupération d'un évènement par son numéro d'index
	*/
	public function recupEvenement($numero)
	{
		if ($this->chargementReussi)
		{
			return $this->evenements[$numero];
		}
		else 
		{
			return array("lien" => RACINE_SITE, 
			"titre" => "Pas d'évènements", 
			"description" => "",
			"lieu" => "", 
			"dateDebut" => "",
			"heureDebut" => "",
			"dateFin" => "",
			"heureFin" => "");
		}
	}
	
	//
	// Outils à usage externe
	//
	
	/**
	* Fonction de récupération du jour d'un évènement
	*/
	public static function recupJour($unEvenement)
	{
		return substr($unEvenement["dateDebut"],0,2);	
	}
}

?>
