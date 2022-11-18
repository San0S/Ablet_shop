<?php
session_start();
require_once './db.php';
?>


<!DOCTYPE html>
<html>


    <?php

        function mailExiste($mail): bool {
            global $db;
            $requete = "SELECT mel
                        FROM utilisateur ;";
            $usersmail = $db->prepare($requete);
            $usersmail->execute();

            foreach ($usersmail as $usermail) {
                if ($usermail['mel'] == $mail) {
                    return true;
                }
            }

            return false;

            
            // $query->execute(array
            //     'mail' => $mail
            // ));
            // $resquery = $query->rowCount();
            // if ($resquery != 0) {
            //     return true;
            // } else {
            //     return false;
            // }
        }

        function verifFormatMail($mail): bool {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }

        function verifAncienMdp($mdp): bool {
            global $db;
            $requete = 'SELECT mdp
                        FROM utilisateur
                        WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
            $usermdp = $db->prepare($requete);
            $usermdp->execute();

            foreach($usermdp as $oldmdp) {
                if ($oldmdp['mdp'] == $mdp) {
                    return true;
                }
            }

            return false;
        }

        // if (isset($_GET['uid']) && $_GET['uid'] != '') {
        //     $requete = 'SELECT *
        //                 FROM utilisateur
        //                 WHERE idutilisateur='.$_GET['uid'].';';
        //     $users = $db->prepare($requete);
        //     $users->execute();

        //     foreach ($users as $user) {
        //         $_SESSION['idutilisateur'] = $user['idutilisateur'];
        //         $_SESSION['nom'] = $user['nom'];
        //         $_SESSION['prenom'] = $user['prenom'];
        //         $_SESSION['civilite'] = $user['civilite'];
        //         $_SESSION['mel'] = $user['mel'];
        //         $_SESSION['login'] = $user['login'];
        //         $_SESSION['mdp'] = $user['mdp'];
        //     }
        // }


        if (!empty($_POST) && verifAncienMdp($_POST['mdp'])) {
            if ($_SESSION['prenom'] != $_POST['prenom']) {
                $modifprenom = 'UPDATE utilisateur SET prenom="'.$_POST['prenom'].'" WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
                $db->exec($modifprenom);
                $_SESSION['prenom'] = $_POST['prenom'];
            }
            if ($_SESSION['mel'] != $_POST['mel'] && !mailExiste($_POST['mel']) && verifFormatMail($_POST['mel'])) {
                $modifmel = 'UPDATE utilisateur SET mel="'.$_POST['mel'].'" WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
                $db->exec($modifmel);
                $_SESSION['mel'] = $_POST['mel'];
            }
            if ($_SESSION['civilite'] != $_POST['civilite']) {
                $modifciv = 'UPDATE utilisateur SET civilite="'.$_POST['civilite'].'" WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
                $db->exec($modifciv);
                $_SESSION['civilite'] = $_POST['civilite'];
            }

            if ($_SESSION['mdp'] != $_POST['new_mdp']) {
                $modifmdp = 'UPDATE utilisateur SET mdp="'.$_POST['new_mdp'].'" WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
                $db->exec($modifmdp);
                $_SESSION['mdp'] = $_POST['new_mdp'];
            }

            $referer = $_SERVER['HTTP_REFERER'];
            header("Location: $referer");

        }


        //     if ($_POST['old_mdp'] == '') {
        //         echo 'Veuillez rentrer votre ancien mot de passe pour enregistrer les modifications.';
        //     } elseif(!verifAncienMdp($_POST['old_mdp'])) {
        //         echo 'Ancien mot de passe incorrect.';
        //     } else {
        //         $requete =   'SELECT prenom, mel, civilite, mdp
        //                     FROM utilisateur
        //                     WHERE idutilisateur='.$_SESSION['idutilisateur'].';';
        //         $userinfo = $db->prepare($requete);
        //         $userinfo->execute();

        //         foreach ($userinfo as $info) {
        //             echo 'mel : "'.$info['mel'].'", civilite : "'.$info['civilite'].'", mdp : "'.$info['mdp'].'"';

        //         }
        //     }
        // }
    ?>

<head>
    <meta charset="utf-8" />
    <title>Modification - Aublet</title>
    <link href="../vue/css/style_modification.css" rel="stylesheet" type="text/css" />
    <link href="../vue/img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <a class="logo" href="../vue/accueil.php">
            <img src="../vue/img/logo.png" alt="ablet logo" />
        </a>
        <div class="search_part">
            <img src="../vue/icons/hand_shopping-cart.png" sizes="60px" alt="hand shopcart icon" class="panier" />
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
                <img src="../vue/icons/account.png" alt="User account icon" class="user_account" />
            </div>
            <div class="caddie_utilisateur">
                <img src="../vue/icons/shopping-cart.png" alt="shopcart icon" class="caddie_logo" />
                <div class="montant_caddie">0,00€</div>
                <img src="../vue/icons/down.PNG" alt="show more icon" class="show_caddie_icon" />
            </div>
        </div>
    </div>
    <div class="content">
        <div class="modification_form_block w-form">
            <div class="en_tete_form">
                <img src="../vue/icons/account.png" alt="account icon" />
                <h1 class="heading">Vos informations</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="modification_form" action="./modification.php">
                <div class="input_part">
                    <div class="inputs_side">
                        <label for="prenom" class="field-label">Prénom</label>
                        <input type="text" value="<?php echo $_SESSION['prenom']; ?>" class="text-field w-input" autofocus="true" maxlength="256" name="prenom" data-name="prenom" id="prenom" />
                        <label for="mel" class="field-label">Mail</label>
                        <input type="mail" class="text-field w-input" maxlength="256" name="mel" data-name="mel" value="<?php echo $_SESSION['mel']; ?>" id="mel" />
                    </div>
                    <div class="inputs_side">
                        <label for="mdp" class="field-label">Ancien mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="mdp" data-name="mdp" placeholder="" id="mdp" required/>
                        <label for="new_mdp" class="field-label">Nouveau mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="new_mdp" data-name="new_mdp" placeholder="" id="new_mdp" />
                    </div>
                </div>
                <div class="civilite_input">
                    <div class="field-label">Civilité</div>
                    <div class="radios_bouton">
                        <label class="radio-button-field w-radio">
                            <input type="radio" id="Monsieur" name="civilite" value="M." data-name="civilite" class="w-form-formradioinput w-radio-input"<?php if($_SESSION['civilite'] == 'M.') { echo " checked" ;} ?>/>
                            <span class="w-form-label" for="Monsieur">Monsieur</span>
                        </label>
                        <label class="w-radio">
                            <input type="radio" id="Madame" name="civilite" value="Mme." data-name="civilite" class="w-form-formradioinput w-radio-input" <?php if($_SESSION['civilite'] == 'Mme.') { echo "checked" ;} ?> />
                            <span class="w-form-label" for="Madame">Madame</span>
                        </label>
                        <label class="w-radio">
                            <input type="radio" id="Autre" name="civilite" value="Mx." data-name="civilite" class="w-form-formradioinput w-radio-input" <?php if($_SESSION['civilite'] == 'Mx.') { echo "checked" ;} ?> />
                            <span class="w-form-label" for="radio">Autre</span>
                        </label>
                    </div>
                </div>
                <div class="modifier">
                <button type="submit" name="modifier" class="modifier_bouton w-button">Modifier</button>
                </div>
            </form>

            <?php


                if (!empty($_POST)) {
                    if ($_POST['mdp'] == '') {
                        echo 'Veuillez rentrer votre ancien mot de passe pour enregistrer les modifications.';
                    } elseif(!verifAncienMdp($_POST['mdp'])) {
                        echo 'Ancien mot de passe incorrect.';
                    } 
                    
                    if(mailExiste($_POST['mel'])) {
                        echo "L'adresse mail renseignée est déjà utilisée, veuillez en choisir une autre.";
                    } elseif (!verifFormatMail($_POST['mel'])) {
                        echo "Le format du mail est incorrect.";
                    }
                }
            
                ?>

        </div>
    </div>
</body>
</html>


