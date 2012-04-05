
function ajouterNomFormAjoutJeu() {
    if(document.getElementById("addNomFormAjoutJeu"))
    {
        var input = document.getElementById("addNomFormAjoutJeu").innerHTML
        document.getElementById("addNomFormAjoutJeu").innerHTML = input + '<fieldset><legend>Autre Nom du jeu</legend><ol><li><label for="nom_jeu">Nom</label><input type="text" id="nom_jeuxxxx" name="nom_jeuxxx" value="" required="required" /></li><li><label for="nom_langue">Langue du nom</label><input type="text" name="nom_langueeee" value="" list="listeCategorie" required="required" /></li></ol></fieldset>\n';
    }
    return false;
}