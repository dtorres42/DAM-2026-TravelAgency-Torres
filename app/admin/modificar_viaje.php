<?php
session_start();
require_once '../clases/Database.php';

// Verificación de seguridad
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /ProyectoViajes/app/public/index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

if (!isset($_GET['id'])) {
    header("Location: /ProyectoViajes/app/public/index.php");
    exit();
}
$id = $_GET['id'];

// 1. Cargar los datos actuales para saber qué imagen tiene ahora
$stmt = $db->prepare("SELECT * FROM viajes WHERE id_viaje = ?");
$stmt->execute([$id]);
$v = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen_nombre = $v['imagen']; // Por defecto dejamos la que ya tiene

    // Comprobar si el usuario ha subido una nueva imagen
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === 0) {
        $nombre_archivo = $_FILES['nueva_imagen']['name'];
        $ruta_destino = "../../assets/img/" . $nombre_archivo; // Ajusta según tu estructura

        if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_destino)) {
            $imagen_nombre = $nombre_archivo; // Si se subió bien, actualizamos el nombre para la DB
        }
    }

    // Actualizamos la tabla con la nueva imagen (o la antigua si no cambió)
    $sql = "UPDATE viajes SET titulo = ?, descripcion = ?, precio = ?, imagen = ? WHERE id_viaje = ?";
    $stmt = $db->prepare($sql);
    
    if ($stmt->execute([$titulo, $descripcion, $precio, $imagen_nombre, $id])) {
        header("Location: /ProyectoViajes/app/public/index.php?mensaje=editado");
        exit();
    } else {
        echo "Error al actualizar.";
    }
}

include '../vistas/header.php';
include '../vistas/nav.php';
?>

<main style="padding: 50px; background: #f4f4f4; min-height: 80vh;">
    <section style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; color: #333;">️ Editar Destino</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <label>Título del Viaje:</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($v['titulo']); ?>" required 
                   style="width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 6px;">

            <label>Descripción:</label>
            <textarea name="descripcion" required 
                      style="width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 6px; height: 100px;"><?php echo htmlspecialchars($v['descripcion']); ?></textarea>

            <label>Precio (€):</label>
            <input type="number" name="precio" value="<?php echo $v['precio']; ?>" required 
                   style="width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 6px;">

            <label>Imagen Actual:</label><br>
            <img src="../../assets/img/<?php echo $v['imagen']; ?>" style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
            <br>
            <label>Cambiar imagen (opcional):</label>
            <input type="file" name="nueva_imagen" style="width: 100%; margin: 10px 0 20px 0;">

            <button type="submit" 
                    style="width: 100%; background: #007bff; color: white; padding: 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Guardar Cambios
            </button>
            
            <a href="/ProyectoViajes/app/public/index.php" 
               style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">
               Cancelar
            </a>
        </form>
    </section>
</main>

<?php include '../vistas/footer.php'; ?>