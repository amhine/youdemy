<?php

// include './conexion.php';
// require './../class/utilisateur.php';
// require './../class/categorier.php';
// require './../class/vehicule.php';
// require './../class/reservation.php';
// require './../class/theme.php';
// require './../class/article.php';
// require './../class/tags.php';

// $db = new Database();
// $utilisateur = new Utilisateur($db);
// $categorie = new Categorie($db); 
// $theme = new Theme($db); 
// $article = new Article($db); 
// $themes = $theme->getTheme();
// $categories = $categorie->getCategories();
// $vehicule = new Vehicule($db); 
// $vehicules = $vehicule->getvehicule();
// $Reservation = new Reservation($db); 
// $Reservations = $Reservation->getAllReservations();
// $articles = $article->getArticle();
// $tag = new Tag($db);
// $tags= $tag ->getAll();
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
            <a href="ajouter-articledash.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
            <i class="fa-sharp-duotone fa-solid fa-book"> Ajouter Categorie</i>
           
            </a>
                
                <a href="ajout-theme.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book"> Ajouter tags</i>
                </a>
                <a href="ajouter-tags.php.php" class="flex items-center text-gray-600 hover:text-indigo-800 py-4 transition-all duration-300 hover:translate-x-1">
                <i class="fa-sharp-duotone fa-solid fa-book">Statistiques </i>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-4">
            <div class="flex flex-col lg:flex-row gap-4 mb-6">
                <div class="flex-1 bg-purple-700 border border-indigo-200 rounded-xl p-6 animate-fade-in h-32">
                    <h2 class="text-sm md:text-xl text-white font-bold">Welcome Reservation</h2>
                    <span class="text-sm md:text-xl text-white font-bold"><?php echo $Reservation->countReservation(); ?></span>
                </div>

                <div class="flex-1 bg-purple-700 border border-blue-200 rounded-xl p-6 animate-fade-in">
                    <h2 class="text-sm md:text-xl text-white font-bold">Clients inscrits</h2>
                    <span class="text-sm md:text-xl text-white font-bold"><?php echo $utilisateur->countRole('User'); ?></span>
                </div>
            </div>

            <div class="reservations-container container mx-auto flex flex-col gap-8 py-8">
                <!-- Categories Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Nouvelle categorier</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($categories as $cat): ?>
                            <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105">
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo ($cat['nom']); ?></h3>
                                <p class="text-sm text-gray-600 mb-4"><?php echo ($cat['description']); ?></p>
                                <div class="mt-auto">
                                    <img src="<?php echo ($cat['image']); ?>" alt="vehicle-type-<?php echo strtolower($cat['nom']); ?>" class="w-36 h-24 object-cover mx-auto">
                                    <span class="mt-4 block text-blue-600 font-semibold hover:underline">Voir plus</span>
                                </div>
                                <div class="mt-4 flex gap-4">
                                    <a href="modifier_categorie.php?id_categorie=<?php echo $cat['id_categorie']; ?>" class="text-white bg-yellow-500 rounded-lg px-4 py-2 hover:bg-yellow-600 transition-colors">
                                        Modifier
                                    </a>
                                    <form action="supprimer_categorie.php" method="POST">
                                        <input type="hidden" name="id_categorie" value="<?php echo $cat['id_categorie']; ?>">
                                        <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>  
                    </div>
                </div>

                <!-- Vehicles Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Liste des cours</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($vehicules as $vehicule): ?>
                            <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105">
                                <img src="<?php echo ($vehicule['image']); ?>" alt="vehicle-<?php echo ($vehicule['marque']); ?>" class="w-36 h-24 object-cover mx-auto mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo ($vehicule['marque'] . ' ' . $vehicule['madele']); ?></h3>
                                <p class="text-sm text-gray-600 mb-4">Prix : <?php echo ($vehicule['prix']); ?> DH</p>
                                <div class="mt-auto flex gap-4">
                                    <a href="modifier_vehicule.php?id_vehicule=<?php echo $vehicule['id_vehicule']; ?>" class="text-white bg-yellow-500 rounded-lg px-4 py-2 hover:bg-yellow-600 transition-colors">
                                        Modifier
                                    </a>
                                    <form action="supprimer_vehicule.php" method="POST">
                                        <input type="hidden" name="id_vehicule" value="<?php echo $vehicule['id_vehicule']; ?>">
                                        <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Reservations Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Liste des tags</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($Reservations as $Reservation): ?>
                            <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105">
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo ($Reservation['date']); ?></h3>
                                <p class="text-sm text-gray-600 mb-4">Lieu : <?php echo ($Reservation['lieu']); ?></p>
                                <p class="text-sm text-gray-600 mb-4">Prix : <?php echo ($Reservation['prix']); ?> DH</p>
                                <div class="mt-auto flex gap-4">
                                    <form action="supprimer_reservation.php" method="POST">
                                        <input type="hidden" name="id_reservation" value="<?php echo $Reservation['id_reservation']; ?>">
                                        <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- tags Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Liste des tags</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($tags as $tag): ?>
                            <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105">
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($tag['nom_tag']); ?></h3>
                                
                                <!-- Formulaire pour supprimer un tag -->
                                 <div class="mt-auto flex gap-4">
                                 <a href="modifier_tag.php?id_tag=<?php echo $tag['id_tag']; ?>" class="text-white bg-yellow-500 rounded-lg px-4 py-2 hover:bg-yellow-600 transition-colors">
                                     Modifier
                                </a>
                                <form action="supprimer_tag.php" method="POST">
                                    <input type="hidden" name="id_tag" value="<?php echo $tag['id_tag']; ?>">
                                    <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                        Supprimer
                                    </button>
                                </form>

                                 </div>
                                
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <!-- Themes Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Liste des Thèmes</h1>
                    <div class="flex flex-wrap justify-center mt-8 gap-10">
                        <?php foreach ($themes as $cat): ?>
                            <a href="theme_details.php?id_theme=<?php echo $cat['id_theme']; ?>" class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105 w-1 md:w-1/2 lg:w-1/3">
                                <h3 class="text-lg font-bold text-blue-600 mb-2"><?php echo $cat['nom_theme']; ?></h3>
                                <p class="text-sm text-gray-600 mb-4"><?php echo $cat['description']; ?></p>
                                
                                <span class="mt-4 block text-blue-600 font-semibold hover:underline">Voir plus</span>
                            </a>
                            <div class="mt-auto flex gap-4">
                                <a href="modifier_theme.php?id_theme=<?php echo $cat['id_theme']; ?>" class="text-white bg-yellow-500 rounded-lg px-4 py-2 hover:bg-yellow-600 transition-colors">
                                     Modifier
                                </a>
                                <form action="supprimer_theme.php" method="POST">
                                    <input type="hidden" name="id_theme" value="<?php echo $cat['id_theme']; ?>">
                                    <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <!-- Articles Section -->
                <div class="reservation-card bg-white border border-gray-300 rounded-lg shadow-lg p-6 hover:shadow-xl transition-transform transform hover:-translate-y-2">
                    <h1 class="text-center text-4xl font-bold text-purple-700 mt-4 mb-4">Liste des articles</h1>
                    <div id="vehicles-container" class="space-y-6" style="max-height: 500px; overflow-y: auto;">
                        <?php foreach ($articles as $article): ?>
                            <div class="flex flex-col items-center text-center">
                                <h1 class="text-lg font-bold text-blue-600 mb-2"><?php echo ($article['titre']); ?></h1>
                                <div class="flex flex-col items-start text-left w-full">
                                    <img src="<?php echo ($article['image']); ?>" alt="article-<?php echo ($article['titre']); ?>" class="object-cover h-96 w-full md:w-3/4 lg:w-3/4 xl:w-1/3 p-4 mx-auto mb-4 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-4">Créé le : <?php echo ($article['date_creation']); ?></p>
                                    <p class="text-sm text-gray-600 mb-4"><?php echo ($article['contrnue']); ?></p>
                                    <div class="mt-auto flex gap-4">
                                   
                                        <form action="accepter-article.php" method="POST">
                                            <input type="hidden" name="id_article" value="<?php echo $article['id_article']; ?>">
                                            <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                                Accepter
                                            </button>
                                        </form>
                                        
                                        <a href="modifier_article.php?id_article=<?php echo $article['id_article']; ?>" class="text-white bg-yellow-500 rounded-lg px-4 py-2 hover:bg-yellow-600 transition-colors">
                                            Modifier
                                        </a>
                                        <form action="supprimer_article.php" method="POST">
                                            <input type="hidden" name="id_article" value="<?php echo $article['id_article']; ?>">
                                            <button type="submit" class="text-white bg-red-600 rounded-lg px-4 py-2 hover:bg-red-700 transition-colors">
                                                Supprimer
                                            </button>
                                        </form>
                            
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- tags Section -->

            </div>
        </main>
    </div>

</body>
</html>
