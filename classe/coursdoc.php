<?php

class CoursDocument extends Cours {

    public function __construct($db, $nom_cours, $fichier) {
        parent::__construct($db, $nom_cours, $fichier, 'document');
    }

    // Méthode pour ajouter un contenu document
    public function ajouterContenu() {
        return "Ajout du cours document : " . $this->nom_cours . " avec le fichier : " . $this->fichier;
    }

    // Sauvegarder le cours document dans la base de données
    public function save() {
        if (parent::save()) {
            echo "Le cours document a été ajouté avec succès!";
            return true;
        }
        return false;
    }
}

?>