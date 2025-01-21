<?php
require '../classe/connexion.php';
require '../classe/utilisateur.php';

$utilisateurObj = new Utilisateur();

$utilisateursObjets = $utilisateurObj->afficherUtilisateurs();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
</head>
<body class="bg-gray-100">
<a href="./../admin/dashbord.php " class=" flex justify-end mt-6">
                                <button class="px-6 py-2 border-2 border-purple-600 text-black font-bold bg-white rounded-full hover:bg-purple-600 hover:text-white hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                                    Retourne dashbord
                                </button>
                     </a>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Liste des Utilisateurs</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nom</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Rôle</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                      
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateursObjets as $utilisateur): 
                        $details = $utilisateur->getDetails();
                    ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800"><?= $utilisateur->getnomuser(); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-800"><?= $utilisateur->getemail(); ?></td>
                            <td><?php echo $utilisateur->getDetails()['role']; ?></td>
                        <td><?php echo $utilisateur->getStatus(); ?></td>
                            <td class="px-4 py-2 text-sm space-x-2">
                                
                            <a href="traiter_utilisateur.php?action=accepter&id=<?php echo $utilisateur->getiduser(); ?>" 
                               class="btn btn-success btn-sm">Accepter</a>
                            <a href="traiter_utilisateur.php?action=refuser&id=<?php echo $utilisateur->getiduser(); ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Êtes-vous sûr de vouloir refuser cet utilisateur ?')">Refuser</a>
                            <a href="traiter_utilisateur.php?action=suspendre&id=<?php echo $utilisateur->getiduser(); ?>" 
                               class="btn btn-warning btn-sm">Suspendre</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
