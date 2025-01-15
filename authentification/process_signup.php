<?php

require './../classe/connexion.php';
require './../classe/utilisateur.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom_user'];
    $email = $_POST['email'];
    $password = $_POST['pasword'];
    $role=$_POST['role'];
    if ($role == "0") {
        header("Location: signup.php?error=" . urlencode("Veuillez sélectionner un rôle."));
        exit;
    }
    $db = new Connexion();
    $utilisateur = new Utilisateur($db);
    $resultat = $utilisateur->signup($nom, $email, $password, $role);

    if($resultat == "Inscription réussie") {
        header("Location: login.php?success=1");
    } else {
        header("Location: signup.php?error=" . urlencode($resultat));
    }
}
?>