<?php
require_once("classes/AccesAuxDonneesDev.classe.php");
$filter=$_POST["filter"];
$maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
$result=$maBase->tagEditeur($filter);
foreach ($result as $row){
	$array[]=$row[NOM_EDITEUR];
}
echo json_encode($array);
?>