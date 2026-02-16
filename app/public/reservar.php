<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';
require_once __DIR__ . '/../clases/Viaje.php';

// Seguridad: Si no está logueado, al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=auth");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$viajeModel = new Viaje($db);

$id_viaje = isset($_GET['id']) ? $_GET['id'] : null;
$id_usuario = $_SESSION['user_id'];

if (!$id_viaje) {
    header("Location: index.php");
    exit();
}

// 1. Intentamos descontar la plaza en la tabla 'viajes'
if ($viajeModel->descontarPlaza($id_viaje)) {
    
    // 2. Insertamos el registro en la tabla 'reservas'
    $query = "INSERT INTO reservas (id_usuario, id_viaje) VALUES (:user, :viaje)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user', $id_usuario);
    $stmt->bindParam(':viaje', $id_viaje);
    
    if ($stmt->execute()) {
        // Éxito: Vamos a la carpeta usuario
        header("Location: usuario/mis_reservas.php?status=success");
    } else {
        // Si falla la inserción, algo va mal con la tabla reservas
        header("Location: detalle_viaje.php?id=$id_viaje&error=db");
    }
} else {
    // Si no hay plazas disponibles
    header("Location: detalle_viaje.php?id=$id_viaje&error=no_plazas");
}
exit();