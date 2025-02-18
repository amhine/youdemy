
<?php
require_once("Connexion.php");

class Categorie {

    private $id_categorie;
    private $nom_categorie;
    private $description;
    private $connect;

    public function __construct($nom_categorie = null, $description = null, $id_categorie = null) {
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
        $this->description = $description;
        $this->connect = (new Connexion())->getConnection();
    }

    public function getNom() {
        return $this->nom_categorie;  
    }
    
    public function setNom($nom_categorie) {
        $this->nom_categorie = $nom_categorie;  
    }

    public function getDescription() {
        return $this->description;  
    }
    
    public function setDescription($description) {
        $this->description = $description;  
    }

    public function getIdCategorie() {
        return $this->id_categorie;
    }

    public function getCategories() {
        try {
            $sql = "SELECT * FROM categorie";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $categorieObjects = [];
            foreach ($categories as $categorie) {
                $categorieObjects[] = new Categorie($categorie['nom_categorie'], $categorie['description'], $categorie['id_categorie']);
            }
            return $categorieObjects;
        } catch (PDOException $e) {
            echo "Error retrieving categories: " . $e->getMessage();
            return [];
        }
    }
    

    public function ajouterCategorie($nom_categorie, $description) {
        try {
            if ($nom_categorie && $description) {
                $sql = "INSERT INTO categorie (nom_categorie, description) VALUES (:nom_categorie, :description)";
                $stmt = $this->connect->prepare($sql);
                $stmt->bindParam(':nom_categorie', $nom_categorie);
                $stmt->bindParam(':description', $description);
    
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return "Catégorie ajoutée avec succès.";
                } else {
                    return "Aucune catégorie ajoutée.";
                }
            } else {
                return "Nom et description sont requis.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
            return "Une erreur est survenue lors de l'ajout de la catégorie.";
        }
    }

    public function supprimerCategorie($id_categorie) {
        try {
            if ($id_categorie) {
                $sql = "DELETE FROM categorie WHERE id_categorie = :id_categorie";
                $stmt = $this->connect->prepare($sql);
                $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
    
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return "Catégorie supprimée avec succès.";
                } else {
                    return "Aucune catégorie trouvée à supprimer.";
                }
            } else {
                return "L'ID de la catégorie est requis.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
            return "Une erreur est survenue lors de la suppression de la catégorie.";
        }
    }
   
   
    public function updateCategorie($id_categorie, $nom_categorie, $description) {
        try {
            $sql =  "UPDATE categorie 
            SET nom_categorie = :nom_categorie, 
                description = :description 
            WHERE id_categorie = :id_categorie";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':id_categorie', $id_categorie);
            $stmt->bindParam(':nom_categorie', $nom_categorie);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating category: " . $e->getMessage();
        }
    }
    public function getCategorieById($id_categorie) {
        try {
            $sql = "SELECT * FROM categorie WHERE id_categorie = :id_categorie";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':id_categorie', $id_categorie);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error retrieving category by ID: " . $e->getMessage();
            return null;
        }
    }

    
}
?>