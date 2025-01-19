<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

$db = new Connexion();
$connect = $db->getConnection();
$categorieObj = new Categorie();
$categories = $categorieObj->getCategories(); // Retourne un tableau d'objets Categorie
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
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

    <div class="flex flex-wrap justify-center mt-8 mb-8 gap-10">
    <?php foreach ($categories as $categorie): ?>
        <a href="detailscategorie.php?id_categorie=<?php echo $categorie->getIdCategorie(); ?>" 
            class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105 w-1 md:w-1/2 lg:w-1/3">
            <h3 class="text-lg font-bold text-purple-600 mb-2"><?php echo $categorie->getNom(); ?></h3>
            <p class="text-sm text-gray-600 mb-4"><?php echo $categorie->getDescription(); ?></p>
            <div class="mt-auto">
                <span class="mt-4 block text-blue-600 font-semibold hover:underline">Voir plus</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>


   <!-- Footer -->
    <footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-purple-700">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
