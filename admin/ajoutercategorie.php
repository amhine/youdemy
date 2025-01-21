

<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body>
    <div class="container">
        <!-- Formulaire pour ajouter une catégorie -->
        <form action="./../script.php/script_ajoutcategorie.php" method="POST" id="addCategoryForm">
            <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg">
                <div class="px-8 py-4 bg-blue-400 text-white">
                    <h1 class="flex justify-center font-bold text-white text-3xl">Categorier</h1>
                </div>
                <div class="px-8 py-6">
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2" for="nom_categorie">Nom :</label>
                        <input class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" id="nom_categorie" name="nom_categorie" type="text" placeholder="Nom" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2" for="description">Description :</label>
                        <input class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" id="description" name="description" type="text" placeholder="Description" required>
                    </div>
                    <div class="flex justify-between mt-8">
                        <a href="dashbord.php" class="text-white bg-red-600 w-40 rounded-lg py-3 hover:bg-red-800 cursor-pointer flex justify-center">
                            Cancel
                        </a>
                        <button type="submit" class="text-white bg-blue-600 w-40 rounded-lg py-3 hover:bg-blue-800 cursor-pointer">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
