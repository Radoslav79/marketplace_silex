<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
if(!internauteEstConnecte()) header("location:connexion.php");
// debug($_SESSION);
$contenu .= '<p class="centre">Bonjour <strong>' . $_SESSION['membre']['pseudo'] . '</strong></p>';
$contenu .= '<div class="cadre"><h2> Voici vos informations </h2>';
$contenu .= '<p> votre email est: ' . $_SESSION['membre']['email'] . '<br>';
$contenu .= 'votre ville est: ' . $_SESSION['membre']['ville'] . '<br>';
$contenu .= 'votre cp est: ' . $_SESSION['membre']['code_postal'] . '<br>';
$contenu .= 'votre adresse est: ' . $_SESSION['membre']['adresse'] . '</p></div><br><br>';
$contenu .= '<a href="?action=modification">Modifier mes informations personnelles</a><br><br><br>';

if(isset($_GET['action']) && $_GET['action'] == "affichage")
{

    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<a href="?action=modification&id_membre=' . $ligne['id_membre'] . '">Modifier mes informations personnelles</a><br><br><br>';
    }
}

if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
    if(isset($_GET['id_membre']))
    {
        $resultat = executeRequete("INSERT INTO * FROM membre WHERE id_membre=$_GET[id_membre]");
        $membre_actuel = $resultat->fetch_assoc();
    }
}

    $contenu .= '<a href="?action=suppression">Supprimer votre compte</a><br><br><hr><br>';

    if(isset($_GET['action']) && $_GET['action'] == "suppression")
    {   // $contenu .= $_GET['id_membre']
        $resultat = executeRequete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
        $profil_a_supprimer = $resultat->fetch_assoc();
        executeRequete("DELETE * FROM membre WHERE id_membre=$_GET[id_membre]");
        $_GET['action'] = 'affichage';
    }
    
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("inc/haut.inc.php");
echo $contenu;
require_once("inc/bas.inc.php");