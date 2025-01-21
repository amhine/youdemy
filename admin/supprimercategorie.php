<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

$db = new Connexion();
$connect = $db->getConnection();
$categorie = new Categorie($db, null, null,null);

if (isset($_POST['id_categorie']) && !empty($_POST['id_categorie'])) {
    $id_categorie = $_POST['id_categorie'];
    $categorieSupprime = false;

    $categories = $categorie->getCategories(); 

    foreach ($categories as $categorieItem) {
        if ($categorieItem->getIdCategorie() == $id_categorie) {
            $categorieItem->supprimerCategorie($id_categorie); 
            $categorieSupprime = true;
            break;
        }
    }


    if ($categorieSupprime) {
        header('Location: categorie.php'); 
        exit();
    } else {
        echo "Erreur : categorie non trouvé.";
    }
} else {
    echo "Erreur : ID de categorie manquant.";
}
?>
