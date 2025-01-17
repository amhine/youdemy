
<?php
class Connexion {
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "youdemy";
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->conn;
    }
}
?>

<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct($dsn, $username, $password) {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    public static function getInstance($dsn = null, $username = null, $password = null) {
        if (self::$instance === null) {
            $dsn = $dsn ?? 'mysql:host=localhost;dbname=youdemy';
            $username = $username ?? 'root';
            $password = $password ?? '';
            self::$instance = new Database($dsn, $username, $password);
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
