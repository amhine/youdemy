<?php
require './../classe/connexion.php';
require './../classe/cours.php'; 
require './../classe/utilisateur.php';

$db = new Connexion();
$connect = $db->getConnection();

// Assurez-vous de récupérer un ID de cours valide
$id_cours = isset($_GET['id_cours']) ? (int)$_GET['id_cours'] : null;

// Vérifier si l'ID est valide
if ($id_cours !== null) {
    // Récupérer les informations du cours en utilisant l'ID
    $cours = CoursDocument::getCoursById($connect, $id_cours);

    if ($cours !== null) {
        // Récupérer les étudiants inscrits
        $etudiants = $cours->getEtudiantsInscrits(); // Assurez-vous que cette méthode est implémentée

        // Récupérer le nombre d'étudiants inscrits
        $nombreEtudiants = $cours->getNombreEtudiantsInscrits(); // Assurez-vous que cette méthode est implémentée
    } else {
        echo "Aucun cours trouvé avec cet ID.";
        exit();
    }
} else {
    echo "ID du cours manquant ou invalide.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants inscrits</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen m-0">
    <div class="container">
        <div class="max-w-[800px] w-full max-h-[500px] bg-white rounded-lg shadow-lg">
            <div class="px-8 py-4 bg-blue-400 text-white">
                <h1 class="flex justify-center font-bold text-white text-3xl">Les Inscriptions</h1>
            </div>
            <div class="px-8 py-6">
                <!-- Afficher le nombre d'étudiants inscrits -->
                <div class="mb-6">
                    <p class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        Nombre d'étudiants inscrits : <?= htmlspecialchars($nombreEtudiants) ?>
                    </p>
                </div>

                <!-- Afficher la liste des étudiants inscrits -->
                <?php if (!empty($etudiants)): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4">Liste des étudiants inscrits :</h2>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <p class="appearance-none border border-gray-400 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent mb-2">
                                <?= htmlspecialchars($etudiant['nom_user']) ?>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-700">Aucun étudiant inscrit pour ce cours.</p>
                <?php endif; ?>

                <!-- Bouton de retour -->
                <div class="flex justify-between mt-8">
                    <a href="./../enseignent/courses.php" class="text-white bg-red-600 w-40 rounded-lg py-3 hover:bg-red-800 cursor-pointer flex justify-center">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>