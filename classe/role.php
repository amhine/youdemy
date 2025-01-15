<?php 
class Role {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function getRole(){

       
            try {
                $sql = "SELECT * FROM `role` WHERE nom_role NOT IN ('admin')";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error retrieving categories: " . $e->getMessage();
                return [];
            }
        
    }
}
?>