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
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; 
$offset = ($page - 1) * $limit; 

$cours = array_merge(
    $coursDocument->getCoursPaginated($limit, $offset, $search),
    $coursVideo->getCoursPaginated($limit, $offset, $search)
);
$uniqueCours = [];
foreach ($cours as $coursItem) {
    $uniqueCours[$coursItem->getIdCours()] = $coursItem; 
}

$cours = array_values($uniqueCours);

$totalCours = $coursDocument->countCours($search ) + $coursVideo->countCours($search);
$totalPages = ceil($totalCours / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white mb-8 rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <img src="https://frontends.udemycdn.com/frontends-homepage/staticx/udemy/images/v7/logo-udemy.svg" alt="Udemy" width="75" height="28" loading="lazy" style="vertical-align: middle;">
                </div>
                
                <!-- Nav Links -->
                <div class="hidden md:flex md:items-center space-x-4">
                    <a href="./../etudient/home.php" class="text-gray-800 cursor-pointer hover:purple-800 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="./../etudient/categorie.php" class="text-gray-600 cursor-pointer hover:purple-800 px-3 py-2 rounded-md text-sm font-medium">Categorier</a>
                    <a href="./../etudient/courses.php" class="text-gray-600 hover:text-purple-800 px-3 py-2 rounded-md text-sm font-medium">Courses</a>
                    <a href="./../etudient/mescours.php" class="text-gray-600 hover:text-purple-800 px-3 py-2 rounded-md text-sm font-medium">Mes Cours</a>
                    <a href="./../authentification/login.php" class="text-white hover:text-purple-500 px-4 py-2 rounded bg-purple-600 hover:bg-purple-700">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Barre de recherche -->
    <div class="container mx-auto px-4 mb-8">
        <form action="" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Rechercher un cours..." value="<?= ($search) ?>" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-purple-600">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700">Rechercher</button>
        </form>
    </div>

    <!-- Affichage des cours -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 mt-12">
        <?php if (!empty($cours)): ?>
            <?php foreach ($cours as $coursItem): ?>
                <!-- Nouvelle carte de cours -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative">
                        <!-- Image du cours -->
                        <img src="<?= $coursItem->getimage() ?>" alt="Course thumbnail" class="w-full h-48 object-cover">
                        <!-- Catégorie en badge -->
                        <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm">
                            <?= $coursItem->getCategorie() ? $coursItem->getCategorie()['nom_categorie'] : 'No Category'; ?>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Nom du cours -->
                        <h3 class="text-xl font-semibold mb-2 text-gray-800"><?= ($coursItem->getNom()) ?></h3>
                        <!-- Description du cours -->
                        <p class="text-gray-600 mb-4"><?= ($coursItem->getdescription()) ?></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php
                            $tag = new Tag($db, null, null);
                            $tags = $tag->getTagsByCours($coursItem->getIdCours());
                            ?>
                            <p class="text-sm text-gray-600 mb-4">Tags :
                                <?php foreach ($tags as $tag): ?>
                                    <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-sm">#<?= ($tag->getNomTag()) ?></span>
                                <?php endforeach; ?>
                            </p>
                        </div>
                        <div class="flex justify-between items-center">
                            <!-- Lien vers la page du cours -->
                            <a href="cours_voir.php?id_cours=<?= $coursItem->getIdCours() ?>">
                                <button class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                                    Read More
                                </button>
                            </a>
                            <!-- Bouton d'inscription -->
                            <a href="./../etudient/inscription.php ?id_cours=<?= $coursItem->getIdCours() ?>">
                                <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    Join Course
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucun cours trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
  <!-- Pagination -->
<div class="flex justify-center mt-8">
    <nav class="inline-flex rounded-md shadow-sm">
        <!-- Page précédente -->
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white rounded-l-md hover:bg-purple-700">
                <i class="fa-solid fa-chevron-left mt-1"></i>
            </a>
        <?php endif; ?>
        <?php 
        $pagesRemplies = min($totalPages, ceil($totalCours / $limit)); 

        for ($i = 1; $i <= $pagesRemplies; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white hover:bg-purple-700 <?= $i === $page ? 'bg-purple-700' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Page suivante -->
        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700">
                <i class="fa-solid fa-chevron-right mt-1"></i>
            </a>
        <?php endif; ?>
    </nav>
</div>


    <!-- Footer -->
    <footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-purple-700 mt-8">
        <div class="container mx-auto  py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <!-- About Education Section -->
                <div class="fh5co-widget">
                    <h3 class="text-xl font-semibold  ">About Education</h3>
                    <p class="mt-2 text-sm ">Facilis ipsum reprehenderit nemo molestias. Aut cum mollitia reprehenderit. Eos cumque dicta adipisci architecto culpa amet.</p>
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