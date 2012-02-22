<?php
/**
* Page de connexion
*/

// Inclusion des fichiers utiles
require_once("classes/PageStandard.classe.php");

// Création de la page
$maPage = new PageStandard();

// Contenu de la page
// Partie éditoriale (gauche) : l'invite de connexion
$maPage->ouvreBlocGauche();
$maPage->afficheLogin();
$maPage->fermeBlocGauche();

// Menu et calendrier
$maPage->ouvreBlocDroit();
$maPage->afficheMenu();
$maPage->afficheMiniCalendrier();
$maPage->fermeBlocDroit();


// Fermeture et affichage de la page automatique ! (à la destruction)

?>