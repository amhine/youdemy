<?php
require './../classe/connexion.php';
require './../classe/tag.php';
$connect = new Connexion();
$tag = new Tag($connect,null,null);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom_tag']) && is_array($_POST['nom_tag'])) {
        $tags = $_POST['nom_tag'];
        $errors = []; 

        foreach ($tags as $nom_tag) {
            $nom_tag = trim($nom_tag); 
            if (!empty($nom_tag)) {
                $result = $tag->addTag($nom_tag); 
                if (!$result) {
                    $errors[] = "Erreur lors de l'ajout du tag : $nom_tag";
                }
            } else {
                $errors[] = "Le tag est vide.";
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            header("Location: ./../admin/tags.php");
            exit();
        }
    } else {
        echo "Veuillez entrer des tags valides.";
    }
} else {
    echo "Méthode HTTP non autorisée.";
}
 ?>