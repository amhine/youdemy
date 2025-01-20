<?php
require './../classe/connexion.php';
require './../classe/categorie.php';
require './../classe/cours.php';
require './../classe/tag.php';

$db = new Connexion();
$connect = $db->getConnection();
$pdo = $db->getConnection();
$id_cours = isset($_GET['id_cours']) ? (int)$_GET['id_cours'] : null;

if (!$id_cours) {
    die("ID du cours non spécifié.");
}
$coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null);
$coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);

$cours = $coursDocument->getCoursById($pdo, $id_cours);

if (!$cours) {
    $cours = $coursVideo->getCoursById($pdo, $id_cours);
}

if (!$cours) {
    die("Cours non trouvé.");
}

$tag = new Tag($db, null, null);
$tags = $tag->getTagsByCours($id_cours);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $cours->getNom() ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
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

    <!-- Détails du cours -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1">
            <div class="relative">
                <!-- Image du cours -->
                <img src="<?= $cours->getimage() ?>" alt="Course thumbnail" class="w-full h-64 object-cover">
                <!-- Catégorie en badge -->
                <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm">
                    <?= $cours->getCategorie() ? $cours->getCategorie()['nom_categorie'] : 'No Category'; ?>
                </div>
            </div>
            <div class="p-6">
                <!-- Nom du cours -->
                <h1 class="text-2xl font-semibold mb-4 text-gray-800"><?= $cours->getNom() ?></h1>
                <!-- Description du cours -->
                <p class="text-gray-600 mb-4"><?= $cours->getdescription() ?></p>
                <!-- Tags du cours -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <p class="text-sm text-gray-600 mb-4">Tags :
                        <?php foreach ($tags as $tag): ?>
                            <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-sm">#<?= $tag->getNomTag() ?></span>
                        <?php endforeach; ?>
                    </p>
                </div>
                <?php if ($cours->getcontenu() === 'video'): ?>
                    <p class="text-sm text-blue-600">Type : Vidéo</p>
                <?php elseif ($cours->getcontenu() === 'document'): ?>
                    <p class="text-sm text-green-600">Type : Document</p>
                <?php endif; ?>
                <!-- Bouton d'inscription -->
                <div class="flex justify-end">
                            <a href="./../etudient/inscription.php?id_cours=<?= $cours->getIdCours() ?>">
                                <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    Join Course
                                </button>
                            </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-purple-700">
        <!-- ... (votre code de footer existant) ... -->
    </footer>
</body>
</html>