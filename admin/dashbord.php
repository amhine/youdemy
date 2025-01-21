<?php
include './../classe/connexion.php';
require './../classe/utilisateur.php';
require './../classe/cours.php'; 
require './../classe/categorie.php';

$db = new Connexion();
$utilisateur = new Enseignant($db);
$categorie = new Categorie($db, null, null);

$coursDocument = new CoursDocument($db, null, null, null, null, null, null, null, null, null);
$coursVideo = new CoursVideo($db, null, null, null, null, null, null, null, null, null);

$totalCours = $coursDocument->getNombreTotalCours(); 
$coursPopulaire = $coursDocument->getCoursLePlusPopulaire(); 
$topEnseignants = $utilisateur->getTopEnseignants(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-indigo-50 min-h-screen overflow-x-hidden">

    <header class="fixed w-full bg-white text-indigo-800 z-50 shadow-lg animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between h-16">
            <button class="mobile-menu-button p-2 lg:hidden">
                <span class="block w-6 h-0.5 bg-gray-700 mb-1"></span>
                <span class="block w-6 h-0.5 bg-gray-700 mb-1"></span>
                <span class="block w-6 h-0.5 bg-gray-700"></span>
            </button>
            <div class="flex text-xl font-bold text-purple-700">
                Admin<span class="text-purple-700"><img src="https://frontends.udemycdn.com/frontends-homepage/staticx/udemy/images/v7/logo-udemy.svg" alt="Udemy" width="75" height="28" loading="lazy" style="vertical-align: middle;"></span>
            </div>
            <div class="flex items-center space-x-2">
                <img class="w-10 h-10 rounded-full transition-transform duration-300 hover:scale-110 object-cover" 
                    src="https://th.bing.com/th/id/R.b6350e5011a7b61996efada66d100575?rik=7D6Ni11ELDKMoA&pid=ImgRaw&r=0" 
                    alt="Profile">
                    
            </div>
        </div>
    </header>

    <div class="pt-16 max-w-7xl mx-auto flex">
        <aside class="sidebar fixed lg:static w-[240px] bg-indigo-50 h-[calc(100vh-4rem)] lg:h-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-45 overflow-y-auto p-4">
            <div class="bg-white rounded-xl shadow-lg mb-6 p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <a href="./../admin/aficherinscription.php" class="flex items-center text-gray-600 hover:text-purple-700 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book"> Les Comptes </i>
                </a>
                <a href="ajoutvehiculeadmin.php" class="flex items-center text-gray-600 hover:text-purple-700 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book"> les Utilisateur </i>
                </a>
                <a href="courses.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book">les Cours</i>
               
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-4 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <a href="categorie.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
            <i class="fa-sharp-duotone fa-solid fa-book"> les categories</i>
           
            </a>
                
                <a href="tags.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book"> Les tags</i>
                </a>
                <a href="ajouter-tags.php.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book">Statistiques </i>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-4">
            <div class="flex flex-col lg:flex-row gap-4 mb-6">
                <div class="flex-1 bg-purple-700 border border-indigo-200 rounded-xl p-6 animate-fade-in h-32">
                    <h2 class="text-sm md:text-xl text-white font-bold">Nombre total de cours</h2>
                    <span class="text-sm md:text-xl text-white font-bold"><?php echo $totalCours; ?> cours</span>
                </div>

              
            </div>
            <div class="flex flex-col lg:flex-row gap-4 mb-6">
                <div class="flex-1 bg-purple-700 border border-indigo-200 rounded-xl p-6 animate-fade-in h-32">
                    <h2 class="text-sm md:text-xl text-white font-bold"> Le cour avec le plus d' étudiants</h2>
                    <span class="text-sm md:text-xl text-white font-bold"> <?php 
    if ($coursPopulaire) {
        echo htmlspecialchars($coursPopulaire['nom_cours']) . 
             ' (' . $coursPopulaire['nombre_etudiants'] . ' étudiants)';
    }
    ?></span>
                </div>

                <div class="flex-1 bg-purple-700 border border-blue-200 rounded-xl p-6 animate-fade-in">
                    <h2 class="text-sm md:text-xl text-white font-bold">Les Top 3 enseignants.</h2>
                    <span class="text-sm md:text-xl text-white font-bold">  <?php 
    foreach($topEnseignants as $index => $enseignant) {
        echo ($index + 1) . '. ' . htmlspecialchars($enseignant['nom_user']) . 
             ' (' . $enseignant['nombre_cours'] . ' cours)<br>';
    }
    ?></span>
                </div>
                
            </div>

            
        </main>
    </div>

</body>
</html>
