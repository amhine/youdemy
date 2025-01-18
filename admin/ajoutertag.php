<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des Tags</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen m-0">
    <div class="container">
        <form action="./../script.php/scripttag.php" method="POST" id="add" onsubmit="return validateForm()">
            <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg">
                <div class="px-8 py-4 bg-blue-400 text-white">
                    <h1 class="flex justify-center font-bold text-white text-3xl">Ajouter des Tags</h1>
                </div>
                <div class="px-8 py-6">
                    <!-- Container pour les champs tags -->
                    <div id="tags-container">
                        <input class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" name="nom_tag[]" type="text" placeholder="Entrez un tag" required>
                    </div>

                    <!-- Bouton pour ajouter un autre tag -->
                    <div class="mt-4">
                        <button type="button" onclick="ajouterTag()" class="text-white bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-800">
                            Ajouter un autre tag
                        </button>
                    </div>

                    <div class="flex justify-between mt-8">
                        <a href="dashbord.php" class="text-white bg-red-600 w-40 rounded-lg py-3 hover:bg-red-800 cursor-pointer flex justify-center">
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
</body>
<script>
        // Fonction pour ajouter un nouvel input tag
        function ajouterTag() {
            var container = document.getElementById("tags-container");
            var newInput = document.createElement("input");
            newInput.type = "text";
            newInput.name = "nom_tag[]";  // Le tableau pour récupérer tous les tags
            newInput.placeholder = "Entrez un tag";
            newInput.classList.add("appearance-none", "border", "border-gray-400", "rounded-lg", "w-full", "py-3", "px-4", "text-gray-700", "leading-tight", "focus:outline-none", "focus:ring-2", "focus:ring-blue-400", "focus:border-transparent", "mt-3");
            container.appendChild(newInput);
        }

        // Fonction de validation avant l'envoi du formulaire
        function validateForm() {
            var inputs = document.querySelectorAll("input[name='nom_tag[]']");
            var isValid = true;
            
            // Vérifier si tous les champs de tags sont remplis
            inputs.forEach(function(input) {
                if (input.value.trim() === "") {
                    input.classList.add("border-red-500");  // Ajouter une bordure rouge pour indiquer l'erreur
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
</html>
