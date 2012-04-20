<?php
require_once("classes/AccesAuxDonneesDev.classe.php");
$filter=$_POST["filter"];
$maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
$result=$maBase->tagDistributeur($filter);
foreach ($result as $row){
	$array[]=$row[NOM_CATEGORIE];
}
echo json_encode($array);
?>