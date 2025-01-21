<?php
require './../classe/connexion.php';
require './../classe/categorie.php';

$db = new Connexion();
$connect = $db->getConnection();
$categorieObj = new Categorie();
$categories = $categorieObj->getCategories(); 
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


  
</body>
</html>
