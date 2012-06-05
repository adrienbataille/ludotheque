// fonction pour donner le focus sur un champ choisi dans la page voulue
// avec un <body onload="donnerFocus('nom_du_champ_voulu')">
function donnerFocus(champ)
{
	document.getElementById(champ).focus();
}

