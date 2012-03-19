<?php
require_once("classes/Module.classe.php");

//Constantes
define("MODULE_JEU", RACINE_SITE . "module.php?idModule=Jeu");

class ModuleJeu extends Module
{

    public function __construct()
    {
        // On utilise le constructeur de la classe mère
        parent::__construct();
        $this->affiche();

    }
    private function affiche()
    {
        $this->ouvreBloc("<p>");
        $this->ajouteLigne("Hello World");
        $this->fermeBloc("</p>");
    }
}
?>