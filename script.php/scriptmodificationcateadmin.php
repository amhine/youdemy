<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $id_categorie = isset($_POST['id_categorie']) ? (int)$_POST['id_categorie'] : null;
    $nom_categorie = isset($_POST['nom_categorie']) ? trim($_POST['nom_categorie']) : null;
    $description = isset($_POST['description']) ? trim($_POST['description']) : null;

    // Validation des données
    if ($id_categorie && $nom_categorie && $description) {
        $db = new Connexion();
        $categorie = new Categorie($db);

        // Mise à jour de la catégorie
        $resultat = $categorie->updateCategorie($id_categorie, $nom_categorie, $description);

        if ($resultat === "Catégorie modifiée avec succès.") {
            header("Location: ./../admin/categorie.php?success=1");
            exit();
        } else {
            header("Location: ./../admin/categorie.php?id_categorie=$id_categorie&error=1");
            exit();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Accès invalide.";
}
?>