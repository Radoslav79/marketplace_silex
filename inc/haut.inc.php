<!Doctype html>
<html>
    <head>
        <title>Marketplace Silex</title>
        <link rel="stylesheet" href="<?php echo RACINE_SITE; ?>inc/css/style.css">
    </head>
    <body>    
        <header>
            <div class="conteneur">
                <div>
                    <h2>Marketplace Silex</h2>
                </div>
                <nav>
                    <?php
                    if(internauteEstConnecteEtEstAuteur())
                    {
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_membre.php">Gestion des membres</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_commande.php">Gestion des commandes</a>';
                        echo '<a href="' . RACINE_SITE . 'admin/gestion_marketplace.php">Gestion de la Marketplace</a>';
                    }
                    if(internauteEstConnecte())
                    {
                        echo '<a href="' . RACINE_SITE . 'profil.php">Voir votre profil</a>';
                        echo '<a href="' . RACINE_SITE . 'marketplace.php">Accès à la Marketplace</a>';
                        echo '<a href="' . RACINE_SITE . 'commande.php">Voir votre commande</a>';
                        echo '<a href="' . RACINE_SITE . 'connexion.php?action=deconnexion">Se déconnecter</a>';
                    }
                    else
                    {
                        echo '<a href="' . RACINE_SITE . 'inscription.php">Inscription</a>';
                        echo '<a href="' . RACINE_SITE . 'connexion.php">Connexion</a>';
                        echo '<a href="' . RACINE_SITE . 'marketplace.php">Accès à la marketplace</a>';
                        echo '<a href="' . RACINE_SITE . 'panier.php">Voir votre commande</a>';
                    }
                    ?>
                </nav>
            </div>
        </header>
        <section>
            <div class="conteneur">