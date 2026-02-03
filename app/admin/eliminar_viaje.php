<?php
session_start();

// 1. Seguridad: Solo el administrador puede ejecutar borrados
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

require_once '../clases/Database.php';

// 2. Verificar que recibimos un ID válido por la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];

    // 3. Ejecutar la eliminación usando sentencias preparadas (seguridad PDO)
    $query = "DELETE FROM viajes WHERE id_viaje = ?";
    $stmt = $db->prepare($query);

    if ($stmt->execute([$id])) {
        // Redirigir a la home con un mensaje de éxito
        echo "<script>alert('Viaje eliminado correctamente'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error al intentar eliminar el viaje'); window.location='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
exit();
?>