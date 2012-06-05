<?php
require_once("classes/AccesAuxDonneesDev.classe.php");
$filter=$_POST["filter"];
$maBase = AccesAuxDonneesDev::recupAccesDonneesDev();
$result=$maBase->tagNomJeu($filter);
foreach ($result as $row){
	$array[]=$row[NOM_JEU];
}
echo json_encode($array);
?>