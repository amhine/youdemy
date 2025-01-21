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
    
    public function __construct($conn, $id_cours, $nom_cours, $date_creation, $id_categorie, $id_user, $statut, $fichier, $type_contenu, $images, $description) {
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
    public function setIdCours($id_cours) {
        $this->id_cours=$id_cours;
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

    abstract public function getfichier();

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
    public function setCategorie($id_categorie) {
        $this->id_categorie = $id_categorie;
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
        try {
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
            
            if ($stmt->execute()) {
                $this->id_cours = $this->conn->lastInsertId(); 
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la sauvegarde du cours : " . $e->getMessage());
            return false;
        }
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
    public function getCoursPaginated($limit = 9, $offset = 0, $search = '') {
        $query = "SELECT * FROM cours WHERE statut = 'Actif'";
        if (!empty($search)) {
            $query .= " AND nom_cours LIKE :search";
        }
        $query .= " LIMIT :limit OFFSET :offset";
    
        $stmt = $this->conn->prepare($query);
        if (!empty($search)) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
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
        public function countCours($search = '') {
            $query = "SELECT COUNT(*) as total FROM cours WHERE statut = 'Actif'";
            if (!empty($search)) {
                $query .= " AND nom_cours LIKE :search";
            }
    
            $stmt = $this->conn->prepare($query);
            if (!empty($search)) {
                $searchTerm = "%$search%";
                $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            }
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }
   


public static function getCoursById($pdo, $id_cours) {
    $sql = "SELECT * FROM cours WHERE id_cours = :id_cours";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if ($result['type_contenu'] === 'document') {
            return new CoursDocument(
                $pdo, 
                $result['id_cours'], 
                $result['nom_cours'], 
                $result['date_creation'], 
                $result['id_categorie'], 
                $result['id_user'], 
                $result['statut'], 
                $result['fichier'],
                $result['images'],
                $result['description']
            );
        } elseif ($result['type_contenu'] === 'video') {
            return new CoursVideo(
                $pdo, 
                $result['id_cours'], 
                $result['nom_cours'], 
                $result['date_creation'], 
                $result['id_categorie'], 
                $result['id_user'], 
                $result['statut'], 
                $result['fichier'],
                $result['images'],
                $result['description']
            );
        }
    }
    return null;
}
public function deletecours($id_cours) {
    $query = "DELETE FROM `cours` WHERE id_cours = $id_cours";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
}
public function modifier() {
    try {
        $query = "UPDATE cours 
                  SET nom_cours = :nom_cours, 
                      date_creation = :date_creation, 
                      id_categorie = :id_categorie, 
                      id_user = :id_user, 
                      statut = :statut, 
                      type_contenu = :type_contenu, 
                      fichier = :fichier, 
                      images = :images, 
                      description = :description
                  WHERE id_cours = :id_cours";
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
        $stmt->bindParam(':id_cours', $this->id_cours);
        
        if ($stmt->execute()) {
            return true;  
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        error_log("Erreur lors de la mise à jour du cours : " . $e->getMessage());
        return false;
    }
}
public function getEtudiantsInscrits() {
    $query = "SELECT u.nom_user 
              FROM utilisateur u
              JOIN inscription i ON u.id_user = i.id_user
              WHERE i.id_cours = :id_cours";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_cours', $this->id_cours);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getNombreEtudiantsInscrits() {
    $query = "SELECT COUNT(*) as nombre 
              FROM inscription 
              WHERE id_cours = :id_cours";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_cours', $this->id_cours);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'];
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
    public function getfichier() {
        echo "<iframe src='" . $this->fichier . "' width='900' height='700'></iframe>";

    }
    public function getCoursInscrits($idUser) {
        $query = "SELECT c.* FROM cours c 
                  JOIN inscription i ON c.id_cours = i.id_cours 
                  WHERE i.id_user = :id_user";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $idUser);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $cours = [];
        foreach ($results as $row) {
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
    public function modifier() {
        try {
            $query = "UPDATE cours 
                    SET nom_cours = :nom_cours,
                        id_categorie = :id_categorie,
                        type_contenu = :type_contenu,
                        fichier = :fichier,
                        images = :images,
                        description = :description
                    WHERE id_cours = :id_cours";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':nom_cours', $this->nom_cours);
            $stmt->bindParam(':id_categorie', $this->id_categorie);
            $stmt->bindParam(':type_contenu', $this->type_contenu);
            $stmt->bindParam(':fichier', $this->fichier);
            $stmt->bindParam(':images', $this->images);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id_cours', $this->id_cours);
            
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du cours : " . $e->getMessage());
            return false;
        }
    }
    public function updateTags($id_cours, $tags) {
        global $conn; 
        $sql = "DELETE FROM courstag WHERE id_cours = :id_cours";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_cours', $id_cours);
        $stmt->execute();
        foreach ($tags as $tag) {
            $sql = "SELECT id_tag FROM tag WHERE nom_tag = :nom_tag";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nom_tag', $tag);
            $stmt->execute();
            $existingTag = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($existingTag) {
                $id_tag = $existingTag['id_tag'];
            } else {
                $sql = "INSERT INTO tag (nom_tag) VALUES (:nom_tag)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nom_tag', $tag);
                $stmt->execute();
                $id_tag = $conn->lastInsertId();
            }

            $sql = "INSERT INTO courstag (id_cours, id_tag) VALUES (:id_cours, :id_tag)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_cours', $id_cours);
            $stmt->bindParam(':id_tag', $id_tag); 
            $stmt->execute();
        }
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
    public function getfichier() {
        echo "<iframe width='900' height='500' src='" . $this->fichier . "' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
    }
    
    public function getCoursInscrits($idUser) {
        $query = "SELECT c.* FROM cours c 
                  JOIN inscription i ON c.id_cours = i.id_cours 
                  WHERE i.id_user = :id_user";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $idUser);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $cours = [];
        foreach ($results as $row) {
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
    
    public function updateTags($id_cours, $tags) {
        $query = "DELETE FROM courstag WHERE id_cours = :id_cours";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_cours', $id_cours);
        $stmt->execute();
        
        foreach ($tags as $tag) {
            $query = "INSERT INTO courstag (id_cours, id_tag) VALUES (:id_cours, :id_tag)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cours', $id_cours);
            $stmt->bindParam(':id_tag', $tag);
            $stmt->execute();
        }
    }
 
    
}
?>










