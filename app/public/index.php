<?php
session_start();
require_once '../clases/Database.php';
require_once '../clases/Viaje.php';

// 1. Conexión y Modelo
$database = new Database();
$db = $database->getConnection();
$viajeModel = new Viaje($db);

// 2. Obtener los viajes
$stmt = $viajeModel->leerTodos();

// 3. Incluir cabecera y navegación
include '../vistas/header.php';
include '../vistas/nav.php';
?>

<main class="contenedor-principal" style="min-height: 80vh; padding-bottom: 50px;">
    
    <section class="hero" style="text-align: center; padding: 50px 20px; background: #f4f4f4; margin-bottom: 30px;">
        <h1>Explora el Tiempo con NeoHorizon</h1>
        <p>Selecciona tu destino histórico y reserva tu aventura hoy mismo.</p>
    </section>

    <section id="destinos" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <h2 style="margin-bottom: 30px; border-bottom: 2px solid #007bff; display: inline-block;">Nuestros Destinos</h2>
        
        <div class="grid-viajes" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
            
            <?php while ($viaje = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="viaje-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: 1px solid #ddd;">
                    
                    <div style="height: 200px; overflow: hidden;">
                        <img src="../assets/img/<?php echo htmlspecialchars($viaje['imagen']); ?>" 
                             alt="<?php echo htmlspecialchars($viaje['destino']); ?>"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($viaje['destino']); ?></h3>
                        <p style="color: #666; font-size: 0.9em; height: 60px; overflow: hidden;">
                            <?php echo htmlspecialchars($viaje['descripcion']); ?>
                        </p>
                        
                        <div style="margin: 15px 0; font-weight: bold; color: #007bff;">
                            Precio: <?php echo number_format($viaje['precio'], 2); ?>€
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.8em; color: #888;">
                                Plazas: <?php echo $viaje['plazas_disponibles']; ?>
                            </span>
                            <a href="detalle_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                               style="background: #333; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 0.9em;">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </section>
</main>

<?php 
// 4. Pie de página (Aquí es donde están tus enlaces que no funcionaban)
include '../vistas/footer.php'; 
?>