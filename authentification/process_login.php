<?php
require './../classe/connexion.php';
require './../classe/utilisateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pasword'];

    $db = new Connexion();
    $utilisateur = new Utilisateur($db);
   
    
    $resultat = $utilisateur->connexion($email, $password);
    
    if($resultat == "Connexion réussie") {
        
        if($_SESSION['id_role'] == 1) { 
            header("Location: ./../admin/dashbord.php");
        } elseif ($_SESSION['id_role'] == 2){
            header("Location: ./../etudient/home.php");

        }else { 
            header("Location: ./../enseignent/home.php");
        }
        exit();
    } else {
        header("Location: login.php?error=" . urlencode($resultat));
        exit();
    }
}
?>