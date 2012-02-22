<?php
/**
* Page de deconnexion
* Suivi d'un retour à l'index
*/


// Inclusion des fichiers utiles
require_once("classes/Page.classe.php");

// Logout phpbb3
global $phpbb_root_path, $phpEx, $user, $db, $config, $cache, $template;      
define('IN_PHPBB', true);
$phpbb_root_path = '../forum/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$user->session_kill();

// Et redirection vers l'index
header('Location:' . PAGE_INDEX);
exit();

?>