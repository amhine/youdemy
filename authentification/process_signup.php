<?php

require './../classe/connexion.php';
require './../classe/utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom_user'];
    $email = $_POST['email'];
    $password = $_POST['pasword'];
    $role = $_POST['role'];
    
    $utilisateur = new Utilisateur();
    
    $status = ($role === 'Enseignant') ? 'inactif' : 'actif';
    
    $result = $utilisateur->signup($nom, $email, $password, $role, $status);
    
    if ($result === "Inscription réussie") {
        if ($role === 'Enseignant') {
            header('Location: attendre.php');
            exit();
        } else {
            header('Location: login.php');
            exit();
        }
    } else {
        header('Location: signup.php?error=' . urlencode($result));
        exit();
    }
}
?>