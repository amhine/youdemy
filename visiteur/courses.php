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
                    <a href="./../visiteur/home.php" class="text-gray-800 cursor-pointer hover:purple-800 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="./../visiteur/categorie.php" class="text-gray-600 cursor-pointer hover:purple-800 px-3 py-2 rounded-md text-sm font-medium">Categorier</a>
                    <a href="./../visiteur/courses.php" class="text-gray-600 hover:text-purple-800 px-3 py-2 rounded-md text-sm font-medium">Courses</a>
                    <a href="./../visiteur/teacher.php" class="text-gray-600 hover:text-purple-800 px-3 py-2 rounded-md text-sm font-medium">Teacher</a>
                    <a href="./../authentification/login.php" class="text-white hover:text-purple-500 px-4 py-2 rounded bg-purple-600 hover:bg-purple-700">Login</a>
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
                            <a href="../Controller/inscription/inscription.php?id=<?= $coursItem->getIdCours() ?>">
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
    <div class="flex justify-center mt-8">
        <nav class="inline-flex rounded-md shadow-sm">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white rounded-l-md hover:bg-purple-700">
                <i class="fa-solid fa-chevron-left mt-1"></i>
                </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white hover:bg-purple-700 <?= $i === $page ? 'bg-purple-700' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700">
                <i class="fa-solid fa-chevron-right mt-1"></i>
                </a>
                
            <?php endif; ?>
        </nav>
    </div>

    <!-- Footer -->
    <footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-purple-700">
        <!-- ... (votre code de footer existant) ... -->
    </footer>
</body>
</html>