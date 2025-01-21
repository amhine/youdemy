<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

$db = new Connexion();
$categorie = new Categorie(); 
$categories = $categorie->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body>
<div class="bg-gray-100 flex justify-center items-center min-h-screen m-0 ">
    <form action="./../script.php/scriptadmin_cours.php" method="POST" id="addCategoryForm">
        <div class="max-w-[900px] w-full bg-white rounded-lg shadow-lg overflow-y-scroll ">
            <div class="px-8 py-4 bg-blue-400 text-white">
                <h1 class="flex justify-center font-bold text-white text-3xl">Cours</h1>
            </div>
            <div class="px-8 py-6">
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="nom_cours">Nom :</label>
                    <input type="text" id="nom_cours" name="nom_cours" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="images">URL Images :</label>
                    <input type="text" id="images" name="images" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="description">Description:</label>
                    <input type="text" id="description" name="description" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="type_contenu">Type de cours :</label>
                    <select id="type_contenu" name="type_contenu" class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="0">Choisir le type de cours</option>    
                        <option value="document">Document</option>
                        <option value="video">Vidéo</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="categorie">Les catégories :</label>
                    <select id="categorie" name="categorie" required class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="0">Choisir la catégorie</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie->getIdCategorie(); ?>">
                                <?php echo $categorie->getNom(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="fichier">URL vidéo ou document :</label>
                    <input type="text" id="fichier" name="fichier" class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
                </div>
                <div class="mb-6">
                <div id="tags-container">
                        <label class="block text-gray-700 font-semibold mb-2" for="nom_tag[]">Tags :</label>
                        <input type="text" id="nom_tag" name="nom_tag[]" placeholder="Entrez un tag"  class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"  required>
                </div>
                    <button type="button" onclick="ajouterTag()" class="text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-800 mt-4">
                        Ajouter un autre tag
                    </button>
                    </div>
                <div class="flex justify-between mt-8">
                    <a href="courses.php" class="text-white bg-red-600 w-40 rounded-lg py-3 hover:bg-red-800 cursor-pointer flex justify-center">
                        Annuler
                    </a>
                    <button type="submit" class="text-white bg-blue-600 w-40 rounded-lg py-3 hover:bg-blue-800 cursor-pointer">
                        Ajouter
                    </button>
                </div>
            </div>
        </div>
        
    </form>
    
</div>
<script>
      function ajouterTag() {
    var container = document.getElementById("tags-container");
    var newInput = document.createElement("input");
    newInput.type = "text";
    newInput.name = "nom_tag[]";  
    newInput.placeholder = "Entrez un tag";
    newInput.classList.add("appearance-none", "border", "border-gray-400", "rounded-lg", "w-full", "py-3", "px-4", "text-gray-700", "leading-tight", "focus:outline-none", "focus:ring-2", "focus:ring-blue-400", "focus:border-transparent", "mt-3");
    container.appendChild(newInput);
}


        function validateForm() {
            var inputs = document.querySelectorAll("input[name='nom_tag[]']");
            var isValid = true;
            
            
            inputs.forEach(function(input) {
                if (input.value.trim() === "") {
                    input.classList.add("border-red-500");  
                    isValid = false;
                } else {
                    input.classList.remove("border-red-500");
                }
            });

            if (!isValid) {
                alert("Veuillez remplir tous les champs de tags.");
            }

            return isValid;
        }
</script>
</body>

</html>