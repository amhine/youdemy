<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php';

$db = new Connexion();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_cours = $_POST['nom_cours'];
    $categorie_id = $_POST['categorie'];  
    $fichier = $_POST['fichier'];  
    $statut = 'Actif'; 
    $type_contenu = $_POST['type_contenu'];
    session_start();
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

    $date_creation = date("Y-m-d H:i:s");

    if ($type_contenu === 'document') {
        $cours = new CoursDocument($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier);
    } else {
        $cours = new CoursVideo($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier);
    }

    // Sauvegarder le cours
    if ($cours->save()) {
        echo "Le cours a été ajouté avec succès!";
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}
?>
