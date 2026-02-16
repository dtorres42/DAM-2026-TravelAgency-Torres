<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :user LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verificación simple de contraseña
            if ($password === $row['password']) {
                return $row;
            }
        }
        return false;
    }
}
?>