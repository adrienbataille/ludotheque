<?php

// Inclusions
require_once("classes/Module.classe.php");
require_once("classes/paginator.php");


//Constantes


/**
 * Composant recherche
 * @author Romain Laï-King, Rania Daoudi, Ziyang Ke
 * @package composant
 * @version 0.5
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
	private $getRecherche = NULL;

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
		$this->traitementFormulaire();
	}

	/**
	 * Affiche le formulaire de recherche
	 */

	private function afficheFormulaire()
	{
		$this->ouvreBloc("<form id=\"recherche\" method='get' action='" .
				$_SERVER['REQUEST_URI']."'>");
		//extraction de l'url du module afin de le rapeler
		$parametre=explode("?", $_SERVER['REQUEST_URI']);
		$url=explode("=",$parametre[1]);
		if(strpos($url[1],"&")!=FALSE){
			$url[1]=substr($url[1],0,strpos($url[1],"&"));
		}
		$this->ajouteLigne("<input type='text' name='$url[0]' style='display:none;' value='$url[1]'/> ");

		//Liste des différents élément en select
		$langue=$this->maBase->listeLangue();
		$etat=$this->maBase->listeEtat();
		$lieu=$this->maBase->listeLieu();
		$auteur=$this->maBase->listeAuteur();
		$illustrateur=$this->maBase->listeIllustrateur();
		$distributeur=$this->maBase->listeDistributeur();
		$this->ouvreBloc("<fieldset>");
		$this->ajouteLigne("<legend id='titreRecherche' >Recherche jeu</legend>");
		$this->ouvreBloc("<div id=\"rechercheBase\" class=\"ui-widget-content ui-corner-all\" >");
		// Nom du jeu
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nom\">" . $this->convertiTexte("Nom du jeu") . "</label>");
		//$this->ajouteLigne("<input type=\"text\" id=\"nom\" name=\"recherche[nom]\" />");
		$this->creationInputText("nom");
		$this->fermeBloc("</div>");

		//Categorie
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"Categorie\">" . $this->convertiTexte("Catégorie") . "</label>");
		$this->creationInputText("nomCategorie");
		$this->fermeBloc("</div>");

		//Nombre de joueur
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"nombreDeJoueur\">" . $this->convertiTexte("Nombre de joueur") . "</label>");
		$this->creationCheckBox("j1");

		$this->ajouteLigne($this->convertiTexte("1"));
		$this->creationCheckBox("j2");
		$this->ajouteLigne($this->convertiTexte("2"));
		$this->creationCheckBox("j3");
		$this->ajouteLigne($this->convertiTexte("3"));
		$this->creationCheckBox("j4");
		$this->ajouteLigne($this->convertiTexte("4"));
		$this->creationCheckBox("j5");
		$this->ajouteLigne($this->convertiTexte("5"));
		$this->ajouteLigne("<br/>");
		$this->creationCheckBox("j6");

		$this->ajouteLigne($this->convertiTexte("6"));
		$this->creationCheckBox("j7");

		$this->ajouteLigne($this->convertiTexte("7"));
		$this->creationCheckBox("j8");

		$this->ajouteLigne($this->convertiTexte("8"));
		$this->creationCheckBox("j9");

		$this->ajouteLigne($this->convertiTexte("9+"));
		$this->fermeBloc("</div>");

		//Durée
		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"dureeEnMinute\">" . $this->convertiTexte("Durée en minute") . "</label>");
		$this->creationInputText("DureeJeu");
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Plus ou moins 20 min "));

		$this->creationRadioBox( "dureeSigne", EGAL,true);
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Supérieur à "));
		$this->creationRadioBox( "dureeSigne", SUPERIEUR);
		$this->ajouteLigne("<br/>");
		$this->ajouteLigne($this->convertiTexte("Inférieur à "));

		$this->creationRadioBox( "dureeSigne", INFERIEUR);
		$this->fermeBloc("</div>");
		//Langue

		$this->ouvreBloc("<div class='champ_recherche'>");
		$this->ajouteLigne("<label for=\"langue\">" . $this->convertiTexte("Langue") . "</label>");
		$this->creationSelect($langue,"idLangue");
		$this->fermeBloc("</div>");

		//Etat
		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"etat\">" . $this->convertiTexte("Etat") . "</label>");

		$this->creationSelect($etat,"idEtatExemplaire");

		$this->fermeBloc("</div>");

		//Lieu
		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"lieu\">" . $this->convertiTexte("Lieu") . "</label>");

		$this->creationSelect($lieu,"idLieu");

		$this->fermeBloc("</div>");



		//Prix

		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"prix\">" . $this->convertiTexte("Valeur MDJT:") . "</label>");

		$this->ajouteLigne( $this->convertiTexte("Min"));
		$this->creationInputText("prixMin");
		$this->ajouteLigne("<br/>");

		$this->ajouteLigne($this->convertiTexte("Max") );

		$this->creationInputText("prixMax");

		$this->fermeBloc("</div>");
		$this->fermeBloc("</div>");

		$this->fermeBloc("</fieldset>");



		//Recherche avancée

		$this->ouvreBloc("<fieldset>");

		$this->ajouteLigne("<legend><a id=\"buttonAvance\" class=\"ui-state-default ui-corner-all\" >" . $this->convertiTexte("Recherche avancée") . "</a></legend>");


		$this->ouvreBloc("<div id=\"rechercheAvancee\" class=\"ui-widget-content ui-corner-all\">");

		//Auteur

		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"auteur\">" . $this->convertiTexte("Auteur") . "</label>");

		//$this->creationInputText("auteur");
		$this->creationInputText("nomAuteur");

		$this->fermeBloc("</div>");



		//Illustrateur

		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"illustrateur\">" . $this->convertiTexte("Illustrateur") . "</label>");

		$this->creationInputText("nomIllustrateur");
		//$this->creationSelect($illustrateur,"illustrateur");

		$this->fermeBloc("</div>");



		//Distributeur

		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"distributeur\">" . $this->convertiTexte("Distributeur") . "</label>");

		$this->creationInputText("nomDistributeur");
		//$this->creationSelect($distributeur,"distributeur");

		$this->fermeBloc("</div>");



		//Année

		$this->ouvreBloc("<div class='champ_recherche'>");

		$this->ajouteLigne("<label for=\"annee\">" . $this->convertiTexte("Année") . "</label>");

		$this->creationInputText("annee");

		$this->fermeBloc("</div>");


		$this->fermeBloc("</div>");
		$this->fermeBloc("</fieldset>");

		$this->ajouteLigne("<input type='submit'id='buttonRecherche' value='Rechercher' />");
		$this->fermeBloc("</form>");
	}

	/**
	 * Traitement du formulaire pour la recherche. Cette fonction s'occupe d'afficher les résultats de la recherche
	 */

	private function traitementFormulaire(){
		$param=false;
		//Vérification que l'on ait bien les paramètrs
		if($this->getRecherche!=NULL){
			$param=true;
			$recherche=$this->getRecherche;
		}
		if($param){

			$resultat=$this->maBase->rechercheVersion($recherche);
			//var_dump($resultat);
			if(count($resultat)==0){
				$this->ajouteLigne($this->convertiTexte("Aucun Résultat"));
			}
			else{
				//affichage résultat
				$this->ouvreBloc("<div class='ui-widget-content ui-corner-all' >");
				$this->ouvreBloc("<table id='resultat' >");
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
				$idVersion=-1;

				Paginator\Paginator::$total  = count($resultat);
				Paginator\Paginator::$limit  = 20;
				Paginator\Paginator::$offset = intval($_GET['offset']);

				Paginator\Paginator::$url    = $_SERVER['REQUEST_URI'];
				
				$resultat=array_slice($resultat,Paginator\Paginator::$offset,Paginator\Paginator::$limit);
				
				foreach ($resultat as $row) {
					//On affiche une fois par version, et on compte le nombre d'exemplaire dispo et non dispo
					if($idVersion!=$row[ID_VERSION]){
						if($idVersion!=-1){
							$this->ligneResultat($photo, $textealt, $nomJeu, $nomVersion, $idVersion, $nbdisponible, $nbindisponible);
						}

						$nbindisponible=0;

						$nbdisponible=0;
						$photo=$this->convertiTexte($row[NOM_PHOTO]);
						$textealt=$this->convertiTexte($row[TEXT_ALTERNATIF]);
						$nomJeu= $this->convertiTexte($row[NOM_JEU]);
						$nomVersion=$this->convertiTexte($row[NOM_VERSION]);
						$idVersion=$row[ID_VERSION];
					}
					if($row[ID_ETAT_EMPRUNT]==DISPONIBLE){
						$nbdisponible+=$row["nbExemplaire"];
					}
					else{
						$nbindisponible+=$row["nbExemplaire"];
					}
				}
				$this->ligneResultat($photo, $textealt, $nomJeu, $nomVersion, $idVersion, $nbdisponible, $nbindisponible);

				$this->fermeBloc("</table>");
				$this->fermeBloc("</div>");
				$this->ajouteLigne(Paginator\Paginator::links());
			}
		}
	}
	/**
	 * Fonction qui écrit une ligne du tableau de résultat
	 * @param string photo
	 * @param string nom jeu
	 * @param string nom version
	 * @param string id version
	 * @param string nombre disponible
	 * @param string nombre indisponible
	 */

	private function ligneResultat($photo,$textealt,$nomJeu,$nomVersion,$idVersion,$nbdisponible,$nbindisponible){
		$this->ouvreBloc("<tr>");

		$this->ajouteLigne("<td><a href='" . MODULE_FICHEJEU. "&idVersion=" . $idVersion . "'> <img class='photoRecherche' src='" . $photo . "'></a></td>" );

		$this->ajouteLigne("<td>");

		$this->ajouteLigne("<a href='" . MODULE_FICHEJEU. "&idVersion=" . $idVersion . "'>" .  $nomJeu ." - " . $nomVersion . "</a></td>");

		$this->ajouteLigne("<td>" . $nbdisponible . "</td>");

		$this->ajouteLigne("<td>" . $nbindisponible . "</td>");

		$this->ouvreBloc("</tr>");
	}



	/**
	 * Fonction qui crée des listes HTML <select>
	 * @param array tableau 2 colonnes, la première étant la value, deuxième le nom
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 */

	private function creationSelect($array,$name){
		$get=$_GET[$name];
		if($get!=NULL){
			$value=$get;
			$this->getRecherche[$name]=$value;
		}
		$this->ouvreBloc("<select name=\"".$name."\">");
		$this->ajouteLigne("<option value=\"\">". $this->convertiTexte("Indifférent"). "</option>");
		foreach($array as $row){
			if($row[0]==$get){
				$this->ajouteLigne("<option selected=\"selected\" value=\"".$row[0]."\">". $this->convertiTexte($row[1]) ."</option>");
			}
			else{
				$this->ajouteLigne("<option value=\"".$row[0]."\">". $this->convertiTexte($row[1]) ."</option>");
			}
		}
		$this->fermeBloc("</select>");
	}

	/**
	 *Fonction qui crée des input type text et le prérempli si le paramètre post existe
	 * @param string nom du tableau POST
	 * @param string nom de la ligne du tableau
	 */

	private function creationInputText($name){
		$get=$_GET[$name];
		if($get!=NULL){
			$value=$get;
			$this->getRecherche[$name]=$get;
		}
		$this->ajouteLigne("<input type=\"text\" id=\"".$name."\" name=\"".$name."\" value=\"". $value ."\" />");
	}


	/**

	 *Fonction qui crée des input type checkbox et le prérempli si le paramètre post existe

	 * @param string nom du tableau POST

	 * @param string nom de la ligne du tableau

	 */



	private function creationCheckBox($name){

		$value=$_GET[$name];

		if($value==NULL||$value==""){

			$this->ajouteLigne("<input type=\"checkbox\" id=\"".$name."\" name=\"".$name."\" />");

		}

		else {
			$this->getRecherche[$name]=$value;

			$this->ajouteLigne("<input type=\"checkbox\" id=\"".$name."\" name=\"".$name."\" checked=\"yes\" />");

		}

	}
	/**

	 *Fonction qui crée des input type radiobox et le prérempli si le paramètre post existe

	 * @param string nom du tableau POST

	 * @param string nom de la ligne du tableau
	 * @param string value de la radiobox
	 * @param boolean checked par défaut ou non

	 */



	private function creationRadioBox($name,$value,$checked=false){

		$get=$_GET[$name];

		if($get!=NULL){
			$this->getRecherche[$name]=$get;
		}
		if($get==$value||($checked&&$get==NULL)){
			$this->ajouteLigne("<input type=\"radio\" id=\"".$name."\" group=\"" . $name ."\"  name=\"".$name. "\" value=\"" . $value."\" checked/>");
		}
		else{

			$this->ajouteLigne("<input type=\"radio\" id=\"".$name."\" group=\"" . $name ."\"  name=\"".$name."\" value=\"" . $value."\" />");
		}



	}


}


?>