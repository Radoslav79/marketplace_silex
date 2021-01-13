<?php
function executeRequete($req)
{
    global $mysqli;
    $resultat = $mysqli->query($req);
    if(!$resultat)
    {
        die("Erreur sur la requete sql.<br>Message : " . $mysqli->error . "<br>Code: " . $req);
    }
    return $resultat;
}

function debug($var, $mode = 1)
{
    echo '<div style="background: orange; padding: 5px; float: right; clear: both; ">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo 'Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].';
    if($mode === 1)
    {
        print '<pre>'; print_r($var); print '</pre>';
    }
    else
    {
        print '<pre>'; var_dump($var); print '</pre>';
    }
    echo '</div>';
}

function internauteEstConnecte()
{ 
    if(!isset($_SESSION['membre'])) {
        return false;
    }
    else {
        return true;
    }
}

function internauteEstConnecteEtEstAuteur()
{
    if(internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) {
        return true;
    }
    else {
        return false;
    } 
}

function creationDeLaCommande()
{
   if(!isset($_SESSION['commande']))
   {
      $_SESSION['commande'] = array();
      $_SESSION['commande']['titre'] = array();
      $_SESSION['commande']['auteur'] = array();
      $_SESSION['commande']['id_template'] = array();
      $_SESSION['commande']['description'] = array();
    
   }
}

function ajouterTemplateDansCommande($titre, $id_template ,$auteur, $description)
{
    creationDeLaCommande();
    $position_template = array_search($id_template,  $_SESSION['commande']['id_template']);
    if($position_template !== false)
    {
        $_SESSION['commande']['titre'][] = $titre;
        $_SESSION['commande']['auteur'][] = $auteur;
        $_SESSION['commande']['id_template'][] = $id_template;
        $_SESSION['commande']['description'][] = $description;
    }
}

function retirerTemplateDeLaCommande($id_template_a_supprimer)
{
    $position_template = array_search($id_template_a_supprimer,  $_SESSION['commande']['id_template']);
    if ($position_template !== false)
    {
        array_splice($_SESSION['commande']['titre'], $position_template, 1);
        array_splice($_SESSION['commande']['auteur'], $position_template, 1);
        array_splice($_SESSION['commande']['id_template'], $position_template, 1);
        array_splice($_SESSION['commande']['description'], $position_produit, 1);
    }
}
