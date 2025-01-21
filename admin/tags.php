<?php
require './../classe/connexion.php';
require './../classe/tag.php';

$db = new Connexion();
$connect = $db->getConnection();

// Créer un objet Tag pour récupérer tous les tags
$tag = new Tag($db, null, null);
$tags = $tag->getTags();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tags</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body>
    <!-- Ajouter un cours -->
    <div class="flex justify-end items-center m-5">
        <a href="ajoutertag.php" class="pt-1 text-white bg-purple-600 rounded-lg w-56 h-10 text-lg font-bold hover:bg-purple-700 transition-colors inline-block text-center">
            Ajouter Tags
        </a>
        <a href="./../admin/dashbord.php ">
            <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                Retourner au dashboard
            </button>
        </a>
    </div>

    <!-- Liste des Tags -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 mt-12">
        <?php foreach ($tags as $tagItem) { ?>
           
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <p class="text-sm text-gray-600 mb-4">Tag : 
                            <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-sm">
                                #<?= $tagItem->getNomTag() ?>
                            </span>
                        </p>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="modifiertag.php?id_tag=<?= $tagItem->getIdTag() ?>">
                            <button class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                                Modifier
                            </button>
                        </a>

                        <a href="supprimertag.php?id_tag=<?= $tagItem->getIdTag() ?>">
                            <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                Supprimer
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


</body>
</html>
