<?php
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
        <img src="./img/logo.png" alt="ablet logo" class="logo" />
        <div class="search_part">
            <img src="icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
            <div class="search_form_block w-form">
                <form id="wf-form-Search-Form" name="wf-form-Search-Form" data-name="Search Form" method="get"
                    class="search_form">
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
                    <div class="username">Christophe</div>
                </div>
                <img src="./icons/account.png" alt="User account icon" class="user_account" />
            </div>
            <div class="caddie_utilisateur" onclick="on()">
                <img src="./icons/shopping-cart.png" alt="shopcart icon" class="caddie_logo" />
                <div class="montant_caddie">0,00€</div>
                <img src="./icons/down.PNG" alt="show more icon" class="show_caddie_icon" />
            </div>
        </div>
    </div>

    
    
    <div class="articles">


        <?php
            $requete = 'SELECT * FROM article';
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
            <div class="en_tete_apercu"><img src="./icons/hand_shopping-cart.png"
                    sizes="(max-width: 479px) 100vw, (max-width: 767px) 24vw, 178px"
                    srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc2e5fc3d16aec037a7_shopping-cart-p-500.png 500w, ./icons/hand_shopping-cart.png 512w"
                    alt="" class="panier_icon" />
                <div class="titre_apercu_panier">Aperçu du panier :</div>
                <div>## produit(s)</div>
                <div class="close" onclick="off()"><img src="./icons/close.png" alt="" class="image-7" /></div>
            </div>
            <div class="liste_articles_parnier">
                <div class="article_panier">
                    <div class="details_article_panier"><img src="./img/torsadees.jpg"
                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 4vw, 5vw" alt=""
                            class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange.jpg"
                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 4vw, 5vw"
                            srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-500.jpg 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-800.jpg 800w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-1080.jpg 1080w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-1600.jpg 1600w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-2000.jpg 2000w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange-p-2600.jpg 2600w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e41528a4bd6e4c30a_orange.jpg 2948w"
                            alt="" class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e1407d8dc8ac5b07c_dragee.jpg"
                            sizes="(max-width: 479px) 100vw, (max-width: 767px) 4vw, 5vw"
                            srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e1407d8dc8ac5b07c_dragee-p-500.jpg 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e1407d8dc8ac5b07c_dragee-p-800.jpg 800w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7e1407d8dc8ac5b07c_dragee.jpg 877w"
                            alt="" class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc170804598884dd008_delete.png"
                                sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 2vw"
                                srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc170804598884dd008_delete-p-500.png 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc170804598884dd008_delete.png 512w"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus.png"
                                sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 19.600006103515625px"
                                srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus-p-500.png 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus.png 512w"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5f7db5963643296e7b37_moutarde.jpg"
                            alt="" class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc141528a2d6ce4c465_minus.png"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus.png"
                                sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 19.600006103515625px"
                                srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus-p-500.png 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1bc9d9cd431e7d6ce_plus.png 512w"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg" alt=""
                            class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg" alt=""
                            class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div>
                <div class="article_panier">
                    <div class="details_article_panier"><img
                            src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg" alt=""
                            class="img_article_liste" />
                        <div class="infos_articles_panier">
                            <div class="text-block-23">Nom du produit</div>
                            <div class="div-block-23">
                                <div class="text-block-28">Qte :</div>
                                <div>####</div>
                            </div>
                        </div>
                        <div class="prix_article_panier">##,##€</div>
                        <div class="gestion_qte_article_panier"><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                            <div class="nb_article_panier">#</div><img
                                src="https://uploads-ssl.webflow.com/plugins/Basic/assets/placeholder.60f9b1840c.svg"
                                alt="" class="qte" />
                        </div>
                    </div><a href="#" class="supprimer_article">Supprimer</a>
                </div><a href="#" class="link-block w-inline-block"><img
                        src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1b5963601e26e7d30_delete_grey.png"
                        sizes="(max-width: 479px) 13vw, 30px"
                        srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1b5963601e26e7d30_delete_grey-p-500.png 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1b5963601e26e7d30_delete_grey.png 512w"
                        alt="" class="image-10" />
                    <div>Vider mon panier</div>
                </a>
            </div>
            <div class="footer_apercu">
                <div class="montant_total_panier">
                    <div class="total">Total :</div>
                    <div class="total_euro">##,##€</div>
                </div><a href="#" class="valider_panier w-inline-block"><img
                        src="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1618e0a1174b71dc5_shopping-cart_white.png"
                        srcset="https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1618e0a1174b71dc5_shopping-cart_white-p-500.png 500w, https://uploads-ssl.webflow.com/635d35b561099e76ee1dc3c9/635e5fc1618e0a1174b71dc5_shopping-cart_white.png 512w"
                        sizes="(max-width: 479px) 100vw, (max-width: 767px) 58px, 9vw" alt="" class="caddie_icon" />
                    <div class="text-block-21">Valider mon panier</div>
                </a>
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

<!-- test -->