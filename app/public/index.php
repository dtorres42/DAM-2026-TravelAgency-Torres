<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';
require_once __DIR__ . '/../clases/Viaje.php';

$db = (new Database())->getConnection();
$viajeModel = new Viaje($db);
$stmt = $viajeModel->leerTodos();

include __DIR__ . '/../vistas/header.php';
include __DIR__ . '/../vistas/nav.php';
?>

<main style="padding: 20px; background: #f4f4f4; font-family: sans-serif;">
    <h1 style="text-align: center;">Explora el Tiempo con NeoHorizon</h1>

    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <div style="max-width: 1200px; margin: 20px auto; text-align: right;">
            <a href="../admin/insertar_viaje.php" 
               style="background: #28a745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                + Nuevo Viaje
            </a>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; max-width: 1200px; margin: 0 auto;">

        <?php while ($viaje = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

                <img src="../assets/img/<?php echo $viaje['imagen']; ?>" style="width: 100%; height: 200px; object-fit: cover;">

                <div style="padding: 15px;">
                    <h3><?php echo $viaje['titulo']; ?></h3>
                    <p style="color: #666; height: 50px;     overflow: hidden;"><?php echo $viaje['descripcion']; ?></p>
                    <p style="font-weight: bold; color: green;"><?php echo $viaje['precio']; ?>€</p>

                    <a href="detalle_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" style="display: block; text-align: center; background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin-bottom: 10px;">Ver Detalles</a>

                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <div style="display: flex; gap: 5px;">
                            <a href="../admin/modificar_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                            style="flex: 1; text-align: center; background: #ffc107; color: white; padding: 10px; text-decoration: none; border-radius: 5px; font-weight: bold;">Editar</a>

                            <a href="../admin/eliminar_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                               onclick="return confirm('¿Seguro que quieres eliminar este viaje?');"
                               style="flex: 1; text-align: center; background: #dc3545; color: white; padding: 10px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                Eliminar
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>

    </div>
</main>

<?php include __DIR__ . '/../vistas/footer.php'; ?>