<?php
require './../classe/connexion.php';
require './../classe/tag.php';

$db = new Connexion();
$connect = $db->getConnection();
$tag = new Tag($db, null, null);

if (isset($_GET['id_tag']) && !empty($_GET['id_tag'])) {
    $id_tag = $_GET['id_tag'];
    $tagSupprime = false;

    $tags = $tag->getTags(); 

    foreach ($tags as $tagItem) {
        if ($tagItem->getIdTag() == $id_tag) {
            $tagItem->deletetag($id_tag); 
            $tagSupprime = true;
            break;
        }
    }


    if ($tagSupprime) {
        header('Location: tags.php'); 
        exit();
    } else {
        echo "Erreur : tag non trouvé.";
    }
} else {
    echo "Erreur : ID de tag manquant.";
}
?>
