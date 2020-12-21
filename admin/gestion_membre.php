<?php
require_once("../inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- VERIFICATION ADMIN ---//
if(!internauteEstConnecteEtEstAuteur())
{
    header("location:../connexion.php");
    exit();
}


$contenu .= '<a href="?action=affichage">Affichage des membres</a><br>';
$contenu .= '<a href="?action=ajout">Ajout d\'un membre</a><br><br><hr><br>';
//--- AFFICHAGE MEMBRES ---//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM membre");
     
    $contenu .= '<h2> Affichage des membres </h2>';
    $contenu .= 'Nombre de membre(s) dans la marketplace : ' . $resultat->num_rows;
    $contenu .= '<table border="1" cellpadding="5"><tr>';
     
    while($colonne = $resultat->fetch_field())
    {    
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Supression</th>';
    $contenu .= '</tr>';
 
    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "information")
            {
                $contenu .= '<td>' . $information . '</td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_membre=' . $ligne['id_membre'] .'"><img src="../inc/img/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_membre=' . $ligne['id_membre'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><hr><br>';
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/haut.inc.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
    if(isset($_GET['id_membre']))
    {
        $resultat = executeRequete("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
        $produit_actuel = $resultat->fetch_assoc();
    }

    echo '<h1> Formulaire Membres </h1>'
?>
<div id="conteneur">
<form method="post" enctype="multipart/form-data" action="gestion_membre.php">

        <label for="id_membre">id_membre</label><br>
        <input type="text" id="id_membre" name="id_membre" placeholder="id_membre" value="id_membre"><br><br>

        <label for="pseudo">pseudo</label><br>
        <input type="text" id="pseudo" name="pseudo" placeholder="pseudo" value="pseudo"><br><br>

        <label for="mdp">Mot de passe</label><br>
        <input type="text" id="mdp" name="mdp" placeholder="mdp" value="mdp"><br><br>

        <label for="nom">Nom</label><br>
    <input type="text" id="nom" name="nom" placeholder="votre nom"><br><br>
          
    <label for="prenom">Prénom</label><br>
    <input type="text" id="prenom" name="prenom" placeholder="votre prénom"><br><br>
  
    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" placeholder="exemple@gmail.com"><br><br>
          
    <label for="civilite">Civilité</label><br>
    <input name="civilite" value="m" checked="" type="radio">Homme
    <input name="civilite" value="f" type="radio">Femme<br><br>
                  
    <label for="ville">Ville</label><br>
    <input type="text" id="ville" name="ville" placeholder="votre ville" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_."><br><br>
          
    <label for="cp">Code Postal</label><br>
    <input type="text" id="code_postal" name="code_postal" placeholder="code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9"><br><br>
          
    <label for="adresse">Adresse</label><br>
    <textarea id="adresse" name="adresse" placeholder="votre dresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_."></textarea><br><br>
 
    <input type="submit" name="inscription" value="Inscrire">
</form>
</div>
<?php
}
require_once("../inc/bas.inc.php"); ?>