<?php
include './../classe/connexion.php';
require './../classe/categorie.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom_categorie']) && isset($_POST['description'])) {
        $nom_categorie = trim($_POST['nom_categorie']); 
        $description = trim($_POST['description']);

    
        if (!empty($nom_categorie) && !empty($description)) {
            $db = new Connexion();
            $categorie = new Categorie($db);

            $resultat = $categorie->ajouterCategorie($nom_categorie, $description);

            if ($resultat === "Catégorie ajoutée avec succès") {
                header('Location:  ./../admin/categorie.php?success=1');
                exit();
            
        } else {
            header('Location: ./../admin/categorie.php?error=missing_data');
            exit();
        }
    } else {
        header('Location:  ./../admin/categorie.php');
        exit();
    }
}
}
?>