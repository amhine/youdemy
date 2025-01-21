<?php
require './../classe/connexion.php';
require './../classe/tag.php';

$db = new Connexion();
$conn = $db->getConnection();

$tagObj = new Tag($conn, null, null);

$id_tag = isset($_GET['id_tag']) ? (int)$_GET['id_tag'] : null;

if ($id_tag) {
    $tagDetails = $tagObj->gettagById($id_tag); 
} else {
    echo "ID du tag manquant.";
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le tag</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen m-0">
<div class="container">
    <form action="./../script.php/scriptmodificationtagadmin.php" method="POST" id="modifyTagForm">
        <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg overflow-y-scroll">
            <div class="px-8 py-4 bg-blue-400 text-white">
                <h1 class="flex justify-center font-bold text-white text-3xl">Modifier les tags</h1>
            </div>
            <div class="px-8 py-6">

                <div>
                    <label for="nom_tag" class="block text-gray-700 font-semibold mb-2">Tags :</label>
                    <?php
                    if ($tagDetails) {
                        echo '<input type="text" name="nom_tag" value="' . ($tagDetails->nom_tag) . '" class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-gray-800 focus:border-gray-800 focus:z-10 sm:text-sm" required>';
                    } else {
                        echo "Aucun tag trouvé.";
                    }
                    ?>
                </div>

                <input type="hidden" name="id_tag" value="<?= ($tagDetails->id_tag) ?>" />

                <!-- Submit -->
                <button type="submit" class="text-white bg-blue-600 w-40 rounded-lg py-3 hover:bg-blue-800 cursor-pointer mt-6">Modifier</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
