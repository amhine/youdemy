<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php';
require './../classe/tag.php';

$db = new Connexion();
$conn = $db->getConnection();

$categorieObj = new Categorie();
$categories = $categorieObj->getCategories();
$tagObj = new Tag($conn, null);
$coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null);
$coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cours = $_POST['id_cours'] ?? null;
    $nom_cours = $_POST['nom_cours'] ?? '';
    $images = $_POST['images'] ?? '';
    $description = $_POST['description'] ?? '';
    $type_contenu = $_POST['type_contenu'] ?? '';
    $categorie = $_POST['categorie'] ?? null;
    $fichier = $_POST['fichier'] ?? '';
    $tags = $_POST['nom_tag'] ?? [];

    if ($id_cours) {
        $cours = ($type_contenu == 'document') ? $coursDocument : $coursVideo;

        $cours->setIdCours($id_cours);
        $cours->setNom($nom_cours);
        $cours->setimage($images);
        $cours->setDescription($description);
        $cours->setcontenu($type_contenu);
        $cours->setCategorie($categorie);
        $cours->setFichier($fichier);

        if ($cours->modifier()) {
            if (!empty($tags)) {
                if ($cours->updateTags($id_cours, $tags)) {
                    header("Location: ./../admin/courses.php?success=1");
                    exit();
                }
            } else {
                header("Location: ./../admin/courses.php?success=1");
                exit();
            }
        }
        header("Location: ./../admin/courses.php?error=1");
        exit();
    }
    
    header("Location: ./../admin/courses.php?error=2");
    exit();
}
?>