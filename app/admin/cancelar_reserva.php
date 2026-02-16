<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: mis_reservas.php");
    exit();
}

$db = (new Database())->getConnection();
$id_reserva = $_GET['id'];
$id_usuario = $_SESSION['user_id'];

// 1. Buscamos el ID del viaje antes de borrar la reserva
$query_viaje = "SELECT id_viaje FROM reservas WHERE id_reserva = :reserva AND id_usuario = :user";
$stmt_viaje = $db->prepare($query_viaje);
$stmt_viaje->execute([':reserva' => $id_reserva, ':user' => $id_usuario]);
$reserva = $stmt_viaje->fetch(PDO::FETCH_ASSOC);

if ($reserva) {
    $id_viaje = $reserva['id_viaje'];

    // 2. Borramos la reserva de la tabla
    $delete = "DELETE FROM reservas WHERE id_reserva = :reserva";
    $stmt_del = $db->prepare($delete);
    
    if ($stmt_del->execute([':reserva' => $id_reserva])) {
        // 3. Devolvemos la plaza usando el nombre correcto: plazas_disponibles
        $update = "UPDATE viajes SET plazas_disponibles = plazas_disponibles + 1 WHERE id_viaje = :viaje";
        $stmt_up = $db->prepare($update);
        $stmt_up->execute([':viaje' => $id_viaje]);
    }
}

header("Location: ../public/index.php?mensaje=cancelado");
exit();