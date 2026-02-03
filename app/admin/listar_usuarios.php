<?php
session_start();
require_once '../clases/Database.php';
include '../vistas/header.php';
include '../vistas/nav.php';

// Solo el admin puede entrar aquí
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id_usuario, nombre, email, rol, fecha_registro FROM usuarios";
$stmt = $db->query($query);
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 1000px;">
    <h2>Gestión de Usuarios</h2>
    <table style="width: 100%; border-collapse: collapse; background: white; color: #333;">
        <thead>
            <tr style="background: #007bff; color: white;">
                <th style="padding: 15px;">Nombre</th>
                <th style="padding: 15px;">Email</th>
                <th style="padding: 15px;">Rol</th>
                <th style="padding: 15px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr style="border-bottom: 1px solid #ddd;">
                <td style="padding: 15px;"><?php echo htmlspecialchars($user['nombre']); ?></td>
                <td style="padding: 15px;"><?php echo htmlspecialchars($user['email']); ?></td>
                <td style="padding: 15px;"><?php echo $user['rol']; ?></td>
                <td style="padding: 15px;">
                    <a href="editar_usuario.php?id=<?php echo $user['id_usuario']; ?>" style="color: blue; text-decoration: none;">Editar</a> | 
                    <a href="eliminar_usuario.php?id=<?php echo $user['id_usuario']; ?>" 
                       style="color: red; text-decoration: none;" 
                       onclick="return confirm('¿Eliminar este usuario?')">Borrar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php include '../vistas/footer.php'; ?>