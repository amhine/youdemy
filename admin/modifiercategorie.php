<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

if (isset($_GET['id_categorie'])) {
    $id_categorie = $_GET['id_categorie'];

    // Créer l'instance de la classe Categorie et récupérer la catégorie à modifier
    $db = new Connexion();
    $categorie = new Categorie();
    $categories = $categorie->getCategories();

    // Trouver la catégorie correspondante par ID
    foreach ($categories as $cat) {
        if ($cat->getIdCategorie() == $id_categorie) {
            $nom_categorie = $cat->getNom();
            $description = $cat->getDescription();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la catégorie</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen m-0">
<div class="container">
    <form action="./../script.php/scriptmodificationcateadmin.php" method="POST" id="modifyCourseForm">
        <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg overflow-y-scroll">
            <div class="px-8 py-4 bg-blue-400 text-white">
                <h1 class="flex justify-center font-bold text-white text-3xl">Modifier la catégorie</h1>
            </div>
            <div class="px-8 py-6">
                
        <input type="hidden" name="id_categorie" value="<?php echo $id_categorie; ?>" />
                <!-- Nom -->
                <div>
                    <label for="nom_categorie" class="block text-gray-700 font-semibold mb-2">Nom :</label>
                    <input type="text" id="nom_categorie" name="nom_categorie" value="<?php echo $nom_categorie; ?>" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>
                
                

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Description :</label>
                    <input type="text" id="description" name="description" value="<?= $description ?>" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>

               

                <!-- ID du Cours -->
                <input type="hidden" name="id_categorie" value="<?= $id_categorie; ?>" />

                <!-- Submit -->
                <button type="submit" class="text-white bg-blue-600 w-40 rounded-lg py-3 hover:bg-blue-800 cursor-pointer mt-6">Modifier</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
