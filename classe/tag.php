<?php

class Tag {
    private $connect;  
    private $id_tag;
    private $nom_tag;

    public function __construct($id_tag,$nom_tag) {
        $this->id_tag=$id_tag;
        $this->nom_tag=$nom_tag;
        
        $this->connect = (new Connexion())->getConnection();
    }

    public function getNomTag() {
        return $this->nom_tag;
    }

    public function getIdTag() {
        return $this->id_tag;
    }

    public function setIdTag($id_tag) {
        $this->id_tag = $id_tag;
    }


    public function setNomTag($nom_tag) {
        $this->nom_tag = $nom_tag;
    }

    public function addTag($nom_tag) {
        $query = "INSERT INTO tag (nom_tag) VALUES (:nom_tag)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nom_tag', $nom_tag);

        // Si l'insertion réussit, on retourne l'ID du tag ajouté
        if ($stmt->execute()) {
            return $this->connect->lastInsertId();
        }

        return false;
    }

    public function getAllTags() {
        $query = "SELECT * FROM tag";
        $stmt = $this->connect->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTags() {
        try {
            $sql = "SELECT * FROM tag";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tagObjects = [];
            foreach ($tags as $tag) {
                $tagObjects[] = new tag($tag['nom_tag'],  $tag['id_tag']);
            }
            return $tagObjects;
        } catch (PDOException $e) {
            echo "Error retrieving tags: " . $e->getMessage();
            return [];
        }
    }
   

    public function getTagById($id_tag) {
        $query = "SELECT * FROM tag WHERE id_tag = :id_tag";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id_tag', $id_tag, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getTagBynom($nom_tag) {
        $query = "SELECT * FROM tag WHERE nom_tag = :nom_tag";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':nom_tag', $nom_tag, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

   public function getTagsByCours($id_cours) {
    $query = "SELECT tag.nom_tag FROM tag 
              JOIN courstag ON tag.id_tag = courstag.id_tag
              WHERE courstag.id_cours = :id_cours";
    $stmt = $this->connect->prepare($query);
    $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
    $stmt->execute();

    $tags = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Créez un objet Tag pour chaque ligne de résultat
        $tag = new Tag($this->connect, $row['nom_tag']);
        $tags[] = $tag;
    }

    return $tags;
}
    public function addTagToCours($id_cours, $id_tag) {
        $query = "INSERT INTO courstag (id_cours, id_tag) VALUES (:id_cours, :id_tag)";
        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
        $stmt->bindParam(':id_tag', $id_tag, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>


