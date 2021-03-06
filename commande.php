<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AJOUT COMMANDE ---//
if(isset($_POST['ajout_commande'])) 
{   //debug($_POST);
    $resultat = executeRequete("SELECT * FROM template WHERE id_template='$_POST[id_template]'");
    $template = $resultat->fetch_assoc();
    $_SESSION['commande']['titre'][] = $template['titre'];
    $_SESSION['commande']['auteur'][] = $template['auteur'];
    $_SESSION['commande']['id_template'][] =$_POST['id_template'];
    $_SESSION['commande']['description'][] = $template['description'];
}
//--- VIDER COMANDE ---//
if(isset($_GET['action']) && $_GET['action'] == "vider")
{
    unset($_SESSION['commande']);
}
//--- COMMANDE ---//
if(isset($_POST['commander']))
{
    
    if(!isset($erreur))
    {
        $date=new DateTime("now");

$id_membre=$_SESSION['membre']['id_membre'];
$date= new DateTime("now");
$datenow=$date->format('Y/m/d');

executeRequete("INSERT INTO commande (id_membre, date_enregistrement) VALUES (".$id_membre.",".$datenow.")");
        $id_commande = $mysqli->insert_id;
        unset($_SESSION['commande']);
        $contenu .= "<div class='validation'>Merci pour votre commande. votre n° de suivi est le $id_commande</div>";
    }
}
 
//--------------------------------- AFFICHAGE HTML ---------------------------------//
include("inc/haut.inc.php");
echo $contenu;
echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Commande</td></tr>";
echo "<tr><th>Titre</th><th>Template</th><th>Auteur</th><th>Description</th></tr>";
if(empty($_SESSION['commande']['id_template'])) // commande vide
{
    echo "<tr><td colspan='5'>Votre commande est vide</td></tr>";
}
else
{
    for($i = 0; $i < count($_SESSION['commande']['id_template']); $i++) 
    {
        echo "<tr>";
        echo "<td>" . $_SESSION['commande']['titre'][$i] . "</td>";
        echo "<td>" . $_SESSION['commande']['id_template'][$i] . "</td>";
        echo "<td>" . $_SESSION['commande']['auteur'][$i] . "</td>";
        echo "<td>" . $_SESSION['commande']['description'][$i] . "</td>";
        echo "</tr>";
    }
    
    if(internauteEstConnecte()) 
    {
        echo '<form method="post" action="">';
        echo '<tr><td colspan="5"><input type="submit" name="commander" value="Valider et déclarer la commande"></td></tr>';
        echo '</form>';   
    }
    else
    {
        echo '<tr><td colspan="3">Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir commander</td></tr>';
    }
    echo "<tr><td colspan='5'><a href='?action=vider'>Vider ma commande</a></td></tr>";
}
echo "</table><br>";
// echo "<hr>session commande:<br>"; debug($_SESSION);
include("inc/bas.inc.php");
?>