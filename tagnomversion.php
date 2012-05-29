<?php
require_once("classes/AccesAuxDonneesDev.classe.php");
$filter=$_POST["filter"];
$idJeu=$_POST["param"];
$maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
$result=$maBase->tagNomVersion($filter, $idJeu);
foreach ($result as $row){
	$array[]=$row[NOM_VERSION];
}
echo json_encode($array);
?>