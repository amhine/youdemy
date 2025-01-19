<?php


class Utilisateur {
    protected $id_user;
    protected $nom_user;
    protected $email;
    protected $password;
    protected $id_role;
    protected $date_creation;
    protected $connect;
    protected $id_cours;
    protected $date_inscription;

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
    public function getDetails() {
        return [
            'id_user' => $this->id_user,
            'nom_user' => $this->nom_user,
            'email' => $this->email,
            'id_role' => $this->id_role
        ];
    }
}


class Etudiant extends Utilisateur {

    protected $connect;

    public function __construct($db, $id_user, $nom, $prenom, $email, $mot_de_passe, $role, $date_inscription, $id_cours) {
        parent::__construct($db, $id_user, $nom, $prenom, $email, $mot_de_passe, $role, $date_inscription);
        $this->connect = $db->getConnection();
    }

    public function voirCours() {
        $stmt = $this->connect->prepare("SELECT c.titre FROM cours c 
                                         INNER JOIN inscriptions i ON c.id_cours = i.id_cours
                                         WHERE i.id_etudiant = ?");
        $stmt->execute([$this->id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetails() {
        $details = parent::getDetails();
        $details['role'] = 'Étudiant';
        return $details;
    }

    public function inscrireAuCours($id_user, $id_cours) {
        try {
            $sql = "INSERT INTO inscription (id_user, id_cours) VALUES (:id_user, :id_cours)";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription : " . $e->getMessage());
            return false;
        }
    }
    public function estInscrit($id_etudiant, $id_cours) {
        $sql = "SELECT COUNT(*) FROM inscription WHERE id_user = :id_etudiant AND id_cours = :id_cours";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $stmt->bindParam(':id_cours', $id_cours, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}

class Enseignant extends Utilisateur {
    
    public function ajouterCours($titre, $description) {
        $stmt = $this->connect->prepare("INSERT INTO cours (titre, description, id_enseignant) 
                                         VALUES (?, ?, ?)");
        $stmt->execute([$titre, $description, $this->id_user]);
    }
    public function getDetails() {
        $details = parent::getDetails();
        $details['role'] = 'Enseignant';
        return $details;
    }
}



class Administrateur extends Utilisateur {
    public function gérerUtilisateur($id_utilisateur, $status) {
        $stmt = $this->connect->prepare("UPDATE utilisateur SET status = ? WHERE id_user = ?");
        $stmt->execute([$status, $id_utilisateur]);
    }
    public function getDetails() {
        $details = parent::getDetails();
        $details['role'] = 'admin';
        return $details;
    }
}


?>
