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

        function supprimerArticle(string $refart) {
            global $db;
            $requete = 'DELETE
                        FROM caddie
                        WHERE idutilisateur='.$_SESSION['idutilisateur'].' AND refart='.$refart.';';
            $db->exec($requete);
        }

        function reduireArticle(string $refart) {
            global $db;
            $requete = 'UPDATE caddie
                        SET qte = qte-1
                        WHERE idutilisateur='.$_SESSION['idutilisateur'].' AND refart='.$refart.';';
            $db->exec($requete);
        }

        function articleDansCaddie(string $refart): bool {
            global $db;
            $requete = $db->prepare('SELECT * FROM caddie WHERE idutilisateur='.$_SESSION['idutilisateur'].' AND refart='.$refart.';');
            $requete->execute();

            $nbResult = $requete->rowCount();
            if ($nbResult != 0) {
                return true;
            } else {
                return false;
            }
        }

        function ajouterArticleCaddie(string $refart) {
            global $db;

            if (!articleDansCaddie($refart)) {
                $requete = 'INSERT INTO caddie(idutilisateur, refart, qte)
                        VALUES ("'.$_SESSION['idutilisateur'].'", "'.$refart.'", "1");';
            } else {
                $requete = 'UPDATE caddie
                            SET qte = qte+1
                            WHERE idutilisateur='.$_SESSION['idutilisateur'].' AND refart='.$refart.';';
            }
            $db->exec($requete);
        }
        
        if (isset($_GET['fct'])) {
            switch ($_GET['fct']) {
                case 'viderPanier':
                    nouveauCaddie();
                    break;
                
                case 'suppArticle':
                    supprimerArticle($_GET['art']);
                    break;
        
                case 'redArticle':
                    reduireArticle($_GET['art']);
                    break;
        
                case 'ajoutArticle':
                    ajouterArticleCaddie($_GET['art']);
                    break;
            }
        }
    ?>

<head>
    <meta charset="utf-8" />
    <title>Ajouter client - Aublet</title>
    <link href="../css/style_modification.css" rel="stylesheet" type="text/css" />
    <link href="../img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <a href="../accueil.php" class="logo">
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
                <h1 class="heading">Ajouter</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="modification_form">
                <div class="input_part">
                    <div class="inputs_side">
                        <label for="prenom" class="field-label">Prénom</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="prenom" data-name="prenom" placeholder="" id="prenom" />
                        <label for="nom" class="field-label">Nom</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="nom" data-name="nom" id="nom" />
                        <div class="civilite_input" style="margin-right: 0; margin-left: 0;">
                            <div class="field-label">Civilité</div>
                            <div class="radios_bouton">
                                <label class="radio-button-field w-radio">
                                    <input type="radio" id="Monsieur" name="civilite" value="M." data-name="civilite" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="Monsieur">Monsieur</span>
                                </label>
                                <label class="w-radio">
                                    <input type="radio" id="Madame" name="civilite" value="Mme." data-name="civilite" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="Madame">Madame</span>
                                </label>
                                <label class="w-radio">
                                    <input type="radio" id="Autre" name="civilite" value="Mx." data-name="civilite" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="radio">Autre</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="inputs_side">
                    <label for="mel" class="field-label">Mail</label>
                        <input type="email" class="text-field w-input" autofocus="true" maxlength="256" name="mel" data-name="mel" placeholder="" id="mel" />
                        <label for="login" class="field-label">Login</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="login" data-name="login" placeholder="" id="login" />
                        <label for="mdp" class="field-label">Mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="mdp" data-name="mdp" placeholder="" id="mdp" />
                        <label for="conf_mdp" class="field-label">Confirmer mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="conf_mdp" data-name="conf_mdp" placeholder="" id="conf_mdp" />
                    </div>
                </div>
                <div class="modifier">
                    <button type="submit" class="modifier_bouton w-button" target="_blank">Ajouter</button>
                </div>
            </form>

            <?php
                function clientExiste($login): bool {
                    global $db;
                    $query = $db->prepare('SELECT * FROM utilisateur WHERE login = :login ;');
                    $query->execute(array(
                        'login' => $login
                    ));
                    $resquery = $query->rowCount();
                    if ($resquery != 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function verifFormatMail($mail): bool {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if (!empty($_POST)){
                    if ($_POST['prenom'] != '' && $_POST['nom'] != '' && $_POST['civilite'] != '' && $_POST['mel'] != '' && $_POST['login'] && $_POST['mdp'] != '' && $_POST['mdp'] == $_POST['conf_mdp']) {
                        $prenom = $_POST['prenom'];
                        $nom = $_POST['nom'];
                        $civilite = $_POST['civilite'];
                        $mel = $_POST['mel'];
                        $login = $_POST['login'];
                        $mdp = $_POST['mdp'];
    
    
                        
                        if (!clientExiste($login) && verifFormatMail($mel)) {
                            $query = $db->prepare('INSERT INTO utilisateur(nom, prenom, civilite, mel, login, mdp)
                                                VALUE(:nom, :prenom, :civilite, :mel, :login, :mdp);');
                            $query->execute(array(
                                'nom' => strtoupper($nom),
                                'prenom' => $prenom,
                                'civilite' => $civilite,
                                'mel' => $mel,
                                'login' => $login,
                                'mdp' => $mdp
                            ));
    
                            echo "Utilisateur ajouté avec succès."; 
                        } else {
                            echo "L'utilisateur est déjà présent dans la liste des utilisateurs.";
                        }
                    } else {
                        echo "Veuillez remplir tous les champs.";
                    }
                }
            ?>

        </div>
    </div>


    <div id="affichage_apercu_panier" style="<?php if(isset($_GET['cad'])) { echo "display:block;";} else { echo "display:none;";} ?>">
        <div class="apercu_panier">
            <?php 
                echo '<div class="en_tete_apercu">';
                echo '<img src="../icons/hand_shopping-cart.png" sizes="(max-width: 479px) 100vw, (max-width: 767px) 24vw, 178px" alt="" class="panier_icon" />';
                echo '<div class="titre_apercu_panier">Votre panier :</div>';
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
                

                $requete =  'SELECT designation, qte, pu, remise, imagelien, unitecond, article.refart AS refart
                FROM caddie 
                INNER JOIN article ON caddie.refart = article.refart 
                WHERE idutilisateur = '.$_SESSION['idutilisateur'].';';

                $caddieUser = $db->prepare($requete);
                $caddieUser->execute();

                $montantTotal = 0;

                foreach ($caddieUser as $article) {
                    
                    echo '<div class="article_panier">';
                    echo '<div class="details_article_panier">';
                    echo '<img src="../'.$article['imagelien'].'" sizes="(max-width: 479px) 100vw, (max-width: 767px) 4vw, 5vw" alt="image de l\'article" class="img_article_liste" />';
                    echo '<div class="infos_articles_panier">';
                    echo '<div class="text-block-23">'.$article['designation'].'</div>';
                    
                    echo '<div class="div-block-23">';
                    echo '<div class="text-block-28">Cond :</div>';
                    echo '<div>'.$article['unitecond'].'</div>';
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
                        echo '<a href="./gestion_client_ajouter.php?fct=suppArticle&art='.$article['refart'].'&cad=on" class="qte">';
                        echo '<img src="../icons/delete.png" alt="supprimer" />';
                        echo '</a>';
                    } else {
                        echo '<a href="./gestion_client_ajouter.php?fct=redArticle&art='.$article['refart'].'&cad=on" class="qte">';
                        echo '<img src="../icons/minus.png" alt="reduire"/>';
                        echo '</a>';
                    }
                    
                    echo '<div class="nb_article_panier">'.number_format($article['qte'], 0).'</div>';
                    
                    echo '<a href="./gestion_client_ajouter.php?fct=ajoutArticle&art='.$article['refart'].'&cad=on" class="qte">';
                    echo '<img src="../icons/plus.png" alt="ajouter"/>';
                    echo '</a>';

                    echo '</div>';
                    echo '</div><a href="./gestion_client_ajouter.php?fct=suppArticle&art='.$article['refart'].'&cad=on" class="supprimer_article">Supprimer</a>';
                    echo '</div>';  
                }

                echo '<a href="./gestion_client_ajouter.php?fct=viderPanier&cad=on" class="link-block w-inline-block">';
                echo '<img src="../icons/delete_grey.png" sizes="(max-width: 479px) 13vw, 30px" alt="supprimer" class="image-10" />';
                echo '<div>Vider mon panier</div>';
                echo '</a>';

                echo '</div>';
                echo '<div class="footer_apercu">';
                echo '<div class="montant_total_panier">';
                echo '<div class="total">Total :</div>';
                echo '<div class="total_euro">'.number_format($montantTotal, 2).'€</div>';
                echo '</div><a href="../accueil.php" class="valider_panier w-inline-block">';
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

