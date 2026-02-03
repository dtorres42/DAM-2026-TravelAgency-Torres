<?php
session_start();
require_once '../../clases/Database.php';
include '../../vistas/header.php';
include '../../vistas/nav.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$id_usuario = $_SESSION['user_id'];

// Importante: Hemos añadido v.id_viaje a la consulta para que el boton sepa que borrar
$query = "SELECT v.id_viaje, v.titulo, v.fecha_salida, v.precio, r.fecha_reserva 
          FROM reservas r 
          JOIN viajes v ON r.id_viaje = v.id_viaje 
          WHERE r.id_usuario = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id_usuario]);
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 1000px;">
    <h2>Mis Reservas</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; color: #333;">
        <thead>
            <tr style="background: #333; color: white; text-align: left;">
                <th style="padding: 15px;">Destino</th>
                <th style="padding: 15px;">Fecha Salida</th>
                <th style="padding: 15px;">Precio</th>
                <th style="padding: 15px;">Gestion</th> </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 15px;"><?php echo $row['titulo']; ?></td>
                <td style="padding: 15px;"><?php echo $row['fecha_salida']; ?></td>
                <td style="padding: 15px;"><?php echo $row['precio']; ?> euros</td>
                
                <td style="padding: 15px;">
                    <a href="cancelar_reserva.php?id_viaje=<?php echo $row['id_viaje']; ?>" 
                       style="color: #ff0000; text-decoration: none; font-weight: bold;" 
                       onclick="return confirm('Confirmar cancelacion?')">
                       Cancelar Reserva
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php include '../vistas/footer.php'; ?>