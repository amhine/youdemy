<?php
session_start(); 


require './../classe/connexion.php';
require './../classe/categorie.php';
require  './../classe/cours.php';
$db = new Connexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_cours = ($_POST['nom_cours']);
    $categorie_id = ($_POST['categorie']);  
    $fichier = ($_POST['fichier']);  
    $statut = 'Actif'; 
    $type_contenu = ($_POST['type_contenu']);
    $description = ($_POST['description']);
    $images = ($_POST['images']);

    if (!isset($_SESSION['id_user'])) {
        echo "Utilisateur non connecté.";
        exit;
    }
    $id_user = $_SESSION['id_user'];
    $query_user = "SELECT id_user FROM utilisateur WHERE id_user = :id_user";
    $stmt_user = $db->getConnection()->prepare($query_user);
    $stmt_user->bindParam(':id_user', $id_user);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "L'utilisateur n'existe pas.";
        exit;  
    }
    $query_categorie = "SELECT id_categorie FROM categorie WHERE id_categorie = :categorie_id";
    $stmt_categorie = $db->getConnection()->prepare($query_categorie);
    $stmt_categorie->bindParam(':categorie_id', $categorie_id);
    $stmt_categorie->execute();
    $categorie = $stmt_categorie->fetch(PDO::FETCH_ASSOC);

    if (!$categorie) {
        echo "La catégorie spécifiée n'existe pas.";
        exit; 
    }

    // Date de création
    $date_creation = date("Y-m-d H:i:s");
    if ($type_contenu === 'document') {
        $cours = new CoursDocument($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
    } else {
        $cours = new CoursVideo($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
    }
    if ($cours->save()) {
        header("Location: ./../enseignent/courses.php");
        exit; 
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}

$categorie = new Categorie(); 
$categories = $categorie->getCategories();
?>