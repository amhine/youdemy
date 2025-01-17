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
    protected $images;
    protected $description;
    
    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, $type_contenu, $images, $description) {
        $this->id_cours = $id_cours;
        $this->nom_cours = $nom_cours;
        $this->date_creation = $date_creation;
        $this->id_categorie = $id_categorie;
        $this->id_user = $id_user;
        $this->statut = $statut;
        $this->fichier = $fichier;  
        $this->type_contenu = $type_contenu;
        $this->images = $images;
        $this->description = $description;
        $this->conn = (new Connexion())->getConnection();
    }

    public function getIdCours() {
        return $this->id_cours;
    }

    public function getNom() {
        return $this->nom_cours;  
    }
    
    public function setNom($nom_cours) {
        $this->nom_cours = $nom_cours;  
    }

    public function getDate() {
        return $this->date_creation;  
    }
    
    public function setDate($date_creation) {
        $this->date_creation = $date_creation;  
    }

    public function getuser() {
        return $this->id_user;
    }

    public function setuser($id_user) {
        $this->id_user = $id_user;
    }

    public function getstatus() {
        return $this->statut;
    }

    public function setstatus($statut) {
        $this->statut = $statut;
    }

    public function getfichier() {
        return $this->fichier;
    }

    public function setfichier($fichier) {
        $this->fichier = $fichier;
    }

    public function getcontenu() {
        return $this->type_contenu;
    }

    public function setcontenu($type_contenu) {
        $this->type_contenu = $type_contenu;
    }

    public function getimage() {
        return $this->images;
    }

    public function setimage($images) {
        $this->images = $images;
    }

    public function getdescription() {
        return $this->description;
    }

    public function setdescription($description) {
        $this->description = $description;
    }

    public function getCategorie() {
        return $this->getCategorieById($this->id_categorie);
    }

    public function getCategorieById($id_categorie) {
        $query = "SELECT * FROM categorie WHERE id_categorie = :id_categorie";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByCours() {
        return $this->getUserById($this->id_user);
    }

    public function getUserById($id_user) {
        $query = "SELECT * FROM utilisateur WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save() {
        $query = "INSERT INTO cours (nom_cours, date_creation, id_categorie, id_user, statut, type_contenu, fichier, images, description)
                  VALUES (:nom_cours, :date_creation, :id_categorie, :id_user, :statut, :type_contenu, :fichier, :images, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_cours', $this->nom_cours);
        $stmt->bindParam(':date_creation', $this->date_creation);
        $stmt->bindParam(':id_categorie', $this->id_categorie);
        $stmt->bindParam(':id_user', $this->id_user);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':type_contenu', $this->type_contenu);
        $stmt->bindParam(':fichier', $this->fichier);
        $stmt->bindParam(':images', $this->images);
        $stmt->bindParam(':description', $this->description);

        return $stmt->execute();
    }

    public function getCours() {
        $query = "SELECT * FROM cours";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $cours = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['type_contenu'] == 'document') {
                $cours[] = new CoursDocument(
                    $this->conn, 
                    $row['id_cours'], 
                    $row['nom_cours'], 
                    $row['date_creation'], 
                    $row['id_categorie'], 
                    $row['id_user'], 
                    $row['statut'], 
                    $row['fichier'],
                    $row['images'],
                    $row['description']
                );
            } elseif ($row['type_contenu'] == 'video') {
                $cours[] = new CoursVideo(
                    $this->conn, 
                    $row['id_cours'], 
                    $row['nom_cours'], 
                    $row['date_creation'], 
                    $row['id_categorie'], 
                    $row['id_user'], 
                    $row['statut'], 
                    $row['fichier'],
                    $row['images'],
                    $row['description']
                );
            }
        }
        return $cours;
    }
}
class CoursDocument extends Cours {
    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, $images, $description) {
        parent::__construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, 'document', $images, $description);
    }

    public function ajouterContenu() {
        return "Ajout du cours document : " . $this->nom_cours . " avec le fichier disponible à l'URL : " . $this->fichier;
    }

    public function getCoursByCategorie($id_categorie) {
        $query = "SELECT * FROM cours WHERE id_categorie = :id_categorie AND type_contenu = 'document'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->execute();
        $cours = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cours[] = new CoursDocument(
                $this->conn, 
                $row['id_cours'], 
                $row['nom_cours'], 
                $row['date_creation'], 
                $row['id_categorie'], 
                $row['id_user'], 
                $row['statut'], 
                $row['fichier'],
                $row['images'],
                $row['description']
            );
        }
        return $cours;
    }
}

class CoursVideo extends Cours {
    public function __construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, $images, $description) {
        parent::__construct($db, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, 'video', $images, $description);
    }

    public function ajouterContenu() {
        return "Ajout du cours vidéo : " . $this->nom_cours . " avec le fichier disponible à l'URL : " . $this->fichier;
    }

    public function getCoursByCategorie($id_categorie) {
        $query = "SELECT * FROM cours WHERE id_categorie = :id_categorie AND type_contenu = 'video'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->execute();
        $cours = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cours[] = new CoursVideo(
                $this->conn, 
                $row['id_cours'], 
                $row['nom_cours'], 
                $row['date_creation'], 
                $row['id_categorie'], 
                $row['id_user'], 
                $row['statut'], 
                $row['fichier'],
                $row['images'],
                $row['description']
            );
        }
        return $cours;
    }
}
?>