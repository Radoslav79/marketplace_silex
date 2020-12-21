<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(isset($_GET['id_template']))  { $resultat = executeRequete("SELECT * FROM template WHERE id_template = '$_GET[id_template]'"); }
if($resultat->num_rows <= 0) { header("location:boutique.php"); exit(); }
 
$template = $resultat->fetch_assoc();
$contenu .= "<h2>Titre : $template[titre]</h2><hr><br>";
$contenu .= "<p>Auteur: $template[auteur]</p>";
$contenu .= "<img src='$template[photo]' ='150' height='150'>";
$contenu .= "<p><i>Description: $template[description]</i></p><br>";
$contenu .= '<form method="post" action="commande.php">';
$contenu .= '<input type="submit" name="ajout_commande" value="ajout à la commande">';
$contenu .= '</form>';
$contenu .= "<br><a href='marketplace.php?auteur=" . $template['auteur'] . "'>Retour vers la séléction de " . $template['auteur'] . "</a>";
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("inc/haut.inc.php");
echo $contenu;
require_once("inc/bas.inc.php"); ?> 