<?php

require './../classe/connexion.php';
require './../classe/role.php';

$db = new Connexion();
$role = new Role("", ""); 
$roles = $role->getRole();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <main class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
            

            <!-- Header -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-800">Sign up</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Already have an account? 
                    <a href="./login.php" class="font-medium text-gray-800 hover:text-gray-800">Log in here</a>
                </p>
            </div>

            <!-- Form -->
            <form id="signupForm" action="process_signup.php" method="POST" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Name
                        </label>
                        <input type="text" id="name" name="nom_user"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="nameError">Invalid name (only letters allowed).</small>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input type="email" id="email" name="email"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="emailError">Invalid email address.</small>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" id="password" name="pasword"  
                            class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm">
                        <small class="text-red-500 hidden" id="passwordError">Password must be at least 6 characters long.</small>
                    </div>
                    <div class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm">
                    
                    <select id="role" name="role" required class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="0">Choose your role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?php echo($role['nom_role']); ?>">
                                    <?php echo($role['nom_role']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Sign up
                    </button>
                </div>
            </form>
        </div>
       
    </main>
    <script>
        const signupForm = document.getElementById("signupForm");

        signupForm.onsubmit = function () {
            let isValid = true;

            // Name validation
            const nameInput = document.getElementById("name");
            const nameError = document.getElementById("nameError");
            const nameRegex = /^[A-Za-z\s]+$/;

            if (!nameRegex.test(nameInput.value)) {
                isValid = false;
                nameError.classList.remove("hidden");
            } else {
                nameError.classList.add("hidden");
            }

            // Email validation
            const emailInput = document.getElementById("email");
            const emailError = document.getElementById("emailError");
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailRegex.test(emailInput.value)) {
                isValid = false;
                emailError.classList.remove("hidden");
            } else {
                emailError.classList.add("hidden");
            }

            // Password validation
            const passwordInput = document.getElementById("password");
            const passwordError = document.getElementById("passwordError");

            if (passwordInput.value.length < 6) {
                isValid = false;
                passwordError.classList.remove("hidden");
            } else {
                passwordError.classList.add("hidden");
            }

            return isValid;
        };
    </script>
</body>
</html>
