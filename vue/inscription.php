<?php
    include_once '../modele/connexion.php';
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Inscription - Aublet</title>
    <link href="css/style_inscription.css" rel="stylesheet" type="text/css" />
    <link href="./img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <img src="./img/logo.png" alt="ablet logo" class="logo" />
    </div>
    <div class="form">
        <div class="form_block w-form">
            <div class="en_tete_form"><img src="./icons/account.png" alt="account icon" />
                <h1 class="heading">Bienvenue !</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form"
                method="post" class="inscription_form" action="inscription.php">
                <div class="input_part">
                    <div class="inputs_left">
                        <label for="prenom" class="field-label">Prénom</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="prenom" data-name="prenom" placeholder="" id="prenom" />
                        <label for="nom" class="field-label">Nom</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="nom" data-name="nom" placeholder="" id="nom" required="" />
                        <div class="field-label">Civilité</div>
                        <div class="radios_bouton">
                            <label class="radio-button-field w-radio">
                                <input type="radio" id="Monsieur" name="civilite" value="Monsieur" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                <span class="w-form-label" for="Monsieur">Monsieur</span>
                            </label>
                            <label class="w-radio">
                                <input type="radio" id="Madame" name="civilite" value="Madame" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                <span class="w-form-label" for="Madame">Madame</span>
                            </label>
                            <label class="w-radio">
                                <input type="radio" id="radio" name="civilite" value="Radio" data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                <span class="w-form-label" for="radio">Autre</span>
                            </label>
                        </div>
                    </div>
                    <div class="inputs_left">
                        <label for="mail" class="field-label">Mail</label>
                        <input type="email" class="text-field w-input" autofocus="true" maxlength="256" name="mail" data-name="mail" placeholder="" id="mail" />
                        <label for="login" class="field-label">Login</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="login" data-name="login" placeholder="" id="login" />
                        <label for="mdp-2" class="field-label">Mot de passe</label>
                        <input type="password" class="text-field w-input" autofocus="true" maxlength="256" name="mdp" data-name="mdp" placeholder="" id="mdp-2" />
                        <label for="conf_mdp-2" class="field-label">Confirmer le mot de passe</label>
                        <input type="password" class="text-field w-input" autofocus="true" maxlength="256" name="conf_mdp" data-name="conf_mdp" placeholder="" id="conf_mdp-2" />
                    </div>
                </div>
                <div class="inscrire"><a href="#" class="inscrire_bouton w-button">S'inscrire</a></div>
            </form>

            <?php
                $registerUser = 'INSERT INTO utilisateur(nom, prenom, civilite, mel, login, mdp) VALUES(:nom, :ville, :civilite, :mel, :login, :mdp)';
                $res = $db->prepare($registerUser);
                $res->bindValue('nom', trim($_POST['nom']));
                $res->bindValue('prenom', trim($_POST['prenom']));
                $res->bindValue('civilite', trim($_POST['civilite']));
                $res->bindValue('mel', trim($_POST['mel']));
                $res->bindValue('login', trim($_POST['login']));
                $res->bindValue('mdp', trim($_POST['mdp']));
                $res->execute();
            ?>



        </div>
        <div class="creer_compte">
            <div class="text-block">Déjà membre ?</div><a href="connexion.html" class="se_connecter_bouton w-button">Se
                connecter</a>
        </div>
    </div>
</body>

</html>