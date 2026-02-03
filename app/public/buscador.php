<?php
require_once '../clases/Database.php';

$database = new Database();
$db = $database->getConnection();

// Recogemos los datos del formulario (vienen por POST desde JS)
$destino = $_POST['destino'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$tipo = $_POST['tipo'] ?? '';

// Construimos la consulta dinámica con PDO
$sql = "SELECT * FROM viajes WHERE 1=1";
$params = [];

if (!empty($destino)) {
    $sql .= " AND titulo LIKE ?";
    $params[] = "%$destino%";
}
if (!empty($fecha)) {
    $sql .= " AND fecha_salida >= ?";
    $params[] = $fecha;
}
if (!empty($tipo)) {
    $sql .= " AND tipo_viaje = ?";
    $params[] = $tipo;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);

// Generamos el HTML que se inyectará en la página
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '
        <div class="viaje-card">
            <div class="card-image">
                <img src="../assets/img/'.$row['imagen'].'" alt="'.$row['titulo'].'">
                <div class="badge">'.number_format($row['precio'], 0).'€</div>
            </div>
            <div class="card-info">
                <h3>'.$row['titulo'].'</h3>
                <p>'.$row['descripcion'].'</p>
                <div class="card-footer">
                    <span>'.$row['fecha_salida'].'</span>
                    <a href="detalle_viaje.php?id='.$row['id_viaje'].'" class="btn-small">Ver Más</a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p style="width:100%; text-align:center; padding:20px;">No se encontraron viajes con esos filtros.</p>';
}
?>