<?php
    include_once '../modele/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Connexion - Aublet</title>
    <link href="./css/style_connexion.css" rel="stylesheet" type="text/css" />
    <link href="./img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="logo_part">
        <img src="./img/logo&slogan.png" alt="Logo et slogan" class="logo_main" />
    </div>
    <div class="form_part">
        <div class="form_block w-form">
            <div class="en_tete_form">
                <img src="./icons/register.png" alt="" class="image-3" />
                <h1 class="heading">Content de vous revoir :)</h1>
            </div>
            <form id="formulaire_connexion" name="wf-form-Connexion-form" data-name="Connexion form" method="post"
                    class="connexion_form">
                <label for="login">Login</label>
                <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="login" 
                    data-name="login" placeholder="" id="login" required="Veuillez renseigner votre identifiant"/>
                <label for="mdp">Mot de passe</label>
                <input type="password" class="text-field w-input" maxlength="256" name="mdp" data-name="mdp"
                    placeholder="" id="mdp" required="Veuillez renseigner votre mot de passe" />
                <div class="sous_input">
                    <label class="w-checkbox checkbox-field">
                        <input type="checkbox" id="checkbox" name="checkbox" data-name="Checkbox"
                            class="w-checkbox-input" />
                        <span class="checkbox-label w-form-label" for="checkbox">Rester connecté</span>
                    </label>
                    <a href="#" class="mdp_oublie">Mot de passe oublié ?</a>
                </div>
                <div class="connecter">
                    <button type="submit" class="connecter_bouton w-button">Se connecter</button>
                </div>
            </form>


            <?php
                function redirect_to($location){
                    header('Location:'.$location);
                }


                if (isset($_POST['login']) && isset($_POST['mdp'])) {
                    $requete = 'SELECT * FROM utilisateur';
                    $users = $db->prepare($requete);
                    $users->execute();
                    $loggedUser = False;

                    foreach ($users as $user) {
                        if ($user['login'] === $_POST['login'] && $user['mdp'] === $_POST['mdp']) {
                            
                            
                            $loggedUser = True;
                            session_start();
                            $_SESSION['sid'] = session_id();
                            $_SESSION['idutilisateur'] = $user['idutilisateur'];
                            $_SESSION['nom'] = $user['nom'];
                            $_SESSION['prenom'] = $user['prenom'];
                            $_SESSION['civilite'] = $user['civilite'];
                            $_SESSION['mel'] = $user['mel'];
                            

                        } else if ($user['login'] === $_POST['login'] && $user['mdp'] != $_POST['mdp']) {
                            $errorMessage = "Erreur, mot de passe incorrect";
                        }
                    }

                    if ($loggedUser) {
                        redirect_to('./accueil.php');
                    } elseif (isset($errorMessage)) {
                        echo $errorMessage;
                    }else {
                        echo "Erreur, les identifiants renseignés ne permettent pas de vous identifier";
                    }
                }
            ?>


        </div>
        <div class="creer_compte">
            <div class="text-block">Première visite ?</div>
            <a href="../modele/inscription.php" class="creer_compte_bouton w-button">Créer un compte</a>
        </div>
    </div>
</body>

</html>