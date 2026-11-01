<?php
class User {

    use Validasi;

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function daftar($nama, $email, $password) {
        $this->wajibDiisi($nama, "Nama");
        $this->emailValid($email);

        if (strlen($password) < 6) {
            throw new Exception("Password minimal 6 karakter.");
        }

        try {
            $stmt = $this->db->prepare(
                "INSERT INTO users (name, email, password, role)
                VALUES (?, ?, ?, 'user')"
            );
            $stmt->execute([$nama, $email,
                            password_hash($password, PASSWORD_DEFAULT)]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new Exception("Email sudah digunakan.");
            }
            throw $e;
        }
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare(
            "SELECT id, name, email, password, role FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, $u["password"])) {
            return [
                "id_user" => $u["id"],
                "nama"    => $u["name"],
                "email"   => $u["email"],
                "role"    => $u["role"]
            ];
        }
        return false;
    }
}
?>