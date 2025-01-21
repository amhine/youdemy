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
   
<div class="flex justify-end items-center m-5">
    <a href="ajoutercategorie.php" class="pt-1 text-white bg-purple-600 rounded-lg w-56 h-10 text-lg font-bold hover:bg-purple-700 transition-colors inline-block text-center">
        Ajouter Categorie
    </a>
    <a href="./../admin/dashbord.php ">
        <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
            Retourner au tableau de bord
        </button>
    </a>
</div>

<div class="flex flex-wrap justify-center mt-8 mb-8 gap-10">
    <?php foreach ($categories as $categorie): ?>
        <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-4 transition-transform transform hover:scale-105 w-1 md:w-1/2 lg:w-1/3">
            <h3 class="text-lg font-bold text-purple-600 mb-2"><?php echo $categorie->getNom(); ?></h3>
            <p class="text-sm text-gray-600 mb-4"><?php echo $categorie->getDescription(); ?></p>
            
            <div class="mt-auto">
                <span class="mt-4 block text-blue-600 font-semibold hover:underline">
                    <a href="?id_categorie=<?php echo $categorie->getIdCategorie(); ?>">Voir plus</a>
                </span>
            </div>
            
            <!-- Boutons Modifier et Supprimer -->
            <div class="flex justify-between w-full mt-4">
                <!-- Bouton Modifier -->
                <a href="modifiercategorie.php?id_categorie=<?php echo $categorie->getIdCategorie(); ?>" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Modifier
                </a>
                
                <!-- Bouton Supprimer -->
                <form action="supprimercategorie.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                    <input type="hidden" name="id_categorie" value="<?php echo $categorie->getIdCategorie(); ?>" />
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-700">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
