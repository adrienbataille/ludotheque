<?php
require_once("classes/AccesAuxDonneesDev.classe.php");
$filter=$_POST["filter"];
$maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
$result=$maBase->tagAuteur($filter);
foreach ($result as $row){
	$array[]=$row[NOM_AUTEUR];
}
echo json_encode($array);
?>