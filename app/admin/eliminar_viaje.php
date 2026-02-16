<?php
session_start();

// 1. Verificación de seguridad: Solo administradores
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}

// 2. Comprobar que recibimos un ID por la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../public/index.php?error=id_no_valido");
    exit();
}

require_once __DIR__ . '/../clases/Database.php';

try {
    $db = (new Database())->getConnection();
    $id_viaje = $_GET['id'];

    // 3. Obtener el nombre de la imagen para borrar el archivo del servidor
    $query_img = "SELECT imagen FROM viajes WHERE id_viaje = :id";
    $stmt_img = $db->prepare($query_img);
    $stmt_img->execute([':id' => $id_viaje]);
    $viaje = $stmt_img->fetch(PDO::FETCH_ASSOC);

    if ($viaje) {
        // Borrar el archivo físico de la carpeta assets/img si existe
        $ruta_imagen = __DIR__ . "/../assets/img/" . $viaje['imagen'];
        if (!empty($viaje['imagen']) && file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }

        // 4. Borrar el registro de la base de datos
        $sql = "DELETE FROM viajes WHERE id_viaje = :id";
        $stmt = $db->prepare($sql);
        
        if ($stmt->execute([':id' => $id_viaje])) {
            // Éxito: Redirigir a la página principal con mensaje
            header("Location: ../public/index.php?mensaje=eliminado");
            exit();
        }
    } else {
        header("Location: ../public/index.php?error=no_existe");
        exit();
    }

} catch (PDOException $e) {
    // Si hay un error de base de datos (ej. restricciones de clave foránea)
    header("Location: ../public/index.php?error=error_db");
    exit();
}