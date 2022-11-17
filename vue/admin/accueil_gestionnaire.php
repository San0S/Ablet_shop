<?php
    session_start();
    require_once '../../modele/db.php';
?>

<!DOCTYPE html>
<html>
    <?php
        
        function nouveauCaddie() {
            global $db;
            $requete = 'DELETE  
                        FROM caddie
                        WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
            $db->exec($requete);
        }

        if (isset($_GET['nouveau'])) {
            nouveauCaddie();
            header('Location: ./achat.php');
        }
    ?>

<head>
    <meta charset="utf-8" />
    <title>Accueil - Aublet</title>
    <link href="../css/style_accueil.css" rel="stylesheet" type="text/css" />
    <link href="../img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <a class="logo" href="accueil.php">
            <img src="../img/logo.png" alt="ablet logo" />
        </a>
        <div class="search_part">
            <img src="../icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
            <div class="search_form_block w-form">
                <form id="wf-form-Search-Form" name="wf-form-Search-Form" data-name="Search Form" method="get"
                    class="search_form" action="achat.php">
                    <input type="text" class="search_field w-input" maxlength="256" name="Search" data-name="Search"
                        placeholder="Rechercher un produit..." id="Search" />
                    <input type="submit" data-wait="Veuillez patienter..." value="Rechercher"
                        class="rechercher_bouton w-button" />
                </form>
            </div>
        </div>
        <div class="right_part_menu">
                <div class="user_block">
                    <div class="user_message">
                        <div class="bonjour">Bonjour</div>
                        <div class="username"><?php echo $_SESSION['prenom']; ?></div>
                    </div>
                    <a href="../../modele/modification.php">
                        <img src="../icons/account.png" alt="User account icon" class="user_account" />
                    </a>
                </div>
                <!-- <span style="font-size:14px;">
                    <span class="text-content">
                        Déconnexion
                    </span>
                </span> -->
            <button class="caddie_utilisateur" onclick="on()">
                <img src="../icons/shopping-cart.png" alt="shopcart icon" class="caddie_logo" />
                <div class="montant_caddie">
                    <?php


                        $requete = 'SELECT idutilisateur 
                                    FROM utilisateur
                                    WHERE nom="'.strtoupper($_SESSION['nom']).'" AND prenom="'.$_SESSION['prenom'].'";';
                        $iduser = $db->prepare($requete);
                        $iduser->execute();

                        foreach ($iduser as $id) {
                            $_SESSION['idutilisateur'] = $id['idutilisateur'];
                        }


                        $requete = 'SELECT qte, pu, remise
                                    FROM caddie
                                    INNER JOIN article ON caddie.refart = article.refart
                                    WHERE caddie.idutilisateur = '.$_SESSION['idutilisateur'].';';
                        $caddie = $db->prepare($requete);
                        $caddie->execute();

                        $montantCaddie = 0;
                        foreach ($caddie as $article) {
                            if ($article['remise'] != 0) {
                                $prix = ($article['pu'] * ((100-$article['remise'])/100) ) * $article['qte'];
                            } else {
                                $prix = $article['pu'] * $article['qte'];
                            }
                            $montantCaddie += $prix;
                        }
                        echo number_format($montantCaddie, 2).'€';
                        
                    ?>

                </div>
                <img src="../icons/down.PNG" alt="show more icon" class="show_caddie_icon" />
            </button>
        </div>
    </div>



    <div class="content">
        <div class="accueil">
            <div class="en_tete_form">
                <img src="../icons/home.png" alt="home icon"
                    sizes="(max-width: 479px) 75vw, (max-width: 673px) 76vw, 512px" class="home_icon" />
                <h1 class="heading">Accueil (Gestion)</h1>
            </div>
            <div class="texte_accueil">Que voulez-vous faire aujourd&#x27;hui ?</div>
            <div class="boutons">
                <a href="../accueil.php" name="fonct_client" value="fonct_client" class="accueil_bouton w-button">Fonctionnalités client</a>
                <a href="./menu_gestion_clients.php" name="gestion_client" value="gestion_client" class="accueil_bouton w-button">Gestion des clients</a>
                <a href="./menu_gestion_articles.php" name="gestion_article" value="gestion_article" class="accueil_bouton w-button">Gestion des articles</a>
            </div>

        </div>
    </div>







    <div id="affichage_apercu_panier">
        <div class="apercu_panier">
            <?php 
                echo '<div class="en_tete_apercu">';
                echo '<img src="../icons/hand_shopping-cart.png" sizes="(max-width: 479px) 100vw, (max-width: 767px) 24vw, 178px" alt="" class="panier_icon" />';
                echo '<div class="titre_apercu_panier">Aperçu du panier :</div>';
                $requete =  'SELECT designation, qte, pu, remise, imagelien
                            FROM caddie 
                            INNER JOIN article ON caddie.refart = article.refart 
                            WHERE idutilisateur = '.$_SESSION['idutilisateur'].';';

                $caddieUser = $db->prepare($requete);
                $caddieUser->execute();
                $nbArticles = 0;

                foreach ($caddieUser as $produits) {
                    $nbArticles++;
                }

                echo '<div>'.$nbArticles.' produit(s)</div>';
                
                echo '<div class="close" onclick="off()"><img src="../icons/close.png" alt="" class="image-7" /></div>';
                echo "</div>";
                echo '<div class="liste_articles_parnier">';
                

                $requete =  'SELECT designation, qte, pu, remise, imagelien
                FROM caddie 
                INNER JOIN article ON caddie.refart = article.refart 
                WHERE idutilisateur = '.$_SESSION['idutilisateur'].';';

                $caddieUser = $db->prepare($requete);
                $caddieUser->execute();

                $montantTotal = 0;

                foreach ($caddieUser as $article) {
                    
                    echo '<div class="article_panier">';
                    echo '<div class="details_article_panier">';
                    echo '<img src="'.$article['imagelien'].'" sizes="(max-width: 479px) 100vw, (max-width: 767px) 4vw, 5vw" alt="image de l\'article" class="img_article_liste" />';
                    echo '<div class="infos_articles_panier">';
                    echo '<div class="text-block-23">'.$article['designation'].'</div>';
                    
                    echo '<div class="div-block-23">';
                    echo '<div class="text-block-28">Qte :</div>';
                    echo '<div>'.$article['qte'].'</div>';
                    echo '</div>';
                    echo '</div>';
                    if ($article['remise'] != 0) {
                        $prix = ($article['pu'] * ((100-$article['remise'])/100) ) * $article['qte'];
                    } else {
                        $prix = $article['pu'] * $article['qte'];
                    }
                    $montantTotal += $prix;

                    echo '<div class="prix_article_panier">'.number_format($prix, 2).'€</div>';
                    echo '<div class="gestion_qte_article_panier">';

                    if ($article['qte'] == 1) {
                        echo '<img src="../icons/delete.png" sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 2vw" alt="supprimer" class="qte" />';
                    } else {
                        echo '<img src="../icons/minus.png" alt="" class="qte" />';
                    }
                    
                    echo '<div class="nb_article_panier">'.number_format($article['qte'], 0).'</div>';
                    
                    echo '<img src="../icons/plus.png" sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 19.600006103515625px" alt="" class="qte" />';
                    echo '</div>';
                    echo '</div><a href="#" class="supprimer_article">Supprimer</a>';
                    echo '</div>';  
                }

                echo '<a href="#" class="link-block w-inline-block">';
                echo '<img src="../icons/delete_grey.png" sizes="(max-width: 479px) 13vw, 30px" alt="supprimer" class="image-10" />';
                echo '<div>Vider mon panier</div>';
                echo '</a>';

                echo '</div>';
                echo '<div class="footer_apercu">';
                echo '<div class="montant_total_panier">';
                echo '<div class="total">Total :</div>';
                echo '<div class="total_euro">'.number_format($montantTotal, 2).'€</div>';
                echo '</div><a href="#" class="valider_panier w-inline-block">';
                echo '<img src="../icons/shopping-cart_white.png" sizes="(max-width: 479px) 100vw, (max-width: 767px) 58px, 9vw" alt="" class="caddie_icon" />';
                echo '<div class="text-block-21">Valider mon panier</div>';
                echo '</a>';  
            ?>
        </div>
    </div>

    <script>
        function on() {

            document.getElementById("affichage_apercu_panier").style.display = "block";
        }

        function off() {
            document.getElementById("affichage_apercu_panier").style.display = "none";
        }
    </script>



</body>

</html>