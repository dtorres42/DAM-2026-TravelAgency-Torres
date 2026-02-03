<?php require_once __DIR__ . '/../config.php'; ?>

<footer style="clear: both; position: relative; z-index: 999999 !important; background: #fff; padding: 40px 0; border-top: 1px solid #eee; text-align: center;">
    
    <div style="margin-bottom: 15px; color: #333;">
        &copy; <?php echo date('Y'); ?> NeoHorizon. Todos los derechos reservados.
    </div>

    <div class="footer-links" style="position: relative; z-index: 9999999 !important;">
        <a href="<?php echo BASE_URL; ?>privacidad.php" 
           style="display: inline-block; padding: 10px; color: #004a99; text-decoration: none; cursor: pointer !important; position: relative; z-index: 10000000;">
           Política de Privacidad
        </a>
        <span style="margin: 0 10px;">|</span>
        <a href="<?php echo BASE_URL; ?>terminos.php" 
           style="display: inline-block; padding: 10px; color: #004a99; text-decoration: none; cursor: pointer !important; position: relative; z-index: 10000000;">
           Términos de Uso
        </a>
        <span style="margin: 0 10px;">|</span>
        <a href="<?php echo BASE_URL; ?>aviso_legal.php" 
           style="display: inline-block; padding: 10px; color: #004a99; text-decoration: none; cursor: pointer !important; position: relative; z-index: 10000000;">
           Aviso Legal
        </a>
    </div>
</footer>
</body>
</html>