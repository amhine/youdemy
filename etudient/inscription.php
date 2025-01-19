<?php
session_start();
require './../classe/connexion.php';
require './../classe/utilisateur.php';
require './../classe/cours.php';

$db = new Connexion();
$connect = $db->getConnection();
$pdo = $db->getConnection(); 

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id_user'])) {
    header("Location: ./../authentification/login.php");
    exit();
}

// Récupérez l'ID du cours depuis l'URL
$id_cours = isset($_GET['id_cours']) ? (int)$_GET['id_cours'] : null;

if (!$id_cours) {
    die("ID du cours non spécifié.");
}

// Récupérez les détails du cours
$cours = Cours::getCoursById($pdo, $id_cours);

if (!$cours) {
    die("Cours non trouvé.");
}

// Récupérez l'ID de l'étudiant connecté
$id_etudiant = $_SESSION['id_user'];

// Vérifiez si l'utilisateur est déjà inscrit au cours
$etudiant = new Etudiant($db, null, null, null, null, null, null, null, null);

if ($etudiant->estInscrit($id_etudiant, $id_cours)) {
    // L'utilisateur est déjà inscrit, redirigez-le vers la page du cours
    header("Location: ./../etudient/voircourses.php?id_cours=" . $cours->getIdCours());
    exit();
}

// Inscrivez l'étudiant au cours
$success = $etudiant->inscrireAuCours($id_etudiant, $id_cours);

if ($success) {
    // Redirigez vers la page du cours spécifique
    header("Location: ./../etudient/voircourses.php?id_cours=" . $cours->getIdCours());
} else {
    header("Location: ./../etudient/courses.php?error=1");
}
exit();
?>