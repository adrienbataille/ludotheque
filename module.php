<?php
/**
* Page d'affichage des modules
*/

// Inclusion des fichiers utiles
require_once("classes/PageModule.classe.php");

// Création de la page
$maPage = new PageModule();

// Contenu de la page

// Menu
$maPage->afficheMenuModule();

// Partie contenant le module
$maPage->afficheModule();

// Fermeture et affichage de la page automatique ! (à la destruction)

?>