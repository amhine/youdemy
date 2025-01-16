<!DOCTYPE html>
<html lang="en">
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
            <a  href="./../enseignent/teacher.php" class="block text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teacher</a>
            <a href="./../authentification/signup.php" class="text-white hover:text-blue-500 px-4 py-2 rounded bg-blue-600 hover:bg-blue-700">Logout</a>
        </div>
    </div>
</nav>

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
