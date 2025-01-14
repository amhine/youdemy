<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./output.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="bg-gray-800 text-white mb-3">
    <div class="bg-gray-800 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="index.html" class="text-xl font-bold text-white flex items-center">
                    <i class="icon-study mr-2"></i> Youdemy<span class="text-blue-500">.</span>
                </a>
            </div>
            <div class="relative">
                <ul class="flex space-x-8 text-sm font-medium">
                    <li class="active"><a href="index.html" class="text-white hover:text-blue-500">Home</a></li>
                    <li><a href="categorie.php" class="text-white hover:text-blue-500">Categorie</a></li>
                    <li><a href="courses.php" class="text-white hover:text-blue-500">Courses</a></li>
                    <li><a href="teacher.php" class="text-white hover:text-blue-500">Teacher</a>
                        <!-- Dropdown -->
                        <ul class="absolute left-0 hidden bg-white text-black shadow-lg mt-2 space-y-2 py-2 px-4 rounded group-hover:block">
                            <li><a href="#" class="block hover:text-blue-500">Web Design</a></li>
                            <li><a href="#" class="block hover:text-blue-500">eCommerce</a></li>
                            <li><a href="#" class="block hover:text-blue-500">Branding</a></li>
                            <li><a href="#" class="block hover:text-blue-500">API</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="text-white hover:text-blue-500 px-4 py-2 rounded bg-blue-600 hover:bg-blue-700">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Footer -->
<footer id="fh5co-footer" role="contentinfo" class="bg-cover bg-center text-white bg-gray-800">
    <div class="overlay absolute inset-0 opacity-50"></div>
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
