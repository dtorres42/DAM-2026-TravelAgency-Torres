<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';

// Si no está logueado, no puede tener favoritos
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$user_id = $_SESSION['user_id'];
$viaje_id = $_GET['id'];

// 1. Miramos si ya lo tiene como favorito
$check = $db->prepare("SELECT * FROM favoritos WHERE id_usuario = ? AND id_viaje = ?");
$check->execute([$user_id, $viaje_id]);

if ($check->rowCount() > 0) {
    // 2. Si ya existe, lo eliminamos
    $del = $db->prepare("DELETE FROM favoritos WHERE id_usuario = ? AND id_viaje = ?");
    $del->execute([$user_id, $viaje_id]);
} else {
    // 3. Si no existe, lo insertamos
    $ins = $db->prepare("INSERT INTO favoritos (id_usuario, id_viaje) VALUES (?, ?)");
    $ins->execute([$user_id, $viaje_id]);
}

// Volvemos al index (Usamos ruta relativa simple ya que están en la misma carpeta)
header("Location: index.php");
exit();