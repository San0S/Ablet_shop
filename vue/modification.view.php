<?php
require '../modele/connexion.php';

session_start();

?>


<html>

<head>
    <meta charset="utf-8" />
    <title>Modification - Aublet</title>
    <link href="../vue/css/style_modification.css" rel="stylesheet" type="text/css" />
    <link href="../vue/img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu"><img src="./img/logo.png" alt="ablet logo" class="logo" />
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
    <div class="form">
        <div class="modification_form_block w-form">
            <div class="en_tete_form">
                <img src="../vue/icons/account.png" alt="account icon" />
                <h1 class="heading">Vos informations</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="modification_form">
                <div class="input_part">
                    <div class="inputs_side">
                        <label for="prenom" class="field-label">Prénom</label>
                        <input type="text" value="<?php echo $_SESSION['prenom']?>" class="text-field w-input" autofocus="true" maxlength="256" name="prenom" data-name="prenom" placeholder="" id="prenom" />
                        <label for="nom" class="field-label">Mail</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="nom" data-name="nom" value=<?php echo $_SESSION['mel'] ?> id="nom" />
                    </div>
                    <div class="inputs_side">
                        <label for="old_mdp" class="field-label">Ancien mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="old_mdp" data-name="old_mdp" placeholder="" id="old_mdp" />
                        <label for="new_mdp" class="field-label">Nouveau mot de passe</label>
                        <input type="password" class="text-field w-input" maxlength="256" name="new_mdp" data-name="new_mdp" placeholder="" id="new_mdp" />
                    </div>
                </div>
                <div class="civilite_input">
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
                <div class="modifier"><a href="../vue/accueil.php" class="modifier_bouton w-button" target="_blank">
                        Modifier</a></div>
            </form>
        </div>
    </div>
</body>

</html>