<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - NeoHorizon</title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>../assets/estilos.css">
    
    <style>
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
            /* Cargamos tu imagen de fondo */
            background-image: url('../assets/img/fondo.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Nav oscuro y elegante como en tu captura */
        nav { 
            background: rgba(0, 0, 0, 0.85); 
            padding: 1rem 2rem; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo a { color: #fff; text-decoration: none; font-size: 1.5rem; font-weight: bold; text-transform: uppercase; }
        .nav-links { list-style: none; display: flex; gap: 25px; margin: 0; }
        .nav-links a { color: #fff; text-decoration: none; font-size: 0.9rem; font-weight: 500; }

        /* ESTO ES LO IMPORTANTE: Hacemos que el fondo se vea a traves del contenido */
        main {
            background: rgba(255, 255, 255, 0.1); /* Fondo blanco muy transparente */
            backdrop-filter: blur(5px); /* Efecto de cristal esmerilado */
            min-height: 100vh;
            padding: 40px 20px;
        }

        h1 { color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    </style>
</head>
<body>