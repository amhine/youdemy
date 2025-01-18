<?php
require_once("Connexion.php");
class CoursTag {
    private $connect;
    public $id_cours;
    public $id_tag;

    public function __construct($id_cours,$id_tag) {
        $this->id_cours = $id_cours;
        $this->id_tag=$id_tag;
        $this->connect = (new Connexion())->getConnection();
    }

    public function create() {
        if (!$this->id_cours || !$this->id_tag) {
            error_log("CoursTag::create - ID cours ou tag manquant");
            return false;
        }

        try {
            $query = "INSERT INTO courstag (id_cours, id_tag) VALUES (:id_cours, :id_tag)";
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(":id_cours", $this->id_cours, PDO::PARAM_INT);
            $stmt->bindParam(":id_tag", $this->id_tag, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            if (!$result) {
                error_log("Erreur SQL dans CoursTag::create: " . print_r($stmt->errorInfo(), true));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur PDO dans CoursTag::create: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function getTagsForCours($id_cours) {
        try {
            $query = "SELECT tag.id_tag, tag.nom_tag 
                      FROM tag 
                      JOIN courstag ON tag.id_tag = courstag.id_tag
                      WHERE courstag.id_cours = :id_cours";
            
            $stmt = $this->connect->prepare($query);
            $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT); 
            $stmt->execute();
    
            $tagsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $tags = [];
            foreach ($tagsData as $tagData) {
                $tags[] = new Tag($tagData['id_tag'], $tagData['nom_tag']);
            }
    
            return $tags; 
        } catch (PDOException $e) {
            error_log("Error retrieving tags for course: " . $e->getMessage());
            return []; 
        }
    }
            


    }
    

?>
