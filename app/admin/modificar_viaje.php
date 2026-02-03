<?php
session_start();

// Seguridad: Solo el administrador puede acceder
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once '../clases/Database.php';
include '../vistas/header.php';
include '../vistas/nav.php';

$database = new Database();
$db = $database->getConnection();

// 1. Obtener los datos actuales del viaje
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM viajes WHERE id_viaje = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $viaje = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$viaje) {
        die("Viaje no encontrado.");
    }
}

// 2. Procesar la actualizacion
if ($_POST) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $itinerario = $_POST['itinerario'];
    $fecha = $_POST['fecha_salida'];
    $precio = $_POST['precio'];
    $plazas = $_POST['plazas_disponibles'];
    $tipo = $_POST['tipo_viaje'];
    $id_viaje = $_POST['id_viaje'];

    // Si el administrador no sube una imagen nueva, mantenemos la anterior
    $nombre_imagen = $viaje['imagen']; 
    if (!empty($_FILES['imagen']['name'])) {
        $nombre_imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../assets/img/" . $nombre_imagen);
    }

    $sql = "UPDATE viajes SET titulo=?, descripcion=?, itinerario=?, fecha_salida=?, precio=?, plazas_disponibles=?, tipo_viaje=?, imagen=? WHERE id_viaje=?";
    $update = $db->prepare($sql);
    
    if ($update->execute([$titulo, $descripcion, $itinerario, $fecha, $precio, $plazas, $tipo, $nombre_imagen, $id_viaje])) {
        echo "<script>alert('Cambios guardados correctamente'); window.location='index.php';</script>";
    }
}
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 800px;">
    <h2>Modificar informacion del viaje</h2>
    
    <form method="POST" enctype="multipart/form-data" class="buscador-form" style="flex-direction: column; align-items: stretch;">
        <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje']; ?>">

        <div class="input-group">
            <label>Titulo del Viaje</label>
            <input type="text" name="titulo" value="<?php echo $viaje['titulo']; ?>" required>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="input-group">
                <label>Precio (euros)</label>
                <input type="number" name="precio" value="<?php echo $viaje['precio']; ?>" required>
            </div>
            <div class="input-group">
                <label>Fecha de Salida</label>
                <input type="date" name="fecha_salida" value="<?php echo $viaje['fecha_salida']; ?>" required>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="input-group">
                <label>Plazas Disponibles</label>
                <input type="number" name="plazas_disponibles" value="<?php echo $viaje['plazas_disponibles']; ?>" required>
            </div>
            <div class="input-group">
                <label>Tipo de Viaje</label>
                <select name="tipo_viaje">
                    <option value="aventura" <?php if($viaje['tipo_viaje'] == 'aventura') echo 'selected'; ?>>Aventura</option>
                    <option value="relax" <?php if($viaje['tipo_viaje'] == 'relax') echo 'selected'; ?>>Relax</option>
                    <option value="cultural" <?php if($viaje['tipo_viaje'] == 'cultural') echo 'selected'; ?>>Cultural</option>
                </select>
            </div>
        </div>

        <div class="input-group">
            <label>Descripcion resumida</label>
            <textarea name="descripcion" rows="2" required><?php echo $viaje['descripcion']; ?></textarea>
        </div>

        <div class="input-group">
            <label>Itinerario completo</label>
            <textarea name="itinerario" rows="8" required><?php echo $viaje['itinerario']; ?></textarea>
        </div>

        <div class="input-group">
            <label>Imagen actual: <?php echo $viaje['imagen']; ?></label>
            <input type="file" name="imagen" accept="image/*">
            <small>Dejar vacio para mantener la imagen actual</small>
        </div>

        <button type="submit" class="btn-buscar" style="margin-top: 20px;">ACTUALIZAR DATOS</button>
        <a href="index.php" style="text-align: center; margin-top: 10px; color: #666; text-decoration: none;">Cancelar y volver</a>
    </form>
</section>

<?php include '../vistas/footer.php'; ?>