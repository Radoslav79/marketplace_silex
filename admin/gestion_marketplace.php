<?php
require_once("../inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- VERIFICATION AUTEUR ---//
if(!internauteEstConnecteEtEstAuteur())
{
    header("location:../connexion.php");
    exit();
}
 
//--- SUPPRESSION TEMPLATE ---//
if(isset($_GET['action']) && $_GET['action'] == "suppression")
{   // $contenu .= $_GET['id_template']
    $resultat = executeRequete("SELECT * FROM template WHERE id_template=$_GET[id_template]");
    $template_a_supprimer = $resultat->fetch_assoc();
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $template_a_supprimer['photo'];
    if(!empty($template_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    $contenu .= '<div class="validation">Suppression de la template : ' . $_GET['id_template'] . '</div>';
    executeRequete("DELETE FROM template WHERE id_template=$_GET[id_template]");
    $_GET['action'] = 'affichage';
}
//--- ENREGISTREMENT TEMPLATE ---//
if(!empty($_POST))
{   // debug($_POST);
    $photo_bdd = ""; 
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    if(!empty($_FILES['photo']['name']))
    {   // debug($_FILES);
        $nom_photo = $_FILES['photo']['name'];
        $photo_bdd = RACINE_SITE . "photo/$nom_photo";
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . RACINE_SITE . "/photo/$nom_photo"; 
        copy($_FILES['photo']['tmp_name'],$photo_dossier);
    }
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }
    executeRequete("REPLACE INTO template (id_template, reference, auteur, titre, description, photo) values ('$_POST[id_template]', '$_POST[reference]', '$_POST[auteur]', '$_POST[titre]', '$_POST[description]',  '$photo_bdd')");
    $contenu .= '<div class="validation">La template a été ajouté</div>';
    $_GET['action'] = 'affichage';
}
//--- LIENS TEMPALTES ---//
$contenu .= '<a href="?action=affichage">Affichage des templates</a><br>';
$contenu .= '<a href="?action=ajout">Ajout d\'une template</a><br><br><hr><br>';
//--- AFFICHAGE TEMPLATES ---//
if(isset($_GET['action']) && $_GET['action'] == "affichage")
{
    $resultat = executeRequete("SELECT * FROM template");
     
    $contenu .= '<h2> Affichage des templates </h2>';
    $contenu .= 'Nombre de template(s) dans la marketplace : ' . $resultat->num_rows;
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
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $information . '" ="70" height="70"></td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_template=' . $ligne['id_template'] .'"><img src="../inc/img/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_template=' . $ligne['id_template'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../inc/img/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><hr><br>';
}
//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("../inc/haut.inc.php");
echo $contenu;
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification'))
{
    if(isset($_GET['id_template']))
    {
        $resultat = executeRequete("SELECT * FROM template WHERE id_template=$_GET[id_template]");
        $template_actuel = $resultat->fetch_assoc();
    }
?>
<div id="conteneur">
    <h2> Formulaire Template </h2>
    <form method="post" enctype="multipart/form-data" action="">
     
        
        <input type="hidden" id="id_template" name="id_template" value="">
             
        <label for="reference">reference</label><br>
        <input type="text" id="reference" name="reference" placeholder="la référence de la template" value=""<?php if(isset($template_actuel['reference'])){ echo $template_actuel['reference'];}?>><br><br>
 
        <label for="auteur">auteur</label><br>
        <input type="text" id="auteur" name="auteur" placeholder="auteur de la template" value=""<?php if(isset($template_actuel['auteur'])){ echo $template_actuel['auteur'];} ?> > <br><br>

        <label for="titre">titre</label><br>
        <input type="text" id="titre" name="titre" placeholder="le titre de la template" value=""<?php if(isset($template_actuel['titre'])){ echo $template_actuel['titre'];} ?> > <br><br>
 
        <label for="description">description</label><br>
        <textarea name="description" id="description" placeholder="la description de la template"<?php if(isset($template_actuel['description'])){ echo $template_actuel['description'];}?>></textarea><br><br>
         
        <label for="photo">photo</label><br>
        <input type="file" id="photo" name="photo"><br><br>
        <?php
        if(isset($template_actuel))
        {
            echo '<i>Vous pouvez uplaoder une nouvelle photo si vous souhaitez la changer</i><br>';
            echo '<img src="' . $template_actuel['photo'] . '"  ="90" height="90"><br>';
            echo '<input type="hidden" name="photo_actuelle" value="' . $template_actuel['photo'] . '"><br>';
        }
        ?>
        <input type="submit" value="Enregistere la template">
    </form>;
</div>
<?php
}
require_once("../inc/bas.inc.php"); ?>