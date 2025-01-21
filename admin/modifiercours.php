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

$id_cours = isset($_GET['id_cours']) ? (int)$_GET['id_cours'] : null;

if ($id_cours) {
    $coursDocumentDetails = $coursDocument->getCoursById($conn, $id_cours);
    $coursVideoDetails = $coursVideo->getCoursById($conn, $id_cours);
    
    if ($coursDocumentDetails) {
        $cours_data = $coursDocumentDetails;
    } elseif ($coursVideoDetails) {
        $cours_data = $coursVideoDetails;
    } else {
        $cours_data = null;
    }
} else {
    echo "ID du cours manquant.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Cours</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen m-0">
<div class="container">
    <form action="./../script.php/scriptmodificationcoursadmin.php" method="POST" id="modifyCourseForm">
        <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg overflow-y-scroll">
            <div class="px-8 py-4 bg-blue-400 text-white">
                <h1 class="flex justify-center font-bold text-white text-3xl">Modifier le Cours</h1>
            </div>
            <div class="px-8 py-6">
                <!-- Nom -->
                <div>
                    <label for="nom_cours" class="block text-gray-700 font-semibold mb-2">Nom :</label>
                    <input type="text" id="nom_cours" name="nom_cours" value="<?= $cours_data->getNom(); ?>" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>
                
                <!-- Image -->
                <div>
                    <label for="images" class="block text-gray-700 font-semibold mb-2">URL Image :</label>
                    <input type="text" id="images" name="images" value="<?= $cours_data->getImage(); ?>" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Description :</label>
                    <input type="text" id="description" name="description" value="<?= $cours_data->getDescription(); ?>" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>

                <!-- Type de contenu -->
                <div>
                    <label for="type_contenu" class="block text-gray-700 font-semibold mb-2">Type de contenu :</label>
                    <select id="type_contenu" name="type_contenu" required>
                        <option value="document" <?php echo ($cours_data->getContenu() == 'document') ? 'selected' : ''; ?>>Document</option>
                        <option value="video" <?php echo ($cours_data->getContenu() == 'video') ? 'selected' : ''; ?>>Vidéo</option>
                    </select>
                </div>

                <!-- Catégorie -->
                <div>
                    <label for="categorie" class="block text-gray-700 font-semibold mb-2">Catégorie :</label>
                    <select id="categorie" name="categorie" required>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie->getIdCategorie(); ?>" 
                                    <?php echo ($cours_data->getCategorie() == $categorie->getIdCategorie()) ? 'selected' : ''; ?>>
                                <?= $categorie->getNom(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fichier -->
                <div>
                    <label for="fichier" class="block text-gray-700 font-semibold mb-2">URL Vidéo ou Document :</label>
                    <input type="text" id="fichier" name="fichier" value="<?= $cours_data->getFichier(); ?>" required>
                </div>

                <!-- Tags -->
                <div>
                    <label for="nom_tag[]" class="block text-gray-700 font-semibold mb-2">Tags :</label>
                    <?php
                    $tags = $tagObj->getTagsByCours($cours_data->getIdCours()); 
                    foreach ($tags as $tag) {
                        echo '<input type="text" name="nom_tag[]" value="' . $tag->getNomTag() . '" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>';
                    }
                    ?>
                </div>

                <!-- ID du Cours -->
                <input type="hidden" name="id_cours" value="<?= $cours_data->getIdCours(); ?>" />

                <!-- Submit -->
                <button type="submit" class="text-white bg-blue-600 w-40 rounded-lg py-3 hover:bg-blue-800 cursor-pointer mt-6">Modifier</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
