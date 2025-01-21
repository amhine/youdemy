
<?php
session_start();
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php';
require './../classe/tag.php';
require './../classe/courstag.php';

$db = new Connexion();
$tag = new Tag($db, null, null);
$coursTag = new CoursTag($db, null, null);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_cours = $_POST['nom_cours'];
    $categorie_id = $_POST['categorie'];
    $fichier = $_POST['fichier'];
    $statut = 'Actif';
    $type_contenu = $_POST['type_contenu'];
    $description = $_POST['description'];
    $images = $_POST['images'];
    $errors = [];

    if (!isset($_POST['nom_tag']) || !is_array($_POST['nom_tag']) || empty($_POST['nom_tag'])) {
        $errors[] = "Veuillez entrer au moins un tag.";
    } else {
        $tags = $_POST['nom_tag'];
    }

    $query_categorie = "SELECT id_categorie FROM categorie WHERE id_categorie = :categorie_id";
    $stmt_categorie = $db->getConnection()->prepare($query_categorie);
    $stmt_categorie->bindParam(':categorie_id', $categorie_id);
    $stmt_categorie->execute();
    $categorie = $stmt_categorie->fetch(PDO::FETCH_ASSOC);

    if (!$categorie) {
        $errors[] = "La catégorie spécifiée n'existe pas.";
    }

    $id_user = $_SESSION['id_user'];
    $query_user = "SELECT id_user FROM utilisateur WHERE id_user = :id_user";
    $stmt_user = $db->getConnection()->prepare($query_user);
    $stmt_user->bindParam(':id_user', $id_user);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errors[] = "L'utilisateur n'existe pas.";
    }

    if (empty($errors)) {
        $date_creation = date("Y-m-d H:i:s");

        if ($type_contenu === 'document') {
            $cours = new CoursDocument($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
        } else {
            $cours = new CoursVideo($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
        }

        if ($cours->save()) {
            $id_cours = $cours->getIdCours();

            foreach ($tags as $nom_tag) {
                $nom_tag = trim($nom_tag); 
                if (!empty($nom_tag)) {
                    $id_tag = $tag->addTag($nom_tag);
                    if (!$id_tag) {
                        $errors[] = "Erreur lors de l'ajout du tag : $nom_tag";
                    } else {
                        $coursTag->id_cours = $id_cours;
                        $coursTag->id_tag = $id_tag;
                        if (!$coursTag->create()) {
                            $errors[] = "Erreur lors de l'association du tag '$nom_tag' avec le cours.";
                        }
                    }
                }
            }

            if (empty($errors)) {
                header("Location: ./../enseignent/courses.php");
                exit;
            }
        } else {
            $errors[] = "Erreur lors de l'ajout du cours.";
        }
    }

   
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>

