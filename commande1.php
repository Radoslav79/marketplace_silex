<?php
require_once("inc/init.inc.php");
//--------------------------------- TRAITEMENTS PHP ---------------------------------//
//--- AJOUT COMMANDE ---//
if(isset($_POST['ajout_commande'])) 
{   // debug($_POST);
    $resultat = executeRequete("SELECT * FROM template WHERE id_template='$_POST[id_template]'");
    $template = $resultat->fetch_assoc();
    ajouterProduitDansPanier($template['titre'],$_POST['id_template'],$_POST['quantite'],$template['prix']);
}
//--- VIDER COMMANDE ---//
if(isset($_GET['action']) && $_GET['action'] == "vider")
{
    unset($_SESSION['commande']);
}
//--- PAIEMENT ---//
if(isset($_POST['payer']))
{
    for($i=0 ;$i < count($_SESSION['commande']['id_template']) ; $i++) 
    {
        $resultat = executeRequete("SELECT * FROM produit WHERE id_produit=" . $_SESSION['commande']['id_produit'][$i]);
        $ptemplate= $resultat->fetch_assoc();
        if($template['stock'] < $_SESSION['commande']['quantite'][$i])
        {
            $contenu .= '<hr><div class="erreur">Stock Restant: ' . $template['stock'] . '</div>';
            $contenu .= '<div class="erreur">Quantité demandée: ' . $_SESSION['commande']['quantite'][$i] . '</div>';
            if($template['stock'] > 0)
            {
                $contenu .= '<div class="erreur">la quantité de template ' . $_SESSION['commande']['id_template'][$i] . ' à été réduite car notre stock était insuffisant, veuillez vérifier vos achats.</div>';
                $_SESSION['commande']['quantite'][$i] = $template['stock'];
            }
            else
            {
                $contenu .= '<div class="erreur">l\'template ' . $_SESSION['commande']['id_template'][$i] . ' à été retiré de votre commande car nous sommes en rupture de stock, veuillez vérifier vos commandes.</div>';
                retirerTemplateDeLaCommande($_SESSION['commande']['id_template'][$i]);
                $i--;
            }
            $erreur = true;
        }
    }
    if(!isset($erreur))
    {
        executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . "," . montantTotal() . ", NOW())");
        $id_commande = $mysqli->insert_id;
        for($i = 0; $i < count($_SESSION['commande']['id_template']); $i++)
        {
            executeRequete("INSERT INTO details_commande (id_commande, id_template, quantite, prix) VALUES ($id_commande, " . $_SESSION['commande']['id_template'][$i] . "," . $_SESSION['commande']['quantite'][$i] . "," . $_SESSION['commande']['prix'][$i] . ")");
        }
        unset($_SESSION['commande']);
        mail($_SESSION['membre']['email'], "confirmation de la commande", "Merci votre n° de suivi est le $id_commande", "From:auteur@dp_marketplace.com");
        $contenu .= "<div class='validation'>Merci pour votre commande. votre n° de suivi est le $id_commande</div>";
    }
}
 
//--------------------------------- AFFICHAGE HTML ---------------------------------//
include("inc/haut.inc.php");
echo $contenu;
echo "<table border='1' style='border-collapse: collapse' cellpadding='7'>";
echo "<tr><td colspan='5'>Commande</td></tr>";
echo "<tr><th>Titre</th><th>Template</th><th>Quantité</th><th>Prix Unitaire</th></tr>";
if(empty($_SESSION['commande']['id_template'])) // panier vide
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
        echo "<td>" . $_SESSION['commande']['quantite'][$i] . "</td>";
        echo "<td>" . $_SESSION['commande']['prix'][$i] . "</td>";
        echo "</tr>";
    }
    echo "<tr><th colspan='3'>Total</th><td colspan='2'>" . montantTotal() . " euros</td></tr>";
    if(internauteEstConnecte()) 
    {
        echo '<form method="post" action="">';
        echo '<tr><td colspan="5"><input type="submit" name="payer" value="Valider et déclarer le paiement"></td></tr>';
        echo '</form>';   
    }
    else
    {
        echo '<tr><td colspan="3">Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir payer</td></tr>';
    }
    echo "<tr><td colspan='5'><a href='?action=vider'>Vider ma commande</a></td></tr>";
}
echo "</table><br>";
echo "<i>Réglement par CHÈQUE uniquement à l'adresse suivante : 300 rue de vaugirard 75015 PARIS</i><br>";
// echo "<hr>session panier:<br>"; debug($_SESSION);
include("inc/bas.inc.php");
?>