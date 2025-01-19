<?php
// session_start();
// require './../classe/connexion.php';
// require './../classe/categorie.php';
// require './../classe/cours.php';
// require './../classe/tag.php';
// require './../classe/courstag.php'; // Inclure la classe pour gérer la relation many-to-many

// $db = new Connexion();
// $tag = new Tag($db, null, null); // Créer une instance de la classe Tag
// $coursTag = new CoursTag($db, null, null); // Initialiser sans ID, à associer plus tard

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $nom_cours = $_POST['nom_cours'];
//     $categorie_id = $_POST['categorie'];
//     $fichier = $_POST['fichier'];
//     $statut = 'Actif';
//     $type_contenu = $_POST['type_contenu'];
//     $description = $_POST['description'];
//     $images = $_POST['images'];if (isset($_POST['nom_tag']) && is_array($_POST['nom_tag'])) {
//         $tags = $_POST['nom_tag'];
//         $errors = [];
//     // Validation des tags
//     if (empty($tags)) {
//         $errors[] = "Veuillez entrer au moins un tag.";
//     }

//     // Validation de la catégorie
//     $query_categorie = "SELECT id_categorie FROM categorie WHERE id_categorie = :categorie_id";
//     $stmt_categorie = $db->getConnection()->prepare($query_categorie);
//     $stmt_categorie->bindParam(':categorie_id', $categorie_id);
//     $stmt_categorie->execute();
//     $categorie = $stmt_categorie->fetch(PDO::FETCH_ASSOC);

//     if (!$categorie) {
//         $errors[] = "La catégorie spécifiée n'existe pas.";
//     }

//     // Validation de l'utilisateur
//     $id_user = $_SESSION['id_user'];
//     $query_user = "SELECT id_user FROM utilisateur WHERE id_user = :id_user";
//     $stmt_user = $db->getConnection()->prepare($query_user);
//     $stmt_user->bindParam(':id_user', $id_user);
//     $stmt_user->execute();
//     $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

//     if (!$user) {
//         $errors[] = "L'utilisateur n'existe pas.";
//     }

//     // Si pas d'erreurs, on continue
//     if (empty($errors)) {
//         // Date de création
//         $date_creation = date("Y-m-d H:i:s");

//         // Création du cours
//         if ($type_contenu === 'document') {
//             $cours = new CoursDocument($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
//         } else {
//             $cours = new CoursVideo($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
//         }

//         if ($cours->save()) {
//             // Récupérer l'ID du cours nouvellement créé
//             $id_cours = $cours->getIdCours();
//             if (isset($_POST['nom_tag']) && is_array($_POST['nom_tag'])) {
//                 $tags = $_POST['nom_tag'];  // Récupérer tous les tags envoyés
//                 var_dump($tags);  // Debug: vérifier le contenu du tableau des tags
            
//                 foreach ($tags as $nom_tag) {
//                     $nom_tag = trim($nom_tag); // Supprimer les espaces inutiles autour du tag
            
//                     if (!empty($nom_tag)) {
//                         // Ajouter le tag et récupérer l'ID du tag
//                         $id_tag = $tag->addTag($nom_tag);
//                         if (!$id_tag) {
//                             $errors[] = "Erreur lors de l'ajout du tag : $nom_tag";
//                         } else {
//                             // Afficher l'ID du tag pour déboguer
//                             echo "Tag: $nom_tag - Tag ID: $id_tag<br>";
            
//                             // Associer le tag au cours dans la table courstag
//                             $coursTag->id_cours = $id_cours;
//                             $coursTag->id_tag = $id_tag;
            
//                             // Créer l'association dans la table courstag
//                             if (!$coursTag->create()) {
//                                 $errors[] = "Erreur lors de l'association du tag '$nom_tag' avec le cours.";
//                             }
//                         }
//                     } else {
//                         $errors[] = "Le tag est vide.";
//                     }
//                 }

//             } else {
//                 echo "Aucun tag validé ou les tags sont mal formatés.";
//             }
//             if (empty($errors)) {
//                 header("Location: ./../enseignent/courses.php");
//                 exit;
//             }
//         } else {
//             $errors[] = "Erreur lors de l'ajout du cours.";
//         }
//     }
//     foreach ($errors as $error) {
//         echo $error . "<br>";
//     }
// }
// }

?>
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

    // Validation des tags
    if (!isset($_POST['nom_tag']) || !is_array($_POST['nom_tag']) || empty($_POST['nom_tag'])) {
        $errors[] = "Veuillez entrer au moins un tag.";
    } else {
        $tags = $_POST['nom_tag'];
    }

    // Validation de la catégorie
    $query_categorie = "SELECT id_categorie FROM categorie WHERE id_categorie = :categorie_id";
    $stmt_categorie = $db->getConnection()->prepare($query_categorie);
    $stmt_categorie->bindParam(':categorie_id', $categorie_id);
    $stmt_categorie->execute();
    $categorie = $stmt_categorie->fetch(PDO::FETCH_ASSOC);

    if (!$categorie) {
        $errors[] = "La catégorie spécifiée n'existe pas.";
    }

    // Validation de l'utilisateur
    $id_user = $_SESSION['id_user'];
    $query_user = "SELECT id_user FROM utilisateur WHERE id_user = :id_user";
    $stmt_user = $db->getConnection()->prepare($query_user);
    $stmt_user->bindParam(':id_user', $id_user);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $errors[] = "L'utilisateur n'existe pas.";
    }

    // Si pas d'erreurs, on continue
    if (empty($errors)) {
        // Date de création
        $date_creation = date("Y-m-d H:i:s");

        // Création du cours
        if ($type_contenu === 'document') {
            $cours = new CoursDocument($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
        } else {
            $cours = new CoursVideo($db, null, $nom_cours, $date_creation, $categorie_id, $id_user, $statut, $fichier, $images, $description);
        }

        if ($cours->save()) {
            // Récupérer l'ID du cours nouvellement créé
            $id_cours = $cours->getIdCours();

            // Traitement des tags
            foreach ($tags as $nom_tag) {
                $nom_tag = trim($nom_tag); // Supprimer les espaces inutiles
                if (!empty($nom_tag)) {
                    // Ajouter le tag et récupérer l'ID du tag
                    $id_tag = $tag->addTag($nom_tag);
                    if (!$id_tag) {
                        $errors[] = "Erreur lors de l'ajout du tag : $nom_tag";
                    } else {
                        // Associer le tag au cours
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

    // Affichage des erreurs
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>

