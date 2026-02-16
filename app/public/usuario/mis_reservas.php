<?php
session_start();
require_once __DIR__ . '/../../clases/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$db = (new Database())->getConnection();
$id_usuario = $_SESSION['user_id'];

$query = "SELECT r.id_reserva, v.titulo, v.fecha_salida, v.precio 
          FROM reservas r 
          JOIN viajes v ON r.id_viaje = v.id_viaje 
          WHERE r.id_usuario = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id_usuario]);

include __DIR__ . '/../../vistas/header.php';
include __DIR__ . '/../../vistas/nav.php';
?>

<main style="max-width: 900px; margin: 40px auto; color: white;">
    <h1>Mis Reservas</h1>
    <div style="background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 8px; color: #333;">
        <?php if ($stmt->rowCount() > 0): ?>
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="border-bottom: 2px solid #ddd;">
                    <th style="padding: 10px; text-align: left;">Destino</th>
                    <th style="padding: 10px; text-align: left;">Fecha</th>
                    <th style="padding: 10px; text-align: left;">Precio</th>
                    <th style="padding: 10px; text-align: center;">Acción</th>
                </tr>
                <?php while ($r = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><?php echo htmlspecialchars($r['titulo']); ?></td>
                        <td style="padding: 10px;"><?php echo $r['fecha_salida']; ?></td>
                        <td style="padding: 10px;"><?php echo $r['precio']; ?>€</td>
                        <td style="padding: 10px; text-align: center;">
                            <a href="../../admin/cancelar_reserva.php?id=<?php echo $r['id_reserva']; ?>" 
                               onclick="return confirm('¿Seguro que quieres cancelar este viaje?')"
                               style="background: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8em;">
                               Cancelar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No tienes viajes reservados.</p>
        <?php endif; ?>
    </div>
</main>

<?php include __DIR__ . '/../../vistas/footer.php'; ?>