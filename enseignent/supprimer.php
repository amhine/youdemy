<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php'; 
require './../classe/tag.php';

$db = new Connexion();
$connect = $db->getConnection();

// Initialisation des objets CoursDocument et CoursVideo
$coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null); 
$coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);

// Récupérer tous les cours (document + vidéo)
$cours = array_merge($coursDocument->getCours(), $coursVideo->getCours());

if (isset($_GET['id_cours']) && !empty($_GET['id_cours'])) {
    $id_cours = $_GET['id_cours'];
    $coursSupprime = false;

    // Vérifier chaque cours pour trouver l'id correspondant et appeler deletecours
    foreach ($cours as $coursItem) {
        if ($coursItem->getIdCours() == $id_cours) {
            $coursItem->deletecours($id_cours); // Appeler la méthode deletecours() de l'objet correspondant
            $coursSupprime = true;
            break;
        }
    }

    if ($coursSupprime) {
        header('Location: courses.php'); 
        exit();
    } else {
        echo "Erreur : Cours non trouvé.";
    }
} else {
    echo "Erreur : ID de cours manquant.";
}
?>
