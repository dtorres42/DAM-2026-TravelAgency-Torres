<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';
require_once __DIR__ . '/../clases/Viaje.php';

$database = new Database();
$db = $database->getConnection();
$viajeModel = new Viaje($db);

// Obtenemos el ID de la URL
$id = isset($_GET['id']) ? $_GET['id'] : die("Error: ID no encontrado.");
$viaje = $viajeModel->leerUno($id);

// Si el viaje no existe en la DB
if (!$viaje) {
    die("El viaje solicitado no existe.");
}

include __DIR__ . '/../vistas/header.php';
include __DIR__ . '/../vistas/nav.php';
?>

<main style="max-width: 900px; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; shadow: 0 4px 10px rgba(0,0,0,0.1); font-family: sans-serif;">
    
    <h1 style="color: #333;"><?php echo htmlspecialchars($viaje['titulo']); ?></h1>
    
    <img src="../assets/img/<?php echo htmlspecialchars($viaje['imagen'] ?? 'default.jpg'); ?>" 
         style="width: 100%; max-height: 450px; object-fit: cover; border-radius: 8px; margin: 20px 0;">

    <div style="line-height: 1.6; color: #555; font-size: 1.1rem;">
        <h3>Descripción del viaje</h3>
        <p><?php echo htmlspecialchars($viaje['descripcion']); ?></p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        
        <p><b>Precio:</b> <?php echo number_format($viaje['precio'], 2); ?>€</p>
        <p><b>Plazas disponibles:</b> <?php echo htmlspecialchars($viaje['plazas_disponibles']); ?></p>
        <p><b>Fecha de salida:</b> <?php echo htmlspecialchars($viaje['fecha_salida']); ?></p>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="index.php" style="background: #666; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-right: 10px;">Volver</a>
        <a href="reservar.php?id=<?php echo $viaje['id_viaje']; ?>" style="background: #28a745; color: white; padding: 10px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">¡Reservar Ahora!</a>
    </div>

</main>

<?php include __DIR__ . '/../vistas/footer.php'; ?>