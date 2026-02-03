<?php
session_start();
// Seguridad: Solo el admin puede entrar aquí
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once '../clases/Database.php';
include '../vistas/header.php';
include '../vistas/nav.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    // Recoger datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $itinerario = $_POST['itinerario'];
    $fecha = $_POST['fecha_salida'];
    $precio = $_POST['precio'];
    $plazas = $_POST['plazas_disponibles'];
    $tipo = $_POST['tipo_viaje'];

    // Gestión de la imagen
    $nombre_imagen = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $destino_final = "../assets/img/" . $nombre_imagen;

    // Subir archivo físicamente a la carpeta assets/img/
    if (move_uploaded_file($ruta_temporal, $destino_final)) {
        // Guardar en la base de datos
        $query = "INSERT INTO viajes (titulo, descripcion, itinerario, fecha_salida, precio, plazas_disponibles, tipo_viaje, imagen) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([$titulo, $descripcion, $itinerario, $fecha, $precio, $plazas, $tipo, $nombre_imagen])) {
            echo "<script>alert('Viaje añadido con éxito'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen');</script>";
    }
}
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 800px;">
    <h2>Añadir Nuevo Destino <span class="highlight">NeoHorizon</span></h2>
    
    <form method="POST" enctype="multipart/form-data" class="buscador-form" style="flex-direction: column; align-items: stretch;">
        
        <div class="input-group">
            <label>Título del Viaje</label>
            <input type="text" name="titulo" placeholder="Ej: Marte Express" required>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="input-group">
                <label>Precio (€)</label>
                <input type="number" name="precio" placeholder="0.00" required>
            </div>
            <div class="input-group">
                <label>Fecha de Salida</label>
                <input type="date" name="fecha_salida" required>
            </div>
        </div>

        <div style="display: flex; gap: 15px;">
            <div class="input-group">
                <label>Plazas</label>
                <input type="number" name="plazas_disponibles" required>
            </div>
            <div class="input-group">
                <label>Tipo</label>
                <select name="tipo_viaje">
                    <option value="aventura">Aventura</option>
                    <option value="relax">Relax</option>
                    <option value="cultural">Cultural</option>
                </select>
            </div>
        </div>

        <div class="input-group">
            <label>Descripción Corta (para la tarjeta)</label>
            <textarea name="descripcion" rows="2" required></textarea>
        </div>

        <div class="input-group">
            <label>Itinerario Completo</label>
            <textarea name="itinerario" rows="5" required></textarea>
        </div>

        <div class="input-group">
            <label>Imagen del Viaje</label>
            <input type="file" name="imagen" accept="image/*" required>
        </div>

        <button type="submit" class="btn-buscar" style="margin-top: 20px;">PUBLICAR VIAJE</button>
    </form>
</section>

<?php include '../vistas/footer.php'; ?>