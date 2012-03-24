<?php
/** Classe permettant de manipuler des requètes SQL.
 * A utiliser pour les très grosses requètes afin de préserver une cohérence.
 * @author Romain Laï-King
 * @version 0.1
 * @todo Passage en SQL 2
 * @todo Nettoyer les entrées utilisateurs contre les injections SQL.
 */
class RequeteSQL
{
	/**
	 * 1ère partie de la requète
	 * @var string $requete
	 */
	
	private $requete="";
	
	/**
	 * 2ème partie de la requète, FROM
	 * @var string $from
	 */
	
	private $from="";
	
	
	/**
	 * 3ème partie de la requète, WHERE
	 * @var string $where
	 */
	
	private $where="";
	
	/**
	 * 4ème partie de la requète.
	 * @var string $bonus
	 */
	
	private $bonus="";
	
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
	 * Plus tard éventuellement refaire la logique en INNER JOIN ou NATURAL JOIN
	 * @param string $table1 Table 1
	 * @param string $champ1 Champ de la table 1
	 * @param string $table2 Table 2
	 * @param string $champ2 Champ de la table 2
	 */
	public function jointure($table1,$champ1,$table2,$champ2){
		if ($this->from==""){
			$this->from="FROM ". $table1 . "\n, " . $table2;
		}
		else{
			if(!stristr($this->from,$table1)){
				$this->from.="\n, ".$table1;
			}
			if(!stristr($this->from,$table2)){
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
	 * Fonction de manipulation de chaine pour créer et ajouter des clause WHERE avec AND et =
	 * Principalement pour les recherches de type =
	 * @param string $table Nom de la table
	 * @param string $champ Le champ de la table concerné par le critère de recherche
	 * @param string $valeur La valeur du critère de recherche
	 */
	public function ajoutAndEgal($table,$champ,$valeur){
		if ($this->where==""){
			if(is_numeric($valeur)){
				$this->where="WHERE ". $table . $champ . " = " . $valeur;
			}
			else{
				$this->where="WHERE ". $table . $champ . " = \' $valeur'";
			}
		}
		else{
			if(is_numeric($valeur)){
				$this->where.="\nAND ". $table . "." . $champ . " = " . $valeur ;
			}
			else{
				$this->where.="\nAND ". $table . "." . $champ . " = '$valeur'";
			}
		}
	}
	
	/**
	 * Fonction de manipulation de chainer pour ajouter librement à la clause WHERE
	 * A utiliser dans les cas non couvert par la fonction précédente.
	 * @param string $clause La clause where qui sera concaténé à $where
	 */
	public function ajoutWhereLibre($clause){
		$this->where.= "\n" . $clause; 
	}
	/**
	 * Fonction qui compile les différentes parties ensembles pour créer la requète SQL finale.
	 * @return string Requète SQL
	 */
	
	
	public function compile(){
		return $this->requete . "\n". $this->from . "\n" . $this->where . "\n" . $this->bonus;
	} 
	
}