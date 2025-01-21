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
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Liste des Utilisateurs</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nom</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Rôle</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateursObjets as $utilisateur): 
                        $details = $utilisateur->getDetails();
                    ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800"><?php echo htmlspecialchars($details['nom_user']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-800"><?php echo htmlspecialchars($details['email']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-800"><?php echo htmlspecialchars($details['role']); ?></td>
                            <td class="px-4 py-2 text-sm space-x-2">
                                <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500" onclick="accepterUtilisateur(<?php echo $details['id_user']; ?>)">
                                    Accepter
                                </button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="refuserUtilisateur(<?php echo $details['id_user']; ?>)">
                                    Refuser
                                </button>
                                <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500" onclick="suspendreUtilisateur(<?php echo $details['id_user']; ?>)">
                                    Suspendre
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
