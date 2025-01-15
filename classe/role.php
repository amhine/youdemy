<?php 
require_once("Connexion.php");
class Role {
    private $id_role;
    private $nom_role;
    private $connect;

    public function __construct($id_role, $nom_role) {
        $this->id_role = $id_role;
        $this->nom_role=$nom_role;
        $this->connect = (new Connexion())->getConnection();
    }

    public function getRole(){

       
            try {
                $sql = "SELECT * FROM `role` WHERE nom_role NOT IN ('admin')";
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