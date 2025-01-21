<?php
require './../classe/connexion.php';
require './../classe/tag.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tag = isset($_POST['id_tag']) ? $_POST['id_tag'] : null;
    $nom_tag = isset($_POST['nom_tag']) ? $_POST['nom_tag'] : null;

    if ($id_tag && $nom_tag) {
        $db = new Connexion();
        $tag = new Tag($db, null, null);
        
        if ($tag->modifierTag($id_tag, $nom_tag)) {
            header('Location:  ./../admin/tags.php?success=1');
            exit();
        } else {
            header('Location: modifiertag.php?id_tag=' . $id_tag . '&error=1');
            exit();
        }
    } else {
        header('Location: ./../admin/tags.php?error=missing_data');
        exit();
    }
} else {
    header('Location:  ./../admin/tags.php');
    exit();
}