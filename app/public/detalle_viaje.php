<?php
session_start();
require_once '../clases/Database.php';

// 1. Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// 2. Obtener el ID de la URL y buscar el viaje
$id_viaje = $_GET['id'] ?? 0;

$query = "SELECT * FROM viajes WHERE id_viaje = :id LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id_viaje);
$stmt->execute();
$viaje = $stmt->fetch(PDO::FETCH_ASSOC);

// 3. Si el viaje no existe, mostramos el Error 404
if (!$viaje) {
    http_response_code(404);
    include '../vistas/header.php';
    include '../vistas/nav.php';
    include '../vistas/error404.php'; // Aquí cargamos error404.php
    include '../vistas/footer.php';
    exit();
}

// 4. Si existe, mostramos la página normal
include '../vistas/header.php';
include '../vistas/nav.php';
?>

<main class="detalle-container">
    <div class="detalle-card">
        
        <div class="viaje-imagen">
            <img src="../assets/img/<?php echo htmlspecialchars($viaje['imagen']); ?>" 
                 alt="<?php echo htmlspecialchars($viaje['destino']); ?>">
        </div>

        <div class="viaje-info">
            <h1><?php echo htmlspecialchars($viaje['destino']); ?></h1>
            <p class="descripcion">
                <?php echo nl2br(htmlspecialchars($viaje['descripcion'])); ?>
            </p>
            
            <div class="datos-clave">
                <p><strong>Precio:</strong> <?php echo number_format($viaje['precio'], 2); ?>€</p>
                <p><strong>Plazas disponibles:</strong> <?php echo $viaje['plazas_disponibles']; ?></p>
                <p><strong>Fecha de salida:</strong> <?php echo date('d/m/Y', strtotime($viaje['fecha_salida'])); ?></p>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($viaje['plazas_disponibles'] > 0): ?>
                    <form action="reservar.php" method="POST">
                        <input type="hidden" name="id_viaje" value="<?php echo $viaje['id_viaje']; ?>">
                        <button type="submit" class="btn-reserva">Reservar ahora</button>
                    </form>
                <?php else: ?>
                    <button disabled class="btn-agotado">Agotado</button>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn-reserva login-link">Inicia sesión para reservar</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="volver-link">
        <a href="index.php">&larr; Volver a los destinos</a>
    </div>
</main>

<?php include '../vistas/footer.php'; ?>