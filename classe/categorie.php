<?php
require_once("Connexion.php");

// class Categorie {

//     private $id_categorie;
//     private $nom_categorie;
//     private $description;
//     private $connect;
//     public function __construct($nom_categorie, $description, $id_categorie = null) {
//         $this->id_categorie = $id_categorie;
//         $this->nom_categorie = $nom_categorie;
//         $this->description = $description;
//         $this->connect = (new Connexion())->getConnection();
//     }

//     public function getIdCategorie() {
//         return $this->id_categorie;
//     }

    
//     public function getNomCategorie() {
//         return $this->nom_categorie;
//     }

    
//     public function getDescription() {
//         return $this->description;
//     }

    
//     public function getCategories() {
//         try {
//             $sql = "SELECT * FROM categorie";
//             $stmt = $this->connect->prepare($sql);
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             echo "Error retrieving categories: " . $e->getMessage();
//             return [];
//         }
//     }

   
//     public function addCategory() {
//         try {
//             // Insérer les valeurs directement dans la requête SQL
//             $sql = "INSERT INTO categorie (nom_categorie, description) 
//                     VALUES ('$this->nom_categorie', '$this->description')";
//             $stmt = $this->connect->prepare($sql);
//             $stmt->execute();
//         } catch (PDOException $e) {
//             echo "Error adding category: " . $e->getMessage();
//         }
//     }
// }
class Categorie {

    private $id_categorie;
    private $nom_categorie;
    private $description;
    private $connect;

    // Constructeur
    public function __construct($nom_categorie, $description, $id_categorie = null) {
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
        $this->description = $description;
        $this->connect = (new Connexion())->getConnection();
    }

    public function getCategories() {
        try {
            $sql = "SELECT * FROM categorie";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error retrieving categories: " . $e->getMessage();
            return [];
        }
    }
}

?>
