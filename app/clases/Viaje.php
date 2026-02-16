<?php
class Viaje {
    private $conn;
    private $table_name = "viajes";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function leerTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_salida ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function leerUno($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_viaje = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ESTA ES LA FUNCIÓN QUE TE FALTA (Imagen b4c338.png)
    public function descontarPlaza($id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET plazas_disponibles = plazas_disponibles - 1 
                  WHERE id_viaje = :id AND plazas_disponibles > 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Retorna true si realmente se actualizó una fila
        }
        return false;
    }
}
?>