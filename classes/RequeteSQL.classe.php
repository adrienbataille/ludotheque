<?php

/**
 * Classe permettant de manipuler des requètes SQL dyanmiquement en simplifiant leur écriture.
 * A utiliser pour les très grosses requètes afin de préserver leur cohérence en limitant les erreurs
 * de développement et utilisateur.
 * @author Romain Laï-King
 * @version 0.4
 * @package common
 */

class RequeteSQL
{
	/**
	 * partie de la requète
	 * @var string $requete
	 */

	private $requete="";

	/**
	 * partie de la requète, FROM
	 * @var string $from
	 */

	private $from="";

	/**
	 * jointure spécial
	 */

	private $jointure="";

	/**
	 * partie de la requète, WHERE
	 * @var string $where
	 */

	private $where="";

	/**
	 * partie extra de la requète.
	 * @var string $extra
	 */

	private $extra="";

	/**
	 * Constructeur. Il fait rien pour le moment
	 */

	public function __construct()
	{
	}

	/**
	 * Accesseur pour la première partie. Ne pas inclure clause FROM, WHERE, VALUE, etc
	 * @param string $valeur
	 */

	public function setRequete($valeur){
		$this->requete=$valeur;
	}

	/**
	 * Access pour la quatrième partie.
	 * @param string $valeur
	 */

	public function setExtra($valeur){
		$this->extra=$valeur;
	}

	/**
	 * Fonction de manipulation de chaine pour créer et ajouter des tables dans une clause FROM
	 * @param string $table Nom de la table
	 */
	public function ajoutFrom($table){
		if ($this->from==""){
			$this->from="FROM ". $table;
		}
		else{
			$this->from.="\n, ".$table;
		}
	}
	/**
	 * Fonction de jointure
	 * Ajoute automatiquement les tables au JOIN et les clause aux WHERE
	 * Equivalent de FROM table INNER JOIN table ON champ sauf qu'on utilise FROM et WHERE
	 * L'avantage par rapport au SQL 2 est que de multipe jointure s'effecturont correctement même dans le désordre
	 * @param string $table1 Table 1
	 * @param string $champ1 Champ de la table 1
	 * @param string $table2 Table 2
	 * @param string $champ2 Champ de la table 2
	 */
	public function jointure($table1,$champ1,$table2,$champ2){
		if ($this->from==""){

			if(stristr($this->jointure,$table1)){
				$this->from="FROM " . $table2;
			}
			elseif(stristr($this->jointure,$table2)){
				$this->from="FROM " . $table1;
			}
			else{
				$this->from="FROM ". $table1 . "\n, " . $table2;
			}
		}
		else{
			if(!stristr($this->from,$table1)&&!stristr($this->jointure,$table1)){
				$this->from.="\n, ".$table1;
			}
			if(!stristr($this->from,$table2)&&!stristr($this->jointure,$table2)){
				$this->from.="\n, ".$table2;
			}
		}
		if($this->where==""){
			$this->where="WHERE ". $table1 . "." .  $champ1 . " = " . $table2 . "." . $champ2;
		}
		else{
			$this->where.= "\nAND ". $table1 . "." . $champ1 . " = " . $table2 . "." . $champ2;
		}
	}

	/**
	 * Fonction de jointure LEFT JOIN
	 * Attention, l'ordre d'appel des fonctions et des paramètres est important.
	 * Chaque appel concatène les tables et jointure à la clause précédente.
	 * Deplus, SQL émet une erreur en cas de table dupliqué.
	 * @param string $table1 Table 1
	 * @param string $champ1 Champ de la table 1
	 * @param string $table2 Table 2
	 * @param string $champ2 Champ de la table 2
	 */
	public function jointureLeft($table1,$champ1,$table2,$champ2){
		if ($this->jointure==""){
			$this->jointure= $table1 . "\nLEFT JOIN " . $table2 . " ON " . $table1 . ".". $champ1 . "=" .  $table2 . ".". $champ2 ;
		}
		else{
			if(stristr($this->jointure,$table1)){
				$this->jointure.="\nLEFT JOIN " . $table2 . " ON " . $table1 . ".". $champ1 . "=" .  $table2 . ".". $champ2 ;
			}
			elseif(stristr($this->jointure,$table2)){
				$this->jointure.="\nLEFT JOIN " . $table1 . " ON " . $table1 . ".". $champ1 . "=" .  $table2 . ".". $champ2 ;

			}
			else{
				$this->jointure.="\n,". $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . ".". $champ1 . "=" .  $table2 . ".". $champ2 ;
			}
		}
	}
	/**
	 * Fonction de manipulation de chaine pour créer et ajouter des clause WHERE avec AND et =
	 * @param string signe
	 * @param string $table Nom de la table
	 * @param string $champ Le champ de la table concerné par le critère de recherche
	 * @param string/numeric $valeur La valeur du critère de recherche
	 */
	public function ajoutAnd($signe,$table,$champ,$valeur){
		if ($this->where==""){
			if(is_numeric($valeur)){
				$this->where="WHERE ". $table .".". $champ . " ". $signe . " " . $valeur;
			}
			else{
				$valeur=mysql_real_escape_string($valeur);
				$this->where="WHERE ". $table .".". $champ . " ". $signe . "  '$valeur'";
			}
		}
		else{
			if(is_numeric($valeur)){
				$this->where.="\nAND ". $table . "." . $champ  ." ". $signe . " " . $valeur ;
			}
			else
				$valeur=mysql_real_escape_string($valeur);
				$this->where.="\nAND ". $table . "." . $champ . " " . $signe . " '$valeur'";
			}
		}




	/**
	 * Fonction de manipulation de chaine pour créer et ajouter des clause WHERE avec AND et LIKE
	 * Principalement pour les recherches de type LIKE
	 * @param string $table Nom de la table
	 * @param string $champ Le champ de la table concerné par le critère de recherche
	 * @param string $valeur La valeur du critère de recherche
	 */
	public function ajoutAndLike($table,$champ,$valeur){
		if ($this->where==""){
			$valeur=mysql_real_escape_string($valeur);
			$this->where="WHERE ". $table . $champ . " LIKE '%".  $valeur ."%'";
		}
		else{
			$valeur=mysql_real_escape_string($valeur);
			$this->where.="\nAND ". $table . "." . $champ . " LIKE '%".  $valeur ."%'";
			}
		}



	/**
	 * Fonction de manipulation de chainer pour ajouter librement à la clause WHERE
	 * A utiliser dans les cas non couvert par la fonction précédente.
	 * Attention, la fonction ne gère pas les injections SQL.
	 * @param string $clause La clause where qui sera concaténé à $where
	 */
	public function ajoutWhereLibre($clause){
		if ($this->where==""&&!stristr($clause, "WHERE")){
			$this->where=="WHERE " . $clause;
		}
		else{
			$this->where.= "\n" . $clause;
		}
	}
	/**
	 * Fonction qui compile les différentes parties ensembles pour créer la requète SQL finale.
	 * @return string Requète SQL
	 */


	public function compile(){
		if($this->from==""&&$this->jointure!=""){
			return $this->requete . "\nFROM" . $this->jointure .  "\n" . $this->where . "\n" . $this->extra . ";";
		}
		elseif($this->from!=""&&$this->jointure!=""){
			return $this->requete . "\n" . $this->from . ",\n" . $this->jointure .  "\n" . $this->where . "\n" . $this->extra . ";";
		}
	}

	/**
	 * Fonction de debug. Affiche la requète compilé avec des sauts de ligne <br/>
	 */

	public function debug(){
		$temp=$this->compile();
		$temp=str_ireplace("\n","<br/>",$temp);
		print_r($temp);
	}

}