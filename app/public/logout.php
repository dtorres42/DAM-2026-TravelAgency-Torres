<?php
session_start();
session_destroy(); // Borra los datos de la sesión
header("Location: ../public/index.php"); // Te devuelve a la home
exit();
?>