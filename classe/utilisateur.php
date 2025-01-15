<?php
class Utilisateur {
    private $id_user;
    private $nom_user;
    private $email;
    private $password;
    private $id_role;
    private $date_creation;
    private $connect;

    // Constructeur
    public function __construct($id_user = null, $nom_user = null, $email = null, $password = null, $id_role = null, $date_creation = null) {
        $this->id_user = $id_user;
        $this->nom_user = $nom_user;
        $this->email = $email;
        $this->password = $password;
        $this->id_role = $id_role;
        $this->date_creation = $date_creation;
        $this->connect = (new Connexion())->getConnection();
    }

    
    
    public function signup($nom, $email, $password, $role) {
        $check_email = $this->connect->query("SELECT id_user FROM utilisateur WHERE email = '$email'");
        if ($check_email->rowCount() > 0) {
            return "Cet email existe déjà";
        }
    
        
        if (strlen($password) < 6) {
            return "Le mot de passe doit contenir au moins 6 caractères";
        }
    
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $date_creation = date('Y-m-d H:i:s');
    
        $role_query = $this->connect->query("SELECT id_role FROM role WHERE nom_role = '$role'");
        if ($role_query->rowCount() == 0) {
            return "Rôle non valide";
        }
    
        $role_id = $role_query->fetch(PDO::FETCH_ASSOC)['id_role'];
    
        try {
            $sql = "INSERT INTO utilisateur (nom_user, email, password, id_role, date_creation) 
                    VALUES ('$nom', '$email', '$password_hash', '$role_id', '$date_creation')";
    
            $this->connect->exec($sql); 
    
            return "Inscription réussie";
        } catch(PDOException $e) {
            return "Erreur lors de l'inscription: " . $e->getMessage();
        }
    }
    
    public function connexion($email, $password) {
        try {
            $sql = "SELECT * FROM utilisateur WHERE email = '$email'";
            $result = $this->connect->query($sql);

            if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['id_user'] = $row['id_user'];
                    $_SESSION['id_role'] = $row['id_role'];
                    $_SESSION['nom_user'] = $row['nom_user'];
                    return "Connexion réussie";
                } else {
                    return "Mot de passe incorrect";
                }
            } else {
                return "Email non trouvé";
            }
        } catch(PDOException $e) {
            return "Erreur lors de la connexion: " . $e->getMessage();
        }
    }
}
?>
