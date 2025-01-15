<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "youdemy";
    public $connect;

    public function __construct() {
        try {
            $this->connect = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection échouée: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->connect;
    }

    public function query($sql) {
        return $this->connect->query($sql);
    }

    public function prepare($sql) {
        return $this->connect->prepare($sql);
    }
}
?>
