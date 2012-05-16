<?php

// Inclusions
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_PROFIL", RACINE_SITE . "module.php?idModule=Profil");

/**

 * Classe du module "Mon Profil"

 * Permet le module de gestion du profil d'un utilisateur

 * @package module

 */



class ModuleProfil extends Module
{

// Attributs
	// Objet stockant l'utilisateur courant
	private $monUtilisateur = NULL;
	// A-t-on fait un traitement sur le formulaire
	private $traitementFormulaire = false;
	// L'utilisateur a-t-il été modifié
	private $estModifie = false;
	// Les modifications ont elles été correctement appliquées
	private $modificationOK = true;
	// Il y a une erreur sur l'adresse mail
	private $emailOk = true;

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
			// On affiche les informations non modifiables
		$this->afficheInfo();
		
	}
	
	//
	// Outils à usage interne
	//
		
	/**
	* Fonction de conversion des dates
	* Converti les dates stockée en date affichable
	* AAAA-MM-JJ -> jj/mm/aaaa
	*/
	private function dateBaseToAffichage($uneDate)
	{
		$annee = substr($uneDate,0,4);
		$mois = substr($uneDate,5,2);
		$jour = substr($uneDate,8,2);
		$date = $jour . "/" . $mois . "/" . $annee;
		return $date;
	}
	
	/**
	* Fonction de conversion des dates
	* Converti les dates affichée en date stockable en base
	* jj/mm/aaaa -> AAAA-MM-JJ
	*/
	private function dateAffichageToBase($uneDate)
	{
		$jour = substr($uneDate,0,2);
		$mois = substr($uneDate,3,2);
		$annee = substr($uneDate,6,4);
		$date = $annee . "-" . $mois . "-" . $jour;
		return $date;
	}
        
    /**
	* Fonction de vérification d'une date au format d'affichage
	*/
	private function verifDateAffichee($uneDate)
	{
            if (preg_match('#^([0-9]{2})([/-])([0-9]{2})\2([0-9]{4})$#', $uneDate))
            {
                return checkdate(substr($uneDate,3,2), substr($uneDate,0,2), substr($uneDate,6,4));
            }
            else
            {
                return false;
            }
	}
	
	
	/**
	* Fonction de vérification d'une adresse mail
	*/
	private function verifMail($uneAdresse)
	{
            return (preg_match('/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i', $uneAdresse));
	}
	
	/**
	 * Fonction de nettoyage des chaine de caractères
         * Prends en paramètre la chaine à filtrer, et la taille max de cette chaine
	*/
	private function filtreChaine($uneChaine,$uneTaille)
	{
            // On supprime les \ rajouté par les Magic Quotes. Si il y a lieu
            if (get_magic_quotes_gpc() == 1)
            {
                $uneChaine = stripslashes($uneChaine);
            }
            // On supprime les balises HTML s'il y en avait
            $resultat = strip_tags($uneChaine);
            // On vérifie sa taille
            $resultat = substr($resultat,0,$uneTaille);
            return $resultat;
	}
	
	//
	// Méthodes privées pour la construction et le traitement de la  page
	//

	/**
	* Fonction d'affichage du nom complet de l'utilisateur
	*/
	private function afficheNomUtilisateur()
	{
		return $this->convertiTexte( 
			$this->monUtilisateur->recupTitre() . " " .
			$this->monUtilisateur->recupPrenom() . " " .
			$this->monUtilisateur->recupNom() . " " .
			"(" . $this->monUtilisateur->recupLogin() . ")"
			);
	}
	
	/**
	* Fonction d'affichage des informations non modifiables
	*/
	private function afficheInfo()
	{
		$this->ouvreBloc("<p>");
		// Affichage de l'identifiant de l'utilisateur
		$this->ajouteLigne($this->convertiTexte("Vous êtes connu sur ce site sous le nom de " . $this->monUtilisateur->recupLogin() ) . "<br/>");
		// Affichage de la procédure de changement de mot de passe		
		$this->ajouteLigne(
			$this->convertiTexte("Si vous désirez changer votre mot de passe, veuillez le faire par le biais du ") . 
			"<a href=\"" . FORUM . "/ucp.php?i=profile&mode=reg_details" . "\" title=\"" .
				$this->convertiTexte("Accès au forum") .
				"\">" .
				$this->convertiTexte("forum") .
				"</a><br/>");
		// Affichage du type d'adhérent
		$this->ajouteLigne( $this->convertiTexte("Statut MDJT : ") . 
			$this->monUtilisateur->recupTypeAdherent() . "<br/>");
		// Date de première adhésion
		$this->ajouteLigne( $this->convertiTexte("Adhérent depuis : ") .
			$this->dateBaseToAffichage($this->monUtilisateur->recupDateAdhesion()) );
		$this->fermeBloc("</p>");
                // Liste des groupes auxquels l'utilisateur appartient
                $listeGroupes = implode(", ", $this->monUtilisateur->recupGroupes());
                
		$this->ajouteLigne( $this->convertiTexte("Vous appartenez aux groupes : ") .
			$listeGroupes );
		$this->fermeBloc("</p>");
	}
	
	/**
	*	Fonction d'affichage du formulaire
	*/
	private function afficheFormulaire()
	{
		// On affiche le titre du formulaire - le nom de l'utilisateur qu'on modifie
		// Ne l'affichez que pour un admin qui modifie autrui, sinon ça fait con...
		// $this->ajouteLigne("<p>Profil de " . $this->afficheNomUtilisateur() ."</p>");
		
		// On affiche le contenu du formulaire	
		$this->ouvreBloc("<form method='post' action='" .
				MODULE_PROFIL . "' id='formProfil'>");
		// Si on a déjà traité le formulaire
		if ($this->traitementFormulaire)
		{
			// On affiche le résultat du traitement
			$this->ouvreBloc("<p>");
			// Si il y a eu des modifications
			if ($this->estModifie)
			{
				// Ces modifications ont été correctement appliquée
				if ($this->modificationOK)
				{
					// On affiche une information
					$this->ajouteLigne($this->convertiTexte("Mise à jour du profil effectuée"));			
				}
				else
				{
					// Il y a eu des erreurs lors de la modification
// A completer
				}
			}
			else
			{
				// Il n'y a rien à modifier
				$this->ajouteLigne($this->convertiTexte("Aucun élément à modifier dans le profil"));
			}
			$this->fermeBloc("</p>");
		}
		
		// Premier fieldset identité
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Votre identité</legend>");		
		$this->ouvreBloc("<ol>");
		// Titre
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . TITRE . "'>" .
				$this->convertiTexte("Titre") .
				"</label>");
		$this->ouvreBloc("<select name='" . TITRE . "'>");
		
		switch ($this->monUtilisateur->recupTitre())
		{
			case "M.":
				$this->ajouteLigne("<option value='M.' selected='selected'>Monsieur</option>");
				$this->ajouteLigne("<option value='Mme'>Madame</option>");
				$this->ajouteLigne("<option value='Mlle'>Mademoiselle</option>");
        		break;
			case "Mme":
				$this->ajouteLigne("<option value='M.'>Monsieur</option>");
				$this->ajouteLigne("<option value='Mme' selected='selected'>Madame</option>");
				$this->ajouteLigne("<option value='Mlle'>Mademoiselle</option>");
        		break;
			case "Mlle":
				$this->ajouteLigne("<option value='M.'>Monsieur</option>");
				$this->ajouteLigne("<option value='Mme'>Madame</option>");
				$this->ajouteLigne("<option value='Mlle' selected='selected'>Mademoiselle</option>");
        		break;
		}
		$this->fermeBloc("</select>");
		$this->fermeBloc("</li>");
		
		// Prénom
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PRENOM . "'>" .
				$this->convertiTexte("Prénom") .
				"</label>");
		$this->ajouteLigne("<input type='text' name='" . PRENOM .
			 "' value='" . 
			 $this->convertiTexte( $this->monUtilisateur->recupPrenom() ) .
			 "' />");
		$this->fermeBloc("</li>");
		
		// Nom
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . NOM . "'>" .
				$this->convertiTexte("Nom") .
				"</label>");
		$this->ajouteLigne("<input type='text' name='" . NOM .
			 "' value='" . 
			 $this->convertiTexte($this->monUtilisateur->recupNom() ) .
			 "' />");
		$this->fermeBloc("</li>");
		
		// Date de naissance
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . DATE_NAISSANCE . "'>" .
				$this->convertiTexte("Date de naissance") .
				"</label>");
		$this->ajouteLigne("<input type='date' name='" . DATE_NAISSANCE .
			 "' value='" . 
			 $this->dateBaseToAffichage($this->monUtilisateur->recupDateNaissance() ) .
			 "' />");				
		$this->fermeBloc("</li>");		
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
		
		// Second fieldset contact
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Vous contacter</legend>");		
		$this->ouvreBloc("<ol>");

		// email
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . EMAIL . "'>" .
				$this->convertiTexte("Courriel ") .
				"</label>");
		$this->ajouteLigne("<input type='email' name='" . EMAIL .
			 "' value='" . $this->monUtilisateur->recupEmail() .
			 "' />");
		$this->fermeBloc("</li>");

		// Telephone portable
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PORTABLE . "'>" .
				$this->convertiTexte("Téléphone portable") .
				"</label>");
		$this->ajouteLigne("<input type='tel' name='" . PORTABLE .
			 "' value='" . $this->monUtilisateur->recupTelephonePortable() .
			 "' />");
		$this->fermeBloc("</li>");

		// Telephone fixe
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . TELEPHONE . "'>" .
				$this->convertiTexte("Téléphone fixe") .
				"</label>");
		$this->ajouteLigne("<input type='tel' name='" . TELEPHONE .
			 "' value='" . $this->monUtilisateur->recupTelephoneFixe() .
			 "' />");
		$this->fermeBloc("</li>");		

		// Adresse
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . ADRESSE . "'>" .
				$this->convertiTexte("Adresse") .
				"</label>");
		$this->ajouteLigne("<textarea rows='3'  name='" . ADRESSE .
			 "' >" .
                        $this->convertiTexte( $this->monUtilisateur->recupAdresse() ) .
                        "</textarea>");
		$this->fermeBloc("</li>");	
		
		// Code postal
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . CODEPOSTAL . "'>" .
				$this->convertiTexte("Code Postal") .
				"</label>");
		$this->ajouteLigne("<input type='number' name='" . CODEPOSTAL .
			 "' value='" . $this->monUtilisateur->recupCodePostal() .
			 "' />");
		$this->fermeBloc("</li>");
		
		// Ville
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . VILLE . "'>" .
				$this->convertiTexte("Ville") .
				"</label>");
		$this->ajouteLigne("<input type='text' name='" . VILLE .
			 "' value='" . $this->monUtilisateur->recupVille() .
			 "' />");
		$this->fermeBloc("</li>");	
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");
	
		// Dernier fieldset Divers
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Renseignements divers</legend>");		
		$this->ouvreBloc("<ol>");	
	
		// Profession
		$this->ouvreBloc("<li>");
		$this->ajouteLigne("<label for='" . PROFESSION . "'>" .
				$this->convertiTexte("Profession") .
				"</label>");
		$this->ajouteLigne("<textarea rows='3' name='" . PROFESSION .
			 "' >" .
                        $this->convertiTexte( $this->monUtilisateur->recupProfession() ) .
                        "</textarea>");
		$this->fermeBloc("</li>");	
		$this->fermeBloc("</ol>");
		$this->fermeBloc("</fieldset>");			 
			 
			 
		/*
		// Membre actif
		$this->ajouteLigne("<p><label for='" . ACTIF . "'>" .
			$this->convertiTexte("Membre actif ? ") .
	  		"</label>");
		if ($this->monUtilisateur->recupActif() == 1)
		{
			$this->ajouteLigne("<input type='checkbox' name='" . ACTIF . "' id='" . ACTIF . "' checked='checked'/></p>");
		}
		else
		{
			$this->ajouteLigne("<input type='checkbox' name='" . ACTIF . "' id='" . ACTIF . "' /></p>");
		}
		*/
		/*
		// Date de première adhésion
		$this->ajouteLigne("<p><label for='" . DATE_ADHESION . "'>" .
				$this->convertiTexte("Adhérent depuis : ") .
				"</label>");
		$this->ajouteLigne("<input type='text' name='" . DATE_ADHESION .
			 "' size='10' value='" . $this->monUtilisateur->recupDateAdhesion() .
			 "' /></p>");
		*/
		/*
		// Date de dernière cotisation
		$this->ajouteLigne("<p><label for='" . DATE_COTISATION . "'>" .
				$this->convertiTexte("Date de dernière cotisation : ") .
				"</label>");
		$this->ajouteLigne("<input type='text' name='" . DATE_COTISATION .
			 "' size='10' value='" . $this->monUtilisateur->recupDateCotisation() .
			 "' /></p>");
		*/
		/*
		// Exempté de cotisation ?
		$this->ajouteLigne("<p><label for='" . EXEMPT_COTISATION . "'>" .
			$this->convertiTexte("Exempté de cotisation ") .
	  		"</label>");
		if ($this->monUtilisateur->recupExemptCotisation() == 1)
		{
			$this->ajouteLigne("<input type='checkbox' name='" . EXEMPT_COTISATION . "' id='" . EXEMPT_COTISATION . "' checked='checked'/></p>");
		}
		else
		{
			$this->ajouteLigne("<input type='checkbox' name='" . EXEMPT_COTISATION . "' id='" . EXEMPT_COTISATION . "' /></p>");
		}
		*/
		/* 
		// Commentaires
		$this->ajouteLigne("<p><label for='" . COMMENTAIRES . "'>" .
			$this->convertiTexte("Commentaires ") .
	  		"</label></p>");
		$this->ajouteLigne("<textarea name='" . COMMENTAIRES .
			 "' rows='8' cols='45'>" . 
			 $this->convertiTexte($this->monUtilisateur->recupCommentaires()) .
			 "</textarea></p>");
		*/
		$this->ouvreBloc("<fieldset>");	
		$this->ajouteLigne("<input type='hidden' name='modifier' value='true' />");
		$this->ajouteLigne("<button type='submit' name='Modifier'>Je valide mes modifications</button>");
		$this->fermeBloc("</fieldset>");	
		$this->fermeBloc("</form>");	
	}
	
	/**
	*	Fonction de traitement du formulaire
	*/
	private function traiteFormulaire()
	{
		// Y a-t-il effectivement un formulaire à traiter ?
		if ($_POST["modifier"])
		{
			// Traitement du formulaire
			$this->traitementFormulaire = true;			
			// Nettoyage des variables POST récupérées
			// Contre injection de code
			// mysql_real_escape_string(); Echappement des caractères spéciaux SQL
			// Nettoyage de Titre
			switch ($_POST[TITRE]) 
			{
				case "M." :
				case "Mme" :
				case "Mlle" :
					$titre = $_POST[TITRE];
					break;
				default :
					$titre=$this->monUtilisateur->recupTitre();
					break;
			}
			// Nettoyage de nom et prenom
			$nom = $this->filtreChaine($_POST[NOM], TAILLE_CHAMPS_COURT);
			$prenom = $this->filtreChaine($_POST[PRENOM], TAILLE_CHAMPS_COURT);
			// Vérification de l'adresse mail
			if ( $this->verifMail($_POST[EMAIL]) )			
			{
				$email = $_POST[EMAIL];
			}
			else
			{
				$emailOK = false;
				$email = $this->monUtilisateur->recupEmail();
			}
            // Nettoyage de l'adresse
            $adresse = $this->filtreChaine($_POST[ADRESSE], TAILLE_CHAMPS_LONG);
			
			// Nettoyage du code postal
            $codePostal = intval($_POST[CODEPOSTAL]);
            // Nettoyage de la ville
			$ville = $this->filtreChaine($_POST[VILLE], TAILLE_CHAMPS_COURT);
			
            // Nettoyage des numéros de telephone
            $telephone = $this->filtreChaine($_POST[TELEPHONE], TAILLE_CHAMPS_TELEPHONE);
			$portable = $this->filtreChaine($_POST[PORTABLE], TAILLE_CHAMPS_TELEPHONE);
			
			// Vérification de la date de naissance
			if ( $this->verifDateAffichee($_POST[DATE_NAISSANCE]) )			
			{
				$dateNaissance = $this->dateAffichageToBase($_POST[DATE_NAISSANCE]);
			}
			else
			{
				$dateOK = false;
				$dateNaissance = $this->monUtilisateur->recupDateNaissance();
			}
            
			// Nettoyage du champ profession                        
            $profession = $this->filtreChaine($_POST[PROFESSION], TAILLE_CHAMPS_COURT);

						
			// Vérification de la présence de modifications
			// Changement de titre ?
			if (strcmp($titre,$this->monUtilisateur->recupTitre() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeTitre($titre);
			}
                        // Changement de nom ?
                        if (strcmp($nom,$this->monUtilisateur->recupNom() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeNom($nom);
			}
                        // Changement de prenom ?
                        if (strcmp($prenom,$this->monUtilisateur->recupPrenom() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changePrenom($prenom);
			}
                        // Changement d'adresse mail ?
                        if (strcmp($email,$this->monUtilisateur->recupEmail() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeEmail($email);
			}
                        // Changement d'adresse ?
                        if (strcmp($adresse,$this->monUtilisateur->recupAdresse() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeAdresse($adresse);
			}
                        // Changement de code postal ?
                        if ($codePostal != $this->monUtilisateur->recupCodePostal() )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeCodePostal($codePostal);
			}
                        // Changement de ville ?
                        if (strcmp($ville,$this->monUtilisateur->recupVille() != 0 ))
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeVille($ville);
			}
                        // Changement de telephone ?
                        if ($telephone != $this->monUtilisateur->recupTelephoneFixe() )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeTelephoneFixe($telephone);
			}
                        // Changement de portable ?
                        if ($portable != $this->monUtilisateur->recupTelephonePortable() )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeTelephonePortable($portable);
			}
                        // Changement de date de naissance ?
                        if (strcmp($dateNaissance,$this->monUtilisateur->recupDateNaissance() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeDateNaissance($dateNaissance);
			}
                        // Changement de profession ?
                        if (strcmp($profession,$this->monUtilisateur->recupProfession() != 0) )
			{
				$this->estModifie = true;
				$this->monUtilisateur->changeProfession($profession);
			}


			// Si il y a au moins une modification
				// On demande la mise à jour des informations dans la base
			if ($this->estModifie)
			{
				$this->modificationOK = $this->monUtilisateur->mettreAJour();
			}
				
			// Sinon,  
			
		}	
	}
	


}

?>
