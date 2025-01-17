<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php';

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
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-gray-800 mb-3">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="index.html" class="text-white text-2xl font-bold">
                        You<span class="text-blue-400">demy</span>
                    </a>
                </div>
                
                <!-- Hamburger Menu (mobile) -->
                <div class="md:hidden">
                    <button id="menu-toggle" class="text-gray-300 hover:text-white">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Nav Links -->
                <div class="hidden md:flex md:items-center space-x-4">
                    <a href="./../enseignent/home.php" class="text-gray-300 cursor-pointer hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="./../enseignent/categorie.php" class="text-gray-300 cursor-pointer hover:text-white px-3 py-2 rounded-md text-sm font-medium">Categorier</a>
                    <a href="./../enseignent/courses.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Courses</a>
                    <a href="./../enseignent/teacher.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teacher</a>
                    <a href="./../authentification/signup.php" class="text-white hover:text-blue-500 px-4 py-2 rounded bg-blue-600 hover:bg-blue-700">Logout</a>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="./../enseignent/home.php" class="block text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="./../enseignent/categorie.php" class="block text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Categorier</a>
                <a href="./../enseignent/courses.php" class="block text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Courses</a>
                <a href="./../enseignent/teacher.php" class="block text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teacher</a>
                <a href="./../authentification/signup.php" class="text-white hover:text-blue-500 px-4 py-2 rounded bg-blue-600 hover:bg-blue-700">Logout</a>
            </div>
        </div>
    </nav>

<div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
    <div class="mt-6 text-center mb-5 text-xl font-bold">
        <a href="./../enseignent/categorie.php" class="text-blue-500 font-semibold hover:underline">Retour aux catégories</a>
    </div>
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php
    // Vérification si des cours sont récupérés pour cette catégorie
    if (!empty($cours)) {
        // Créez un tableau associatif pour les catégories (optimisation)
        $categoriesAssoc = [];
        foreach ($categories as $cat) {
            $categoriesAssoc[$cat->getIdCategorie()] = $cat->getNom(); // Utilisez -> pour accéder aux propriétés
        }

        foreach ($cours as $cour):
            // Vérifiez si le cours est actif
            if ($cour->getstatus() === 'Actif'):  // Utilisation de la méthode getstatus()
                // Récupérez la catégorie du cours
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

<!-- Footer -->
<footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-gray-800">
    
    <div class="container mx-auto  py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            <!-- About Education Section -->
            <div class="fh5co-widget">
                <h3 class="text-xl font-semibold">About Education</h3>
                <p class="mt-2 text-sm">Facilis ipsum reprehenderit nemo molestias. Aut cum mollitia reprehenderit. Eos cumque dicta adipisci architecto culpa amet.</p>
            </div>

            <!-- Learning Section -->
            <div class="fh5co-widget">
                <h3 class="text-xl font-semibold">Learning</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-500">Course</a></li>
                    <li><a href="#" class="hover:text-blue-500">Blog</a></li>
                    <li><a href="#" class="hover:text-blue-500">Contact</a></li>
                    <li><a href="#" class="hover:text-blue-500">Terms</a></li>
                    <li><a href="#" class="hover:text-blue-500">Meetups</a></li>
                </ul>
            </div>

            <!-- Learn & Grow Section -->
            <div class="fh5co-widget">
                <h3 class="text-xl font-semibold">Learn &amp; Grow</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-500">Blog</a></li>
                    <li><a href="#" class="hover:text-blue-500">Privacy</a></li>
                    <li><a href="#" class="hover:text-blue-500">Testimonials</a></li>
                    <li><a href="#" class="hover:text-blue-500">Handbook</a></li>
                    <li><a href="#" class="hover:text-blue-500">Held Desk</a></li>
                </ul>
            </div>

            <!-- Engage us Section -->
            <div class="fh5co-widget">
                <h3 class="text-xl font-semibold">Engage us</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-500">Marketing</a></li>
                    <li><a href="#" class="hover:text-blue-500">Visual Assistant</a></li>
                    <li><a href="#" class="hover:text-blue-500">System Analysis</a></li>
                    <li><a href="#" class="hover:text-blue-500">Advertise</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="fh5co-widget">
                <h3 class="text-xl font-semibold">Legal</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-500">Find Designers</a></li>
                    <li><a href="#" class="hover:text-blue-500">Find Developers</a></li>
                    <li><a href="#" class="hover:text-blue-500">Teams</a></li>
                    <li><a href="#" class="hover:text-blue-500">Advertise</a></li>
                    <li><a href="#" class="hover:text-blue-500">API</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="row copyright mt-12">
            <div class="text-center">
                <p class="text-sm">
                    <small class="block">&copy; 2016 Free HTML5. All Rights Reserved.</small>
                    <small class="block">Designed by <a href="http://freehtml5.co/" target="_blank" class="text-blue-500 hover:underline">FreeHTML5.co</a> Demo Images: <a href="http://unsplash.co/" target="_blank" class="text-blue-500 hover:underline">Unsplash</a> &amp; <a href="https://www.pexels.com/" target="_blank" class="text-blue-500 hover:underline">Pexels</a></small>
                </p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
