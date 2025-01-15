<?php
require './../classe/connexion.php';
require './../classe/utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pasword'];

    $db = new Database();
    $utilisateur = new Utilisateur($db);
    
    $resultat = $utilisateur->connexion($email, $password);
    
    if($resultat == "Connexion réussie") {
        
        if($_SESSION['id_role'] == 1) { 
            header("Location: dashbord.php");
        } else { 
            header("Location: index.php");
        }
        exit();
    } else {
        header("Location: login.php?error=" . urlencode($resultat));
        exit();
    }
}
?>