<nav>
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>index.php">NEOHORIZON</a>
    </div>

    <ul class="nav-links">
        <li><a href="<?php echo BASE_URL; ?>index.php">Destinos</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="<?php echo BASE_URL; ?>usuario/mis_reservas.php">Mis Reservas</a></li>

            <li><a href="<?php echo BASE_URL; ?>logout.php" class="btn-logout">Cerrar Sesión</a></li>

        <?php else: ?>
            <li><a href="<?php echo BASE_URL; ?>login.php">Iniciar Sesión</a></li>
            <li><a href="<?php echo BASE_URL; ?>registro.php">Registrarse</a></li>
        <?php endif; ?>
    </ul>
</nav>