<?php
    session_start(); 
    require_once '../../modele/db.php';
?>

<!DOCTYPE html>
<html>

    <?php

        if (isset($_GET['art']) && $_GET['art'] != '') {
            $requete = 'SELECT refart, designation, pu, unitecond, remise, imagelien
                        FROM article
                        WHERE refart='.$_GET['art'].';';
            $articles = $db->prepare($requete);
            $articles->execute();

            foreach ($articles as $article) {
                $_SESSION['refart'] = $article['refart'];
                $_SESSION['designation'] = $article['designation'];
                $_SESSION['pu'] = $article['pu'];
                $_SESSION['unitecond'] = $article['unitecond'];
                $_SESSION['remise'] = $article['remise'];
                $_SESSION['imagelien'] = $article['imagelien'];
            }
        }

    ?>

    <?php
            if (!empty($_POST)) {
                if ($_SESSION['refart'] != $_POST['refart']) {
                    $modifrefart = 'UPDATE article SET refart="'.$_POST['refart'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifrefart);
                    $_SESSION['refart'] = $_POST['refart'];
                }

                if ($_SESSION['designation'] != $_POST['designation']) {
                    $modifdesignation = 'UPDATE article SET designation="'.$_POST['designation'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifdesignation);
                    $_SESSION['designation'] = $_POST['designation'];
                }

                if ($_SESSION['pu'] != $_POST['pu']) {
                    $modifpu = 'UPDATE article SET pu="'.$_POST['pu'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifpu);
                    $_SESSION['pu'] = $_POST['pu'];
                }

                if ($_SESSION['unitecond'] != $_POST['unitecond']) {
                    $modifunitecond = 'UPDATE article SET unitecond="'.$_POST['unitecond'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifunitecond);
                    $_SESSION['unitecond'] = $_POST['unitecond'];
                }

                if ($_SESSION['remise'] != $_POST['remise']) {
                    $modifremise = 'UPDATE article SET remise="'.$_POST['remise'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifremise);
                    $_SESSION['remise'] = $_POST['remise'];
                }

                if ($_SESSION['imagelien'] != $_POST['imagelien']) {
                    $modifimagelien = 'UPDATE article SET imagelien="'.$_POST['imagelien'].'" WHERE refart='.$_SESSION['refart'].';';
                    $db->exec($modifimagelien);
                    $_SESSION['imagelien'] = $_POST['imagelien'];
                }

                $referer = $_SERVER['HTTP_REFERER'];
                header("Location: $referer");
            }
        ?>



<head>
    <meta charset="utf-8" />
    <title>Modifier article - Aublet</title>
    <link href="../css/style_modification.css" rel="stylesheet" type="text/css" />
    <link href="../img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <img src="../img/logo.png" alt="ablet logo" class="logo" />
        <div class="search_part">
            <img src="../icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
            <div class="search_form_block w-form">
                <form id="wf-form-Search-Form" name="wf-form-Search-Form" data-name="Search Form" method="get" class="search_form">
                    <input type="text" class="search_field w-input" maxlength="256" name="Search" data-name="Search" placeholder="Rechercher un produit..." id="Search" />
                    <input type="submit" data-wait="Veuillez patienter..." value="Rechercher" class="rechercher_bouton w-button" />
                </form>
            </div>
        </div>
        <div class="right_part_menu">
            <div class="user_block">
                <div class="user_message">
                    <div class="bonjour">Bonjour</div>
                    <div class="username"><?php echo $_SESSION['prenom'] ?></div>
                </div>
                <img src="../icons/account.png" alt="User account icon" class="user_account" />
            </div>
            <div class="caddie_utilisateur">
                <img src="../icons/shopping-cart.png" alt="shopcart icon" class="caddie_logo" />
                <div class="montant_caddie">0,00€</div>
                <img src="../icons/down.PNG" alt="show more icon" class="show_caddie_icon" />
            </div>
        </div>
    </div>
    <div class="content">
        <div class="modification_form_block w-form">
            <div class="en_tete_form">
                <img src="../icons/edit.png" alt="account icon" style="height: 80px;" />
                <h1 class="heading">Modifier</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="modification_form">
                <div class="input_part">
                    <div class="inputs_side">
                        <label for="refart" class="field-label">Référence</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="refart" data-name="refart" placeholder="" id="refart" value="<?php echo $_SESSION['refart']; ?>" />
                        <label for="designation" class="field-label">Désignation</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="designation" data-name="designation" id="designation" value="<?php echo $_SESSION['designation']; ?>" />
                        <label for="imagelien" class="field-label">Lien de l'image</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="imagelien" data-name="imagelien" id="imagelien" value="<?php echo $_SESSION['imagelien']; ?>" />

                    </div>
                    <div class="inputs_side">
                        <label for="pu" class="field-label">Prix unitaire</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="pu" data-name="pu" placeholder="" id="pu" value="<?php echo $_SESSION['pu'];?>" />
                        <label for="unitecond" class="field-label">Unité conditionnement</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="unitecond" data-name="unitecond" id="unitecond" value="<?php echo $_SESSION['unitecond'];?>" />
                        <label for="remise" class="field-label">Remise</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="remise" data-name="remise" id="remise" value="<?php echo $_SESSION['remise'];?>" />
                    </div>
                </div>
                <div class="modifier">
                    <button type="submit" class="modifier_bouton w-button" target="_blank">Modifier</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>