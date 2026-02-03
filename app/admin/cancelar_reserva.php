<?php
session_start();
require_once '../clases/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$id_viaje = $_GET['id_viaje'] ?? null;
$id_usuario = $_SESSION['user_id'];

if ($id_viaje) {
    $db->beginTransaction();
    try {
        // 1. Eliminar la reserva del usuario
        $query_del = "DELETE FROM reservas WHERE id_usuario = ? AND id_viaje = ? LIMIT 1";
        $stmt_del = $db->prepare($query_del);
        $stmt_del->execute([$id_usuario, $id_viaje]);

        // 2. Devolver la plaza al contador de viajes
        $query_upd = "UPDATE viajes SET plazas_disponibles = plazas_disponibles + 1 WHERE id_viaje = ?";
        $stmt_upd = $db->prepare($query_upd);
        $stmt_upd->execute([$id_viaje]);

        $db->commit();
        echo "<script>alert('Reserva cancelada correctamente'); window.location='mis_reservas.php';</script>";
    } catch (Exception $e) {
        $db->rollBack();
        echo "<script>alert('Error al cancelar la reserva'); window.location='mis_reservas.php';</script>";
    }
}
?>