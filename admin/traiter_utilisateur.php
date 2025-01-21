<?php
session_start();
require './../classe/connexion.php';
require './../classe/utilisateur.php';

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    header('Location: liste_utilisateurs.php');
    exit;
}

$admin = new Administrateur();
$action = $_GET['action'];
$id_utilisateur = $_GET['id'];

switch($action) {
    case 'accepter':
        $admin->gérerUtilisateur($id_utilisateur, 'actif');
        break;
        
    case 'refuser':
        $admin->supprimerUtilisateur($id_utilisateur);
        break;
        
    case 'suspendre':
        $admin->gérerUtilisateur($id_utilisateur, 'inactif');
        break;
}

header('Location: aficherinscription.php');
exit;

?>