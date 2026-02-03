<?php
session_start();
require_once '../clases/Database.php';

// 1. Verificar si el usuario esta logueado
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Debes iniciar sesion para reservar'); window.location='login.php';</script>";
    exit();
}

$database = new Database();
$db = $database->getConnection();

$id_viaje = $_GET['id'] ?? null;
$id_usuario = $_SESSION['user_id'];

if ($id_viaje) {
    // 2. Verificar si quedan plazas disponibles
    $query_check = "SELECT plazas_disponibles FROM viajes WHERE id_viaje = ?";
    $stmt_check = $db->prepare($query_check);
    $stmt_check->execute([$id_viaje]);
    $viaje = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($viaje && $viaje['plazas_disponibles'] > 0) {
        // 3. Iniciar transaccion para asegurar que los datos sean consistentes
        $db->beginTransaction();

        try {
            // Insertar la reserva
            $insert_reserva = "INSERT INTO reservas (id_usuario, id_viaje) VALUES (?, ?)";
            $stmt_reserva = $db->prepare($insert_reserva);
            $stmt_reserva->execute([$id_usuario, $id_viaje]);

            // Restar una plaza del viaje
            $update_plazas = "UPDATE viajes SET plazas_disponibles = plazas_disponibles - 1 WHERE id_viaje = ?";
            $stmt_update = $db->prepare($update_plazas);
            $stmt_update->execute([$id_viaje]);

            $db->commit();
            echo "<script>alert('Reserva realizada con exito'); window.location='mis_reservas.php';</script>";
        } catch (Exception $e) {
            $db->rollBack();
            echo "<script>alert('Error al procesar la reserva'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Lo sentimos, no quedan plazas disponibles'); window.location='index.php';</script>";
    }
}
?>