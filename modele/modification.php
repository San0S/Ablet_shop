<?php
require 'connexion.php';
require '../vue/modification.view.php';

session_start();

if (isset($_POST['prenom']) && isset($_POST['radio']) && isset($_POST['old_mdp']) && isset($_POST['new_mdp']) && isset($_POST['mail'])) {
    $prenom = $_POST['prenom'];
    $civilite = $_POST['radio'];
    $old_mdp = $_POST['old_mdp'];
    $new_mdp = $_POST['new_mdp'];
    $mail = $_POST['mail'];







}






?>