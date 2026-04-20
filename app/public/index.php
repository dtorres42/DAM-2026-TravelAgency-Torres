<?php
session_start();
require_once __DIR__ . '/../clases/Database.php';
require_once __DIR__ . '/../clases/Viaje.php';

$db = (new Database())->getConnection();

// --- LÓGICA DEL BUSCADOR ---
$titulo_search = $_GET['titulo'] ?? '';
$precio_max = $_GET['precio_max'] ?? '';
$tipo_search = $_GET['tipo'] ?? ''; 

$query = "SELECT * FROM viajes WHERE 1=1";
$params = [];

if (!empty($titulo_search)) {
    $query .= " AND titulo LIKE ?";
    $params[] = "%$titulo_search%";
}
if (!empty($precio_max)) {
    $query .= " AND precio <= ?";
    $params[] = $precio_max;
}
if (!empty($tipo_search)) { // Filtro por tipo
    $query .= " AND tipo_viaje = ?";
    $params[] = $tipo_search;
}

$stmt = $db->prepare($query);
$stmt->execute($params);

include __DIR__ . '/../vistas/header.php';
include __DIR__ . '/../vistas/nav.php';
?>

<main style="padding: 20px; background: #f4f4f4; font-family: sans-serif; min-height: 80vh;">

    <div style="max-width: 1200px; margin: 0 auto 30px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <form method="GET" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            
            <input type="text" name="titulo" placeholder="¿A dónde quieres ir?" value="<?php echo htmlspecialchars($titulo_search); ?>" 
                   style="flex: 2; padding: 10px; border: 1px solid #ddd; border-radius: 6px; min-width: 200px;">
            
            <select name="tipo" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; min-width: 150px; background: white;">
                <option value="">Cualquier tipo</option>
                <option value="aventura" <?php echo ($tipo_search == 'aventura') ? 'selected' : ''; ?>>Aventura</option>
                <option value="relax" <?php echo ($tipo_search == 'relax') ? 'selected' : ''; ?>>Relax</option>
                <option value="cultural" <?php echo ($tipo_search == 'cultural') ? 'selected' : ''; ?>>Cultural</option>
            </select>

            <input type="number" name="precio_max" placeholder="Precio máx €" value="<?php echo htmlspecialchars($precio_max); ?>" 
                   style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; min-width: 120px;">
            
            <button type="submit" style="background: #333; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
                🔍 Filtrar
            </button>
            
            <?php if (!empty($_GET)): ?>
                <a href="index.php" style="color: #666; text-decoration: none; font-size: 0.85em; margin-left: 5px;">Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <?php
    if (isset($_SESSION['user_id'])) {
        $queryFav = "SELECT v.* FROM viajes v INNER JOIN favoritos f ON v.id_viaje = f.id_viaje WHERE f.id_usuario = ?";
        $stmtFav = $db->prepare($queryFav);
        $stmtFav->execute([$_SESSION['user_id']]);
        
        if ($stmtFav->rowCount() > 0): ?>
            <div style="max-width: 1100px; margin: 20px auto 40px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <h2 style="color: #333; margin-bottom: 20px; border-bottom: 3px solid #ffc107; display: inline-block; padding-bottom: 5px;">⭐ Mis Destinos Favoritos</h2>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <thead>
                        <tr style="text-align: left; background: #f9f9f9;">
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Destino</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Nombre</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee;">Precio</th>
                            <th style="padding: 15px; border-bottom: 2px solid #eee; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fav = $stmtFav->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px 15px;">
                                    <img src="../assets/img/<?php echo $fav['imagen']; ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px;">
                                </td>
                                <td style="padding: 15px; font-weight: bold; color: #444;">
                                    <?php echo $fav['titulo']; ?>
                                </td>
                                <td style="padding: 15px; color: #28a745; font-weight: bold; font-size: 1.1em;">
                                    <?php echo $fav['precio']; ?>€
                                </td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="detalle_viaje.php?id=<?php echo $fav['id_viaje']; ?>" 
                                           style="background: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 0.9em;">
                                           Ver
                                        </a>
                                        <a href="toggle_favorito.php?id=<?php echo $fav['id_viaje']; ?>" 
                                           style="background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 0.9em;">
                                           Quitar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; 
    } ?>

    <h1 style="text-align: center; margin-bottom: 30px; color: #222;">Explora el Tiempo con NeoHorizon</h1>

    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <div style="max-width: 1200px; margin: 0 auto 20px; text-align: right;">
            <a href="../admin/insertar_viaje.php" 
               style="background: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                + Publicar Nuevo Destino
            </a>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto;">
        
        <?php if ($stmt->rowCount() > 0): ?>
            <?php while ($viaje = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.1); display: flex; flex-direction: column; transition: transform 0.3s;">
                    
                    <div style="position: relative; height: 220px;">
                        <a href="toggle_favorito.php?id=<?php echo $viaje['id_viaje']; ?>" 
                           title="Añadir a favoritos"
                           style="position: absolute; top: 12px; right: 12px; z-index: 10; background: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-size: 1.3em;">
                            ⭐
                        </a>
                        <img src="../assets/img/<?php echo $viaje['imagen']; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 style="margin: 0 0 10px 0; color: #333; font-size: 1.4em;"><?php echo $viaje['titulo']; ?></h3>
                        <p style="color: #666; font-size: 0.95em; line-height: 1.5; margin-bottom: 15px; height: 60px; overflow: hidden;">
                            <?php echo $viaje['descripcion']; ?>
                        </p>
                        
                        <div style="margin-top: auto;">
                            <p style="font-weight: bold; color: #28a745; font-size: 1.3em; margin-bottom: 15px;">
                                <?php echo $viaje['precio']; ?>€
                            </p>

                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                <a href="detalle_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                                   style="display: block; text-align: center; background: #007bff; color: white; padding: 12px; text-decoration: none; border-radius: 6px; font-weight: bold;">
                                   Ver Detalles del Viaje
                                </a>

                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="../admin/modificar_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                                           style="flex: 1; text-align: center; background: #ffc107; color: white; padding: 10px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 0.9em;">
                                           Editar
                                        </a>
                                        <a href="../admin/eliminar_viaje.php?id=<?php echo $viaje['id_viaje']; ?>" 
                                           onclick="return confirm('¿Estás seguro de que quieres eliminar permanentemente este viaje?');"
                                           style="flex: 1; text-align: center; background: #dc3545; color: white; padding: 10px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 0.9em;">
                                           Eliminar
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #666;">
                <h3>No se han encontrado resultados para tu búsqueda. </h3>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include __DIR__ . '/../vistas/footer.php'; ?>
