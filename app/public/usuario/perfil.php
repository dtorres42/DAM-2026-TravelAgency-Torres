<?php
session_start();
require_once '../../clases/Database.php';
include '../../vistas/header.php';
include '../../vistas/nav.php';

// Verificar si el usuario esta logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Obtener datos del usuario
$query = "SELECT nombre, email, rol, fecha_registro FROM usuarios WHERE id_usuario = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 600px;">
    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px;">Perfil de Usuario</h2>
        
        <div style="margin-top: 20px;">
            <p><strong>Nombre de usuario:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
            <p><strong>Correo electronico:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
            <p><strong>Tipo de cuenta:</strong> <?php echo ucfirst($usuario['rol']); ?></p>
            <p><strong>Miembro desde:</strong> <?php echo $usuario['fecha_registro']; ?></p>
        </div>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="mis_reservas.php" class="btn-buscar" style="text-decoration: none; text-align: center; background: #333;">Ver mis reservas</a>
            
            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="panel_admin.php" class="btn-buscar" style="text-decoration: none; text-align: center; background: #007bff;">Panel de Administracion</a>
            <?php endif; ?>

            <a href="logout.php" style="text-align: center; color: #ff0000; text-decoration: none; margin-top: 10px; font-weight: bold;">Cerrar Sesion</a>
        </div>
    </div>
</section>

<?php include '../vistas/footer.php'; ?>