<?php
// Configuracion de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'travel_agency');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuracion Global
define('SITE_NAME', 'NeoHorizon');
define('BASE_URL', 'http://localhost/ProyectoViajes/app/public/');

// Configuracion de Errores (Activar en desarrollo, desactivar en produccion)
error_reporting(E_ALL);
ini_set('display_errors', 1);