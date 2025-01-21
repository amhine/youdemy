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

    public function getiduser(){
        return $this->id_user;
    }

    public function setiduser($id_user){
        $this->id_user=$id_user;
    }

    public function getnomuser(){
        return $this->nom_user;
    }
    public function setnomuser($nom_user){
        $this->nom_user->$nom_user;
    }
    public function getemail(){
        return $this->email;
    }
    public function setemail($email){
    $this->email->$email;
    }

    public function getpassword(){
        return $this->password;
    }
    public function setpassword($password){
    $this->password->$password;
    }

    public function getidrole(){
        return $this->id_role;
    }
    public function setidrole($id_role){
    $this->id_role->$id_role;
    }

   
    public function signup($nom, $email, $password, $role, $status) {
        $email = $this->connect->prepare("SELECT id_user FROM utilisateur WHERE email = ?");
        $email->execute([$email]);
        
        if ($email->rowCount() > 0) {
            return "Cet email existe déjà";
        }

        if (strlen($password) < 6) {
            return "Le mot de passe doit contenir au moins 6 caractères";
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $date_creation = date('Y-m-d H:i:s');

        $role_query = $this->connect->prepare("SELECT id_role FROM role WHERE nom_role = ?");
        $role_query->execute([$role]);
        
        if ($role_query->rowCount() == 0) {
            return "Rôle non valide";
        }

        $role_id = $role_query->fetch(PDO::FETCH_ASSOC)['id_role'];

        if ($role === 'Enseignant') {
            $status = 'inactif';
        }

        try {
            $sql = "INSERT INTO utilisateur (nom_user, email, password, id_role, date_creation, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute([$nom, $email, $password_hash, $role_id, $date_creation, $status]);
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



  

     public function afficherUtilisateurs() {
        $utilisateursObjets = [];
        
        try {
            $sql = "SELECT u.id_user, u.nom_user, u.email, u.date_creation, r.nom_role 
                    FROM utilisateur u
                    INNER JOIN role r ON u.id_role = r.id_role
                    WHERE r.nom_role IN ('Étudiant', 'Enseignant')";
            $stmt = $this->connect->query($sql);
            $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($utilisateurs) {
                foreach ($utilisateurs as $utilisateur) {
                    switch ($utilisateur['nom_role']) {
                        case 'Étudiant':
                            $etudiant = new Etudiant(
                                $utilisateur['id_user'],
                                $utilisateur['nom_user'],
                                $utilisateur['email'],
                                null,
                                $this->getIdRoleByNom('Étudiant'),
                                $utilisateur['date_creation']
                            );
                            $utilisateursObjets[] = $etudiant;
                            break;
    
                        case 'Enseignant':
                            $enseignant = new Enseignant(
                                $utilisateur['id_user'],
                                $utilisateur['nom_user'],
                                $utilisateur['email'],
                                null, // password
                                $this->getIdRoleByNom('Enseignant'),
                                $utilisateur['date_creation']
                            );
                            $utilisateursObjets[] = $enseignant;
                            break;
                    }
                }
            }
    
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
        }
        
        return $utilisateursObjets;
    }

    private function getIdRoleByNom($nomRole) {
        $stmt = $this->connect->prepare("SELECT id_role FROM role WHERE nom_role = ?");
        $stmt->execute([$nomRole]);
        return $stmt->fetchColumn();
    }
    public function getStatus() {
        $stmt = $this->connect->prepare("SELECT status FROM utilisateur WHERE id_user = ?");
        $stmt->execute([$this->id_user]);
        return $stmt->fetchColumn();
    }
    

    public function countRole($roleName) {
        $sql = "SELECT COUNT(*) AS role_count 
                FROM utilisateur 
                JOIN role ON utilisateur.id_role = role.id_role 
                WHERE role.nom_role = :roleName AND role.nom_role != 'admin'";
    
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':roleName', $roleName, PDO::PARAM_STR); 
        $stmt->execute();
    
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['role_count']; 
        }
        return 0; 
    }
    
    
}


class Etudiant extends Utilisateur {

    protected $connect;

    public function __construct($id_user = null, $nom_user = null, $email = null, $password = null, $id_role = null, $date_creation = null) {
        parent::__construct($id_user, $nom_user, $email, $password, $id_role, $date_creation);
    }

    public function getDetails() {
        $details = parent::getDetails();
        $details['role'] = 'Étudiant';
        return $details;
    }

    public function voirCours() {
        $stmt = $this->connect->prepare("SELECT c.titre FROM cours c 
                                         INNER JOIN inscriptions i ON c.id_cours = i.id_cours
                                         WHERE i.id_etudiant = ?");
        $stmt->execute([$this->id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    public function __construct($id_user = null, $nom_user = null, $email = null, $password = null, $id_role = null, $date_creation = null) {
        parent::__construct($id_user, $nom_user, $email, $password, $id_role, $date_creation);
    }

   
    
    
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

    public function getTopEnseignants() {
        try {
            $sql = "SELECT u.nom_user, COUNT(c.id_cours) as nombre_cours 
                   FROM utilisateur u 
                   JOIN cours c ON u.id_user = c.id_user 
                   WHERE u.id_role = 3 
                   GROUP BY u.id_user, u.nom_user 
                   ORDER BY nombre_cours DESC 
                   LIMIT 3";
            $stmt = $this->connect->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des top enseignants: " . $e->getMessage());
            return [];
        }
    }
}



class Administrateur extends Utilisateur {

    public function __construct($id_user = null, $nom_user = null, $email = null, $password = null, $id_role = null, $date_creation = null) {
        parent::__construct($id_user, $nom_user, $email, $password, $id_role, $date_creation);
    }
   
    public function getDetails() {
        $details = parent::getDetails();
        $details['role'] = 'admin';
        return $details;
    }

    public function supprimerUtilisateur($id_utilisateur) {
        try {
            $stmt = $this->connect->prepare("DELETE FROM utilisateur WHERE id_user = ?");
            $stmt->execute([$id_utilisateur]);
            return true;
        } catch(PDOException $e) {
            error_log("Erreur lors de la suppression de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
    public function gérerUtilisateur($id_utilisateur, $status) {
        try {
            $stmt = $this->connect->prepare("UPDATE utilisateur SET status = ? WHERE id_user = ?");
            $stmt->execute([$status, $id_utilisateur]);
            return true;
        } catch(PDOException $e) {
            error_log("Erreur lors de la mise à jour du status : " . $e->getMessage());
            return false;
        }
}
}

?>
