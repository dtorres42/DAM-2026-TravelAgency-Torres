<?php
session_start();
require_once '../clases/Database.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$user, $pass]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['user_id'] = $usuario['id_usuario'];
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['rol'] = $usuario['rol']; // Aquí guardamos si es 'admin' o 'usuario'

        header("Location: index.php");
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<div class="buscador-container" style="margin-top:100px; max-width:400px;">
    <h2>Iniciar Sesión</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Usuario" required style="width:100%; margin-bottom:10px; padding:10px;">
        <input type="password" name="password" placeholder="Contraseña" required style="width:100%; margin-bottom:10px; padding:10px;">
        <button type="submit" class="btn-buscar" style="width:100%;">ENTRAR</button>
    </form>
</div>