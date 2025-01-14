<?php
class Categorie {
    private $connect;

    public function __construct($dbConnection) {
        $this->connect = $dbConnection;
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
