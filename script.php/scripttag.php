<?php
require './../classe/connexion.php';
require './../classe/tag.php';
$connect = new Connexion();
$tag = new Tag($connect,null,null);

// Vérification de la méthode HTTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification que 'nom_tag' est défini et est un tableau
    if (isset($_POST['nom_tag']) && is_array($_POST['nom_tag'])) {
        $tags = $_POST['nom_tag'];
        $errors = []; // Tableau pour stocker les erreurs

        // Boucle sur chaque tag
        foreach ($tags as $nom_tag) {
            $nom_tag = trim($nom_tag); // Suppression des espaces inutiles

            // Validation du tag
            if (!empty($nom_tag)) {
                // Ajout du tag en base de données
                $result = $tag->addTag($nom_tag); // Utilisation de la méthode addTag (camelCase)
                if (!$result) {
                    $errors[] = "Erreur lors de l'ajout du tag : $nom_tag";
                }
            } else {
                $errors[] = "Le tag est vide.";
            }
        }

        // Gestion des erreurs
        if (!empty($errors)) {
            // Affichage des erreurs
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            // Redirection en cas de succès
            header("Location: dashbord.php");
            exit();
        }
    } else {
        echo "Veuillez entrer des tags valides.";
    }
} else {
    echo "Méthode HTTP non autorisée.";
}
 ?>