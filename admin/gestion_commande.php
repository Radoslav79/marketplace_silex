<?php
require_once("../inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- VERIFICATION ADMIN ---//
if(!internauteEstConnecteEtEstAuteur())
{
    header("location:../connexion.php");
    exit();
}


$contenu .= '<a href="?action=affichage">Affichage des commandes</a><br>';
$contenu .= '<a href="?action=ajout">Ajout d\'une commande</a><br><br><hr><br>';
//--- AFFICHAGE COMMANDES ---//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM commande");
     
    $contenu .= '<h2> Affichage des commande </h2>';
    $contenu .= 'Nombre de commande(s) dans la boutique : ' . $resultat->num_rows;
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
        $contenu .= '<td><a href="?action=modification&id_commande=' . $ligne['id_commande'] .'"><img src="../inc/img/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_commande=' . $ligne['id_commande'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><hr><br>';
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/haut.inc.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
    if(isset($_GET['id_commande']))
    {
        $resultat = executeRequete("SELECT * FROM commande WHERE id_commande=$_GET[id_commande]");
        $produit_actuel = $resultat->fetch_assoc();
    }
    echo '<h1> Formulaire Commandes </h1>'
?>
<div id="conteneur">
<form method="post" enctype="multipart/form-data" action="gestion_commande.php">

        <label for="id_commande">reference</label><br>
        <input type="text" id="id_commande" name="id_commande" placeholder="id_commande" value="id_commande"><br><br>

        <label for="id_membre">id_membre</label><br>
        <input type="text" id="id_membre" name="id_membre" placeholder="id_membre" value="id_membre"><br><br>

        <label for="dete_enregistrement">Date d'enregistrement</label><br>
        <input type="text" id="dete_enregistrement" name="dete_enregistrement" placeholder="dete_enregistrement" value="dete_enregistrement"><br><br>

        

        <label for="etat">Etat de la commande</label><br>
        <select name="etat">
            <option value="en cours de traitement">En cours de traitement</option>
            <option value="envoyé">Envoyée</option>
            <option value="reçu">Reçu</option>
        </select><br><br>

    
        <input type="submit" value="enregistrer">
</form>
</div>
<?php
}
require_once("../inc/bas.inc.php"); ?>