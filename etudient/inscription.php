<?php
session_start();
require './../classe/connexion.php';
require './../classe/utilisateur.php';
require './../classe/cours.php';

$db = new Connexion();
$connect = $db->getConnection();
$pdo = $db->getConnection(); 

if (!isset($_SESSION['id_user'])) {
    header("Location: ./../authentification/login.php");
    exit();
}

$id_cours = isset($_GET['id_cours']) ? (int)$_GET['id_cours'] : null;

if (!$id_cours) {
    die("ID du cours non spécifié.");
}

$cours = Cours::getCoursById($pdo, $id_cours);

if (!$cours) {
    die("Cours non trouvé.");
}

$id_etudiant = $_SESSION['id_user'];

$etudiant = new Etudiant($db, null, null, null, null, null, null, null, null);

if ($etudiant->estInscrit($id_etudiant, $id_cours)) {
    header("Location: ./../etudient/voircourses.php?id_cours=" . $cours->getIdCours());
    exit();
}

$success = $etudiant->inscrireAuCours($id_etudiant, $id_cours);

if ($success) {
    header("Location: ./../etudient/voircourses.php?id_cours=" . $cours->getIdCours());
} else {
    header("Location: ./../etudient/courses.php?error=1");
}
exit();
?>