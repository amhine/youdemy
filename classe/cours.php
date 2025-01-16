<?php
abstract class Cours {
    protected $conn;
    protected $id_cours;
    protected $nom_cours;
    protected $date_creation;
    protected $id_categorie;
    protected $id_user;
    protected $statut;
    protected $fichier;  
    protected $type_contenu;

    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, $type_contenu) {
        $this->conn = $db->getConnection();
        $this->id_cours = $id_cours;
        $this->nom_cours = $nom_cours;
        $this->date_creation = $date_creation;
        $this->id_categorie = $id_categorie;
        $this->id_user = $id_user;
        $this->statut = $statut;
        $this->fichier = $fichier;  
        $this->type_contenu = $type_contenu;
    }

    public function save() {
        $query = "INSERT INTO cours (nom_cours, date_creation, id_categorie, id_user, statut, type_contenu, fichier)
                  VALUES (:nom_cours, :date_creation, :id_categorie, :id_user, :statut, :type_contenu, :fichier)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_cours', $this->nom_cours);
        $stmt->bindParam(':date_creation', $this->date_creation);
        $stmt->bindParam(':id_categorie', $this->id_categorie);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':type_contenu', $this->type_contenu);
        $stmt->bindParam(':fichier', $this->fichier); 

        if ($stmt->execute()) {
                        return true;
                    }
                    return false;
    }
    public function getCours() {
                $query = "SELECT * FROM cours";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

    public function getCoursByCategorie($id_categorie) {
                $query = "SELECT * FROM cours WHERE id_categorie = :id_categorie";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id_categorie', $id_categorie);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC); 
            }
}
class CoursDocument extends Cours {
    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier) {
        parent::__construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, 'document');
    }

    public function ajouterContenu() {
        return "Ajout du cours document : " . $this->nom_cours . " avec le fichier disponible à l'URL : " . $this->fichier;
    }
}
class CoursVideo extends Cours {
    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier) {
        parent::__construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, 'video');
    }

    public function ajouterContenu() {
        return "Ajout du cours vidéo : " . $this->nom_cours . " avec le fichier disponible à l'URL : " . $this->fichier;
    }
}



?>
