<?php 
// Aseguramos que config.php esté cargado para usar BASE_URL

require_once __DIR__ . '/../config.php';
?>

<nav style="background: #333; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>index.php" style="color: white; text-decoration: none; font-weight: bold; font-size: 1.2rem;">NeoHorizon</a>
    </div>

    <ul style="list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;">
        <li><a href="<?php echo BASE_URL; ?>index.php" style="color: white; text-decoration: none;">Destinos</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="<?php echo BASE_URL; ?>usuario/mis_reservas.php" style="color: white; text-decoration: none;">Mis Reservas</a></li>
            <li><a href="<?php echo BASE_URL; ?>usuario/perfil.php" style="color: white; text-decoration: none;">Mi Perfil</a></li>

            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <li><a href="<?php echo BASE_URL; ?>admin/panel_admin.php" style="color: #ffc107; text-decoration: none; font-weight: bold;">Panel Admin</a></li>
            <?php endif; ?>

            <li><a href="<?php echo BASE_URL; ?>logout.php" style="color: #ff4d4d; text-decoration: none;">Cerrar Sesión</a></li>

        <?php else: ?>
            <li><a href="<?php echo BASE_URL; ?>login.php" style="color: white; text-decoration: none;">Login</a></li>
            <li><a href="<?php echo BASE_URL; ?>registro.php" style="color: white; text-decoration: none;">Registro</a></li>
        <?php endif; ?>
    </ul>
</nav>