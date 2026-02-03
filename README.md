# DAM-2026-TravelAgency-Torres
# NeoHorizon - Plataforma de Gestion de Viajes

Sistema web desarrollado en PHP y MySQL para la administracion de destinos turisticos y gestion de reservas de usuarios.

## Tecnologias Utilizadas
- PHP 8.2 (Entorno Servidor)
- MySQL (Base de Datos)
- PDO (Conexion segura a datos)
- CSS3 (Diseno personalizado sin frameworks externos)

## Estructura de Carpetas
- /app/public: Scripts principales y acceso publico.
- /app/clases: Logica de conexion y base de datos.
- /app/vistas: Componentes de interfaz (header, nav, footer).
- /app/assets: Imagenes, logos y hojas de estilo.

## Funcionalidades Principales
1. **Gestion de Viajes (Admin):** CRUD completo (Crear, Leer, Actualizar, Eliminar) con carga de imagenes.
2. **Sistema de Reservas:** Los usuarios pueden reservar viajes. El sistema descuenta plazas automaticamente.
3. **Cancelaciones:** El usuario puede cancelar su reserva desde su panel, restaurando la disponibilidad del viaje.
4. **Seguridad:** Control de acceso por roles (Admin/Usuario) y proteccion de rutas mediante sesiones.

## Instalacion
1. Copiar la carpeta al directorio htdocs.
2. Importar el archivo SQL adjunto en phpMyAdmin.
3. Ajustar los datos de conexion en Database.php si es necesario.

## Credenciales de Acceso
- **Administrador:** admin / admin123
- **Usuario:** paco / user123
