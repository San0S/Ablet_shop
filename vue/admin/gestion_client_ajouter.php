<?php
    session_start(); 
    require_once '../../modele/db.php';
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Ajouter client - Aublet</title>
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
    <div class="form">
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
                                    <input type="radio" id="Monsieur" name="radio" value="Monsieur" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="Monsieur">Monsieur</span>
                                </label>
                                <label class="w-radio">
                                    <input type="radio" id="Madame" name="radio" value="Madame" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="Madame">Madame</span>
                                </label>
                                <label class="w-radio">
                                    <input type="radio" id="radio" name="radio" value="Radio" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                    <span class="w-form-label" for="radio">Autre</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="inputs_side">
                    <label for="mail" class="field-label">Mail</label>
                        <input type="email" class="text-field w-input" autofocus="true" maxlength="256" name="mail" data-name="mail" placeholder="" id="mail" />
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
        </div>
    </div>
</body>

</html>



<?php
$idSes = session_id();
// $currentmdp = $_SESSION['mdp'];

function mailExiste($mail): bool {
    global $db;
    $query = $db->prepare('SELECT * FROM utilisateur WHERE mel = :mail');
    $query->execute(array(
        'mail' => $mail
    ));
    $resquery = $query->rowCount();
    if ($resquery != 0) {
        return true;
    } else {
        return false;
    }
}

function verifMdpChangement($old_mdp, $currentmdp): bool {
    if ($old_mdp == $currentmdp) {
        return true;
    } else {
        return false;
    }
}



if (isset($_POST['prenom']) && isset($_POST['radio']) && isset($_POST['old_mdp']) && isset($_POST['new_mdp']) && isset($_POST['mail'])) {

    $prenom = $_POST['prenom'];
    $radio = $_POST['radio'];
    $old_mdp = $_POST['old_mdp'];
    $new_mdp = $_POST['new_mdp'];
    $mail = $_POST['mail'];

    if (mailExiste($mail)) {
        $errMsg = "Ce mail est déjà utilisé";
    }
    if (!verifMdpChangement($old_mdp, $currentmdp)) {
        $errMsg = "Ancien mot de passe incorrect, veuillez réessayer";
    }


    if (!mailExiste($mail)) {
        if (verifMdpChangement($old_mdp, $currentmdp)) {
            $query = $db->prepare('UPDATE utilisateur SET prenom = :prenom, civilite = :radio, mdp = :new_mdp, mel = :mail WHERE idutilisateur = :idutilisateur');
            $query->execute(array(
                'prenom' => $prenom,
                'radio' => $radio,
                'new_mdp' => $new_mdp,
                'mel' => $mail
            ));

            $_SESSION['sid'] = $idSes;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['civilite'] = $civilite;
            $_SESSION['mel'] = $mail;
            $_SESSION['mdp'] = $new_mdp;
            
            // On redirige vers la page d'accueil si tout se passe bien
            if ($_SESSION['login'] == "admin") {
                header('Location: ../vue/admin/accueil_gestionnaire.php');
            } else {
                header('Location: ../vue/accueil.php');
            }
        } else {
            echo $errMsg;
        }
    } else {
        echo 'Veuillez remplir tous les champs du formulaire';
    }  
}










?>