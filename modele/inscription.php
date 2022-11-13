<?php
    require_once '../modele/db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Inscription - Aublet</title>
    <link href="../vue/css/style_inscription.css" rel="stylesheet" type="text/css" />
    <link href="../vue/img/logo_img.png" rel="shortcut icon" type="image/x-icon" />
</head>

<body class="body">
    <div class="menu">
        <img src="../vue/img/logo.png" alt="ablet logo" class="logo" />
    </div>
    <div class="form">
        <div class="form_block w-form">
            <div class="en_tete_form"><img src="../vue/icons/account.png" alt="account icon" />
                <h1 class="heading">Bienvenue !</h1>
            </div>
            <form id="wf-form-inscription-form" name="wf-form-inscription-form" data-name="inscription form" method="post" class="inscription_form">
                <div class="input_part">
                    <div class="inputs_left">
                        <label for="prenom" class="field-label">Prénom</label>
                        <input type="text" class="text-field w-input" autofocus="true" maxlength="256" name="prenom" data-name="prenom" placeholder="" id="prenom" />
                        <label for="nom" class="field-label">Nom</label>
                        <input type="text" class="text-field w-input" maxlength="256" name="nom" data-name="nom" placeholder="" id="nom" required="" />
                        <div class="field-label">Civilité</div>
                        <div class="radios_bouton">
                            <label class="radio-button-field w-radio">
                                <input type="radio" id="Monsieur" name="radio" value="M." data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                <span class="w-form-label" for="Monsieur">Monsieur</span>
                            </label>
                            <label class="w-radio">
                                <input type="radio" id="Madame" name="radio" value="Mme." data-name="Radio" class="w-form-formradioinput w-radio-input" />
                                <span class="w-form-label" for="Madame">Madame</span>
                            </label>
                            <label class="w-radio">
                                <input type="radio" id="Autre" name="radio" value="Mx." data-name="Radio" class="w-form-formradioinput w-radio-input" />
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
                <div class="inscrire"><button type="submit" class="inscrire_bouton w-button">S'inscrire</button></div>
            </form>

            <?php
                session_start(); 
                $idSes = session_id();

                // Fct de vérification des infos 
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

                // (vérifie le format de l'email avec les caractères spéciaux, présence du @ etc)
                function verifFormatMail($mail): bool {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                function loginExiste($login): int {
                    global $db;
                    $query = $db->prepare('SELECT * FROM utilisateur WHERE login = :login');
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

                function verifMdp($mdp, $conf_mdp): bool {
                    if ($mdp == $conf_mdp) {
                        return true;
                    } else {
                        return false;
                    }
                }

                // Vérification si tous les champs du formulaire sont bien remplis
                if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['conf_mdp']) && isset($_POST['radio'])) {

                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $mail = $_POST['mail'];
                    $login = $_POST['login'];
                    $mdp = $_POST['mdp'];
                    $conf_mdp = $_POST['conf_mdp'];
                    $civilite = $_POST['radio'];


                    if (mailExiste($mail)) {
                        $errMsg = "Le mail existe déjà";
                    }
                    if (!verifFormatMail($mail)) {
                        $errMsg = "Le mail n'est pas valide";
                    }
                    if (loginExiste($login)) {
                        $errMsg = "Le login existe déjà";
                    }
                    if (!verifMdp($mdp, $conf_mdp)) {
                        $errMsg = "Les mots de passe ne correspondent pas";
                    }

                    // Si tout est bon, on prépare la requête d'insertion
                    if (!mailExiste($mail) && verifFormatMail($mail) && !loginExiste($login) && verifMdp($mdp, $conf_mdp)) {

                    $query = $db->prepare(' INSERT INTO utilisateur(nom, prenom, civilite, mel, login, mdp) 
                                            VALUES(:nom, :prenom, :civilite, :mail, :login, :mdp)');
                    
                    $query->execute(array(
                        'nom' => strtoupper($nom),
                        'prenom' => $prenom,
                        'civilite' => $civilite,
                        'mail' => $mail,
                        'login' => $login,
                        'mdp' => $mdp
                    ));

                    $_SESSION['sid'] = $idSes;
                    $_SESSION['nom'] = strtoupper($nom);
                    $_SESSION['prenom'] = $prenom;
                    $_SESSION['civilite'] = $civilite;
                    $_SESSION['mel'] = $mail;
                    $_SESSION['login'] = $login;
                    $_SESSION['mdp'] = $mdp;

                    // Si tout s'est bien passé, on exécute la requête et on redirige vers la page d'accueil
                    header('Location: ../vue/accueil.php');
                    } else {
                        echo $errMsg;
                    }
                } else {
                    echo "Veuillez remplir tous les champs du formulaire";
                }
            ?>

        </div>
        <div class="creer_compte">
            <div class="text-block">Déjà membre ?</div>
            <a href="../vue/connexion.php" class="se_connecter_bouton w-button">Se connecter</a>
        </div>
    </div>
</body>

</html>