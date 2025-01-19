<?php
    require './../classe/connexion.php';
    require './../classe/categorie.php';
    require './../classe/cours.php';
    require './../classe/tag.php';

    $db = new Connexion();
    $connect = $db->getConnection();

    $categorie = new Categorie("", "");
    $categories = $categorie->getCategories();
    $coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null);
    $coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);

    if (isset($_GET['id_categorie'])) {
        $id_categorie = intval($_GET['id_categorie']); 
        $coursDocument = $coursDocument->getCoursByCategorie($id_categorie);
        $coursVideo = $coursVideo->getCoursByCategorie($id_categorie);

        $cours = [];
        $coursIds = [];

        foreach ($coursDocument as $cour) {
            if (!isset($coursIds[$cour->getIdCours()])) { 
                $cours[] = $cour;
                $coursIds[$cour->getIdCours()] = true;
            }
        }

        foreach ($coursVideo as $cour) {
            if (!isset($coursIds[$cour->getIdCours()])) { 
                $cours[] = $cour;
                $coursIds[$cour->getIdCours()] = true;
            }
        }
    }  
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

<div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
    <div class="mt-4 text-center mb-6 text-xl font-bold">
        <a href="./../visiteur/categorie.php" class="text-blue-500 font-semibold hover:underline">Retour aux catégories</a>
    </div>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
    if (!empty($cours)) {
        $categoriesAssoc = [];
        foreach ($categories as $cat) {
            $categoriesAssoc[$cat->getIdCategorie()] = $cat->getNom(); 
        }

        foreach ($cours as $cour):
            if ($cour->getstatus() === 'Actif'): 
                $categorieCour = $cour->getCategorie();
                $idCategorieCour = is_array($categorieCour) ? $categorieCour['id_categorie'] : $categorieCour->getIdCategorie();
                $nomCategorieCour = $categoriesAssoc[$idCategorieCour] ?? 'Catégorie inconnue';
    ?>
                <!-- Carte de cours -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative">
                        <!-- Image du cours -->
                        <img src="<?= $cour->getimage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover">
                        <!-- Catégorie en badge -->
                        <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm">
                            <?php echo $nomCategorieCour; ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Nom du cours -->
                        <h3 class="text-xl font-semibold mb-2 text-gray-800"><?php echo $cour->getNom(); ?></h3>
                        <!-- Description du cours -->
                        <p class="text-gray-600 mb-4"><?php echo $cour->getdescription(); ?></p>
                        <!--tags-->
                        <div class="flex flex-wrap gap-2 mb-4">
                    <?php
                    $tag=new Tag($db, null, null);
                    $tags = $tag->getTagsByCours($cour->getIdCours());
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
                            <a href="cours_voir.php?id_cours=<?php echo $cour->getIdCours(); ?>">
                                <button class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                                    Read More
                                </button>
                            </a>

                            <!-- Bouton d'inscription -->
                            <a href="../Controller/inscription/inscription.php?id=<?= $cour->getIdCours() ?>">
                                <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    Join Course
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
    <?php
            endif;
        endforeach;
    } else {
        echo "<p class='text-center text-gray-600'>Aucun cours trouvé pour cette catégorie.</p>";
    }
    ?>
</div>
</div>


</body>
</html>
