<?php

// Inclusions
require_once("classes/Module.classe.php");



//Constantes


/**
 * Composant recherche
 * @author Romain Laï-King, Rania Daoudi, Ziyang Ke
 * @package composant
 * @version 0.1
 */


class ComposantRecherche extends Module
{
	/**
	 * @var AccesAuxDonneesDev Connexion BDD
	 */
	private $maBase = NULL;

	/**
	 * @var Array Contient les paramètres de recherche en GET
	 */
	private $getRecherche=NULL;

	/**
	 * Constructeur. Il ouvre une connexion à la BDD et affiche le formulaire
	 */
	public function __construct()
	{
		// On utilise le constructeur de la classe mère
		parent::__construct();
		// On a besoin d'un accès à la base - On utilise la fonction statique prévue
		$this->maBase = AccesAuxDonneesDev::recupAccesDonnees();
		$this->afficheFormulaire();
		$this->traitementFormulaire();
	}

	/**
	 * Affiche le formulaire de recherche
	 */

	private function afficheFormulaire()
	{
		$this->ouvreBloc("<form method='post' action='".MODULE_RECHERCHE."'>");
		$langue=$this->maBase->listeLangue();
		$etat=$this->maBase->listeEtat();
		$lieu=$this->maBase->listeLieu();
		$auteur=$this->maBase->listeAuteur();
		$illustrateur=$this->maBase->listeIllustrateur();
		$distributeur=$this->maBase->listeDistributeur();
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>Recherche de jeu</legend>");

		// Nom du jeu
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nom\">" . $this->convertiTexte("Nom du jeu") . "</label>");
		//$this->ajouteLigne("<input type=\"text\" id=\"nom\" name=\"recherche[nom]\" />");
		$this->creationInputText("recherche",NOM);
		$this->fermeBloc("</div>");

		//Categorie
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"categorie\">" . $this->convertiTexte("Catégorie") . "</label>");
		$this->creationInputText("recherche","categorie");
		$this->fermeBloc("</div>");

		//Nombre de joueur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nombreDeJoueur\">" . $this->convertiTexte("Nombre de joueur") . "</label>");
		$this->creationCheckBox("recherche","j1");
		$this->ajouteLigne($this->convertiTexte("1"));
		$this->creationCheckBox("recherche","j2");
		$this->ajouteLigne($this->convertiTexte("2"));
		$this->creationCheckBox("recherche","j3");
		$this->ajouteLigne($this->convertiTexte("3"));
		$this->creationCheckBox("recherche","j4");
		$this->ajouteLigne($this->convertiTexte("4"));
		$this->creationCheckBox("recherche","j5");
		$this->ajouteLigne($this->convertiTexte("5"));
		$this->ajouteLigne("<br/>");
		$this->creationCheckBox("recherche","j6");
		$this->ajouteLigne($this->convertiTexte("6"));
		$this->creationCheckBox("recherche","j7");
		$this->ajouteLigne($this->convertiTexte("7"));
		$this->creationCheckBox("recherche","j8");
		$this->ajouteLigne($this->convertiTexte("8"));
		$this->creationCheckBox("recherche","j9");
		$this->ajouteLigne($this->convertiTexte("8+"));
		$this->fermeBloc("</div>");

		//Durée
		/**
		 * @todo Voir durée partie dans la bdd
		 */
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"dureeEnMinute\">" . $this->convertiTexte("Durée en minute") . "</label>");
		$this->creationInputText("recherche","DureeJeu");
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Plus ou moins 20 min "));
		$this->creationRadioBox("recherche", "dureeSigne", EGAL,true);
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Supérieur à "));
		$this->creationRadioBox("recherche", "dureeSigne", SUPERIEUR);
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Inférieur à "));
		$this->creationRadioBox("recherche", "dureeSigne", INFERIEUR);
		$this->fermeBloc("</div>");
		//Langue

		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"langue\">" . $this->convertiTexte("Langue") . "</label>");
		$this->creationSelect($langue,"recherche",ID_LANGUE);
		$this->fermeBloc("</div>");

		//Etat
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"etat\">" . $this->convertiTexte("Etat") . "</label>");
		$this->creationSelect($etat,"recherche",ID_ETAT_EXEMPLAIRE);
		$this->fermeBloc("</div>");

		//Lieu
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"lieu\">" . $this->convertiTexte("Lieu") . "</label>");
		$this->creationSelect($lieu,"recherche",ID_LIEU);
		$this->fermeBloc("</div>");


		//Prix
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"prix\">" . $this->convertiTexte("Prix:") . "</label>");
		$this->ajouteLigne( $this->convertiTexte("Min"));
		$this->creationInputText("recherche","prixMin");
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Max") );
		$this->creationInputText("recherche","prixMax");
		$this->fermeBloc("</div>");
		$this->fermeBloc("</fieldset>");

		//Recherche avancée
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend>" . $this->convertiTexte("Recherche avancée") . "</legend>");

		//Auteur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"auteur\">" . $this->convertiTexte("Auteur") . "</label>");
		//$this->creationInputText("recherche","auteur");
		$this->creationSelect($auteur,"recherche","auteur");
		$this->fermeBloc("</div>");

		//Illustrateur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"illustrateur\">" . $this->convertiTexte("Illustrateur") . "</label>");
		//$this->creationInputText("recherche","illustrateur");
		$this->creationSelect($illustrateur,"recherche","illustrateur");
		$this->fermeBloc("</div>");

		//Distributeur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"distributeur\">" . $this->convertiTexte("Distributeur") . "</label>");
		//$this->creationInputText("recherche","distributeur");
		$this->creationSelect($distributeur,"recherche","distributeur");
		$this->fermeBloc("</div>");


		//Année
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"annee\">" . $this->convertiTexte("Année") . "</label>");
		$this->creationInputText("recherche","annee");
		$this->fermeBloc("</div>");



		$this->ajouteLigne("<input type='submit' />");
		$this->fermeBloc("</fieldset>");
		$this->fermeBloc("</form>");
	}

	/**
	 * Traitement du formulaire pour la recherche. Cette fonction s'occupe d'afficher les résultats de la recherche
	 */

	private function traitementFormulaire(){
		$param=false;
		$recherche=$_POST["recherche"];
		var_dump($recherche);
		if ($recherche!=NULL){
			foreach($recherche as $row){
				if ($row!=""){
					$param=true;
				}
			}
		}
		elseif($this->getRecherche!=NULL){
			$param=true;
			$recherche=$this->getRecherche;
		}
		if($param){

			$resultat=$this->maBase->rechercheVersion($recherche);
			if(count($resultat)==0){
				$this->ajouteLigne($this->convertiTexte("Aucun Résultat"));
			}
			else{
				$this->ouvreBloc("<table>");
				$this->ajouteLigne("<caption>" . $this->convertiTexte("Résultat de la Recherche :") . " </caption>");
				$this->ouvreBloc("<thead>");
				$this->ouvreBloc("<tr>");
				$this->ajouteLigne("<th>Photo</th>");
				$this->ajouteLigne("<th>Nom</th>");
				$this->ajouteLigne("<th>Nombre Disponible</th>");
				$this->ajouteLigne("<th>Nombre Indisponible</th>");
				$this->fermeBloc("</tr>");
				$this->fermeBloc("</thead>");
				$this->ouvreBloc("<tbody>");
				$idversion=-1;
				var_dump($resultat);
				foreach ($resultat as $row) {
					if($idversion!=$row[ID_VERSION]){
						if($idversion!=-1){
							$this->ouvreBloc("<tr>");
							$this->ajouteLigne("<td>" . $photo . "</td>" );
							$this->ajouteLigne("<td>" . $nomJeu);
							$this->ajouteLigne("<br/>" . $nomVersion);
							$this->ajouteLigne("Id" . $idversion . "</td>");
							$this->ajouteLigne("<td>" . $nbdisponible . "</td>");
							$this->ajouteLigne("<td>" . $nbindisponible . "</td>");
							$this->ouvreBloc("</tr>");
						}
						$nbindisponible=0;
						$nbdisponible=0;
						$photo=$this->convertiTexte($row[NOM_PHOTO]);
						$nomJeu= $this->convertiTexte($row[NOM_JEU]);
						$nomVersion=$this->convertiTexte($row[NOM_VERSION]);
						$idversion=$row[ID_VERSION];
					}
					if($row[ID_ETAT_EXEMPLAIRE]==DISPONIBLE){
						$nbdisponible+=$row["nbExemplaire"];
					}
					else{
						$nbindisponible+=$row["nbExemplaire"];
					}
				}
				$this->ouvreBloc("<tr>");
				$this->ouvreBloc("<tr>");
				$this->ajouteLigne("<td>" . $photo . "</td>" );
				$this->ajouteLigne("<td>" . $nomJeu);
				$this->ajouteLigne("<br/>" . $nomVersion);
				$this->ajouteLigne("Id" . $idversion . "</td>");
				$this->ajouteLigne("<td>" . $nbdisponible . "</td>");
				$this->ajouteLigne("<td>" . $nbindisponible . "</td>");
				$this->ouvreBloc("</tr>");
				$this->fermeBloc("</table>");
			}
		}
	}





	/**
	 * Fonction qui crée des listes HTML <select>
	 * @param array tableau 2 colonnes, la première étant la value, deuxième le nom
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 */

	private function creationSelect($array,$param,$name){
		$post=$_POST[$param];
		$get=$_GET[$name];
		if($post==NULL){
			$value=$get;
			$this->getRecherche[$name]=$value;
		}
		else{
			$value=$post[$name];
		}
		$this->ouvreBloc("<select name=\"".$param."[".$name."]\">");
		$this->ajouteLigne("<option value=\"\">". $this->convertiTexte("Indifférent"). "</option>");
		foreach($array as $row){
			if($row[0]==$value){
				$this->ajouteLigne("<option selected=\"selected\" value=\"".$row[0]."\">". $row[1] ."</option>");
			}
			else{
				$this->ajouteLigne("<option value=\"".$row[0]."\">". $row[1] ."</option>");
			}
		}
		$this->fermeBloc("</select>");
	}

	/**
	 *Fonction qui crée des input type text et le prérempli si le paramètre post existe
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 * @todo ajout d'attribut list avec comme valeur $name
	 */

	private function creationInputText($param,$name){
		$post=$_POST[$param];
		$value=$post[$name];
		$get=$_GET[$name];
		if($post==NULL||$value==""){
			$value=$get;
			$this->getRecherche[$name]=$get;
		}
		$this->ajouteLigne("<input type=\"text\" id=\"".$name."\" name=\"".$param ."[".$name."]\" value=\"". $value ."\" />");
	}

	/**
	 * Fonction qui crée des datalist HTML5 pour l'autocomplétion
	 * @param array tableau de valeur
	 * @param string le nom qui permet d'assosier au champ
	 */

	private function creationDatalist($array,$name){

	}

	/**
	 *Fonction qui crée des input type checkbox et le prérempli si le paramètre post existe
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 */

	private function creationCheckBox($param,$name){
		$post=$_POST[$param];
		$value=$post[$name];
		if($post==NULL||$value==""){
			$this->ajouteLigne("<input type=\"checkbox\" id=\"".$name."\" name=\"".$param ."[".$name."]\" />");
		}
		else {
			$this->ajouteLigne("<input type=\"checkbox\" id=\"".$name."\" name=\"".$param ."[".$name."]\" checked=\"yes\" />");
		}
	}
	/**
	 *Fonction qui crée des input type radiobox et le prérempli si le paramètre post existe
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 * @param string value de la radiobox
	 * @param boolean checked par défaut ou non
	 */

	private function creationRadioBox($param,$name,$value,$checked=false){
		$post=$_POST[$param];

		if($post[$name]==$value||($checked&&$post==NULL)){
			$this->ajouteLigne("<input type=\"radio\" id=\"".$name."\" group=\"" . $name ."\"  name=\"".$param ."[".$name."]\" value=\"" . $value."\" checked/>");
		}
		else{
			$this->ajouteLigne("<input type=\"radio\" id=\"".$name."\" group=\"" . $name ."\"  name=\"".$param ."[".$name."]\" value=\"" . $value."\" />");
		}

	}
}


?>