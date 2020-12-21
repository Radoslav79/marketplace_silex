<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AFFICHAGE DES AUTEURS ---//
$auteur_des_templates = executeRequete("SELECT DISTINCT auteur FROM template");
$contenu .= '<div class="marketplace-gauche">';
$contenu .= "<ul>";
while($cat = $auteur_des_templates->fetch_assoc())
{
    $contenu .= "<li><a href='?auteur=" . $cat['auteur'] . "'>" . $cat['auteur'] . "</a></li>";
}
$contenu .= "</ul>";
$contenu .= "</div>";
//--- AFFICHAGE DES AUTEURS ---//
$contenu .= '<div class="marketplace-droite">';
if(isset($_GET['auteur']))
{
    $donnees = executeRequete("SELECT * FROM template WHERE auteur='$_GET[auteur]'");  
    while($template = $donnees->fetch_assoc())
    {
        $contenu .= '<div class="marketplace-produit">';
        $contenu .= "<h2>$template[titre]</h2>";
        $contenu .= "<h2>$template[auteur]</h2>";
        $contenu .= "<a href=\"fiche_template.php?id_template=$template[id_template]\"><img src=\"$template[photo]\" =\"130\" height=\"100\"></a>";
        $contenu .= '<a href="fiche_template.php?id_template=' . $template['id_template'] . '">Voir la fiche</a>';
        $contenu .= '</div>';
    }
}
$contenu .= '</div>';
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("inc/haut.inc.php");
echo $contenu;
require_once("inc/bas.inc.php"); ?>