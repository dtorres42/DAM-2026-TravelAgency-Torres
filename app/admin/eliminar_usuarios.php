<?php
session_start();
require_once '../clases/Database.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    exit("Acceso denegado");
}

$id = $_GET['id'] ?? null;

if ($id && $id != $_SESSION['user_id']) { // Evitar que el admin se borre a sí mismo
    $database = new Database();
    $db = $database->getConnection();
    
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
}

header("Location: usuarios.php");
exit();