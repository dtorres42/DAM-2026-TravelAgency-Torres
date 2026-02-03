<?php
// Incluimos el config para tener acceso a BASE_URL
require_once __DIR__ . '/../config.php';

// Iniciamos sesión solo si no ha sido iniciada ya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoHorizon - Viajes en el Tiempo</title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/estilos.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* Un pequeño fix preventivo por si el CSS no carga bien */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Asegura que el footer siempre tienda a ir abajo */
        }
        main {
            flex: 1; /* Esto empuja el footer hacia abajo si hay poco contenido */
        }
    </style>
</head>
<body>