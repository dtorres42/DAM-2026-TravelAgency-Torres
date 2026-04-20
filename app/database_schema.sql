-- Estructura de la base de datos para la Agencia de Viajes
CREATE DATABASE IF NOT EXISTS travel_agency;
USE travel_agency;

CREATE TABLE IF NOT EXISTS viajes (
    id_viaje INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_salida DATE,
    precio DECIMAL(10,2),
    tipo_viaje VARCHAR(50),
    imagen VARCHAR(255)
);

-- Tabla de usuarios para el módulo de administración
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

