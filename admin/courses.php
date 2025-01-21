<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php'; 
require './../classe/tag.php';

$db = new Connexion();
$connect = $db->getConnection();

$categorieObj = new Categorie();
$categories = $categorieObj->getCategories();

$coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null); 
$coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);
$cours = array_merge($coursDocument->getCours(), $coursVideo->getCours());



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body>
    <!-- Ajouter un cours -->
    <div class="flex justify-end items-center m-5">
        <a href="ajoutercours.php" class="pt-1 text-white bg-purple-600 rounded-lg w-56 h-10 text-lg font-bold hover:bg-purple-700 transition-colors inline-block text-center">
            Ajouter Cours
        </a>
    </div>

   
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 mt-12">
    <?php 
    $affiches = [];

    foreach ($cours as $coursItem): 

            if (!in_array($coursItem->getIdCours(), $affiches)):
                $affiches[] = $coursItem->getIdCours();
    ?>
        <!-- Nouvelle carte de cours -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
            <div class="relative">
                <!-- Image du cours -->
                <img src="<?= $coursItem->getimage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover">
                <!-- Catégorie en badge -->
                <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm">
                    <?php echo $coursItem->getCategorie() ? $coursItem->getCategorie()['nom_categorie'] : 'No Category'; ?>
                </div>
            </div>
            <div class="p-6">
                <!-- Nom du cours -->
                <h3 class="text-xl font-semibold mb-2 text-gray-800"><?php echo $coursItem->getNom(); ?></h3>
                <!-- Description du cours -->
                <p class="text-gray-600 mb-4"><?php echo $coursItem->getdescription(); ?> .</p>
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php
                    $tag=new Tag($db, null, null);
                    $tags = $tag->getTagsByCours($coursItem->getIdCours());
                     ?>
                <p class="text-sm text-gray-600 mb-4">Tags : 
                            <?php 
                            
                            foreach ($tags as $tag) { ?>
                                <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-sm">#<?= $tag->getNomTag() ?></span>

                            <?php } ?>
                </p>
                        </div>

                <div class="flex justify-between items-center">
                    <!-- Lien vers la page du cours -->
                    <a href="modifiercours.php?id_cours=<?php echo $coursItem->getIdCours(); ?>">
                        <button class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                            Modifier
                        </button>
                    </a>
                   

                    <!-- Bouton d'inscription -->
                    <a href="supprimer.php?id_cours=<?= $coursItem->getIdCours() ?>">
                        <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                            Supprimer
                        </button>
                    </a>
                </div>
            </div>
        </div>
    <?php 
            endif;
    endforeach; 
    ?>
</div>



  
    <!-- Script for toggling mobile menu -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
    
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>