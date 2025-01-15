<?php

class CoursVideo extends Cours {

    public function __construct($db, $nom_cours, $fichier) {
        parent::__construct($db, $nom_cours, $fichier, 'video');
    }

    // Méthode pour ajouter un contenu vidéo
    public function ajouterContenu() {
        return "Ajout du cours vidéo : " . $this->nom_cours . " avec le fichier : " . $this->fichier;
    }

    // Sauvegarder le cours vidéo dans la base de données
    public function save() {
        if (parent::save()) {
            echo "Le cours vidéo a été ajouté avec succès!";
            return true;
        }
        return false;
    }
}


?>