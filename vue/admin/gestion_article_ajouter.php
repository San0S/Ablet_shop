<?php
    session_start(); 
    require_once '../../modele/db.php';
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Ajouter article - Aublet</title>
    <link href="../css/style_modification.css" rel="stylesheet" type="text/css" />
    <link href="../img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <a href="./accueil_gestionnaire.php" class="logo">
            <img src="../img/logo.png" alt="ablet logo" />
        </a>
        <div class="search_part">
            <img src="../icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
            <div class="search_form_block w-form">
                <form id="wf-form-Search-Form" name="wf-form-Search-Form" data-name="Search Form" method="get"
                    class="search_form" action="../achat.php">
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
                    <div class="username"><?php echo $_SESSION['prenom'] ?></div>
                </div>
                <a href="../../modele/modification.php">
                    <img src="../icons/account.png" alt="User account icon" class="user_account" />
                </a>
            </div>
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
        <div class="modification_form_block w-form">
            <div class="en_tete_form">
                <img src="../icons/plus_orange.png" alt="account icon" style="height: 80px;" />
                <h1 class="heading">Ajouter un article</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="modification_form">
                <div class="input_part">
                    <div class="inputs_side">
                        <label for="reference" class="field-label">Référence</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="reference" data-name="reference" placeholder="" id="reference" />
                        <label for="designation" class="field-label">Désignation</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="designation" data-name="designation" id="designation" />
                        <label for="lien_image" class="field-label">Lien de l'image</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="lien_image" data-name="lien_image" id="lien_image" />

                    </div>
                    <div class="inputs_side">
                        <label for="pu" class="field-label">Prix unitaire</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="pu" data-name="pu" placeholder="" id="pu" />
                        <label for="unitecond" class="field-label">Unité conditionnement</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="unitecond" data-name="unitecond" id="unitecond" />
                        <label for="remise" class="field-label">Remise</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="remise" data-name="remise" id="remise" />
                    </div>
                </div>
                <div class="modifier">
                    <button type="submit" class="modifier_bouton w-button" target="_blank">Ajouter</button>
                </div>
            </form>
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
                    
                    echo '<img src="./icons/plus.png" sizes="(max-width: 479px) 20vw, (max-width: 767px) 4vw, (max-width: 991px) 3vw, 19.600006103515625px" alt="" class="qte" />';
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

<?php
$idSes = session_id();

function articleExiste($ref): bool {
    global $db;
    $query = $db->prepare('SELECT * FROM article WHERE refart = :ref ;');
    $query->execute(array(
        'ref' => $ref
    ));
    $resquery = $query->rowCount();
    if ($resquery != 0) {
        return true;
    } else {
        return false;
    }
}

if ($_POST['reference'] != '' && is_numeric($_POST['reference']) && $_POST['designation'] != '' && $_POST['pu'] != '' && is_numeric($_POST['pu']) && $_POST['unitecond'] != '') {
    $refart = $_POST['reference'];
    $designation = $_POST['designation'];
    $pu = $_POST['pu'];
    $unitecond = $_POST['unitecond'];

    if ($_POST['remise'] == '' || !is_numeric($_POST['remise'])) {
        $remise = 0;
    } else {
        $remise = $_POST['remise'];
    }

    if ($_POST['lien_image'] == '') {
        $imagelien = "img/default.png";
    } else {
        $imagelien = $_POST['lien_image'];
    }

    if (!articleExiste($refart)) {
        $query = $db->prepare(' INSERT INTO article(refart, designation, pu, unitecond, remise, imagelien)
                                VALUE(:refart, :designation, :pu, :unitecond, :remise, :imagelien);');
        $query->execute(array(
            'refart' => $refart,
            'designation' => $designation,
            'pu' => $pu,
            'unitecond' => $unitecond,
            'remise' => $remise,
            'imagelien' => $imagelien
        ));

        echo "Article ajouté avec succès.";
    } else {
        echo "L'article est déjà présent dans le catalogue.";
    }
}
?>