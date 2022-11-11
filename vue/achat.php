<?php
    session_start();
    include_once '../modele/connexion.php';
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Achat - Aublet</title>
    <link href="./css/style_achat.css" rel="stylesheet" type="text/css" />
    <link href="./img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <a class="logo" href="./accueil.html">
            <img src="./img/logo.png" alt="ablet logo" />
        </a>
        <div class="search_part">
            <img src="icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
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
                <img src="./icons/account.png" alt="User account icon" class="user_account" />
            </div>
            <button class="caddie_utilisateur" onclick="on()">
                <img src="./icons/shopping-cart.png" alt="shopcart icon" class="caddie_logo" />
                <div class="montant_caddie">
                    <?php
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
                <img src="./icons/down.PNG" alt="show more icon" class="show_caddie_icon" />
            </button>
        </div>
    </div>

    

    


    
    <div class="articles">


        <?php

            if (isset($_GET["Search"])) {
                if (is_numeric($_GET["Search"])) {
                    $requete = 'SELECT * FROM article WHERE refart LIKE "%'.$_GET["Search"].'%";';
                } else {
                    $requete = 'SELECT * FROM article WHERE designation LIKE "%'.$_GET["Search"].'%";';

                }
            } else {
                $requete = 'SELECT * FROM article';
            }


            $res = $db->prepare($requete);
            $res->execute();

            $i = 0;
            $row = 1;
            $column = 1;

            foreach ($res as $article) {
                echo '<div id="article'.$i.'" class="article">';
                echo '<img src="'.$article['imagelien'].'" sizes="(max-width: 767px) 100vw, (max-width: 991px) 9vw, 16vw" alt="image de l\'article" class="img_article" />';
                echo '<div class="nom_article">'.$article['designation'].'</div>';
                echo '<div class="details_article"><div class="infos_article"><div class="div-block-12"><div class="text-block-9">Ref : </div>';
                echo '<div class="text-block-10">'.$article['refart'].'</div></div>';
                echo '<div class="div-block-12"><div class="text-block-9">Qte : </div>';
                echo '<div class="text-block-10">'.$article['unitecond'].'</div></div></div>';
                echo '<div class="prix-achat">';
                
                if ($article['remise'] != 0) {
                    echo '<div class="reduction"><div class="div-block-14"><div class="text-block-13">';
                    echo '-'.$article['remise'].'%';
                    echo '</div></div><div class="text-block-14">';
                    echo $article['pu'].'€';
                    echo '</div></div>';
                }

                echo '<div class="prix">';
                if ($article['remise'] != 0) {
                    echo number_format($article['pu'] * ((100-$article['remise'])/100), 2);
                } else {
                    echo $article['pu'];
                }    
                echo '€</div><a href="#" class="achat w-inline-block">';
                echo '<img src="./icons/shopping-cart_white.png" sizes="(max-widht: 767px) 100vw, (max-width: 991px) 4vw, 30px" alt="shopping_cart_icons" class="caddie_icon"/></a>';
                echo '</div></div></div>';

                echo '<style> #article'.$i.' { ';
                echo '-ms-grid-row: '.$row.';';
                echo 'grid-row-start: '.$row.';';
                echo '-ms-grid-row-span: 1;';
                echo 'grid-row-end: '.($row+1).';';
                echo '-ms-grid-column: '.$column.';';
                echo 'grid-column-start: '.$column.';';
                echo '-ms-grid-column-span: 1;';
                echo 'grid-column-end: '.($column+1).';}';
                echo '</style>';

                $i++;
                $column++;
                if ($column > 4) {
                    $column = 1;
                    $row++;
                }
            }

        ?>
    </div>



    <div id="affichage_apercu_panier">
        <div class="apercu_panier">
            <?php 
                echo '<div class="en_tete_apercu">';
                echo '<img src="./icons/hand_shopping-cart.png" sizes="(max-width: 479px) 100vw, (max-width: 767px) 24vw, 178px" alt="" class="panier_icon" />';
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
                
                echo '<div class="close" onclick="off()"><img src="./icons/close.png" alt="" class="image-7" /></div>';
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
                        echo '<img src="./icons/delete.png" sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 2vw" alt="supprimer" class="qte" />';
                    } else {
                        echo '<img src="./icons/minus.png" alt="" class="qte" />';
                    }
                    
                    echo '<div class="nb_article_panier">'.number_format($article['qte'], 0).'</div>';
                    
                    echo '<img src="./icons/plus.png" sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 19.600006103515625px" alt="" class="qte" />';
                    echo '</div>';
                    echo '</div><a href="#" class="supprimer_article">Supprimer</a>';
                    echo '</div>';  
                }

                echo '<a href="#" class="link-block w-inline-block">';
                echo '<img src="./icons/delete_grey.png" sizes="(max-width: 479px) 13vw, 30px" alt="supprimer" class="image-10" />';
                echo '<div>Vider mon panier</div>';
                echo '</a>';

                echo '</div>';
                echo '<div class="footer_apercu">';
                echo '<div class="montant_total_panier">';
                echo '<div class="total">Total :</div>';
                echo '<div class="total_euro">'.number_format($montantTotal, 2).'€</div>';
                echo '</div><a href="#" class="valider_panier w-inline-block">';
                echo '<img src="./icons/shopping-cart_white.png" sizes="(max-width: 479px) 100vw, (max-width: 767px) 58px, 9vw" alt="" class="caddie_icon" />';
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