<?php
session_start();
require_once '../clases/Database.php';
include '../vistas/header.php';
include '../vistas/nav.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') exit();

$database = new Database();
$db = $database->getConnection();
$id = $_GET['id'];

if ($_POST) {
    $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id_usuario = ?");
    $stmt->execute([$_POST['nombre'], $_POST['email'], $_POST['rol'], $id]);
    header("Location: usuarios.php");
}

$stmt = $db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<section class="buscador-container" style="margin-top: 50px; max-width: 500px;">
    <form method="POST" style="background: white; padding: 20px; border-radius: 8px;">
        <h3>Editar Usuario</h3>
        <input type="text" name="nombre" value="<?php echo $u['nombre']; ?>" required style="width: 100%; margin-bottom: 10px; padding: 10px;">
        <input type="email" name="email" value="<?php echo $u['email']; ?>" required style="width: 100%; margin-bottom: 10px; padding: 10px;">
        <select name="rol" style="width: 100%; margin-bottom: 20px; padding: 10px;">
            <option value="user" <?php if($u['rol'] == 'user') echo 'selected'; ?>>Usuario</option>
            <option value="admin" <?php if($u['rol'] == 'admin') echo 'selected'; ?>>Administrador</option>
        </select>
        <button type="submit" class="btn-buscar" style="width: 100%;">Guardar Cambios</button>
    </form>
</section>

<?php include '../vistas/footer.php'; ?>