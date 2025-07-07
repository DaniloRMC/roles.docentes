<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
require 'includes/conexion.php';
$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];
if ($rol === 'admin') {
    $result = $conexion->query('SELECT tareas.*, usuarios.username FROM tareas LEFT JOIN usuarios ON tareas.usuario_id = usuarios.id');
} else {
    $stmt = $conexion->prepare('SELECT tareas.*, usuarios.username FROM tareas LEFT JOIN usuarios ON tareas.usuario_id = usuarios.id WHERE usuario_id = ?');
    $stmt->bind_param('i', $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lista de Tareas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['rol']); ?></h2>
        <a href="logout.php">Cerrar sesión</a>
        <h3>Agregar Tarea</h3>
        <form id="form-tarea">
            <input type="text" name="descripcion" id="descripcion" placeholder="Nueva tarea" required>
            <button type="submit">Agregar</button>
        </form>
        <h3>Lista de Tareas</h3>
        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="lista-tareas">
                <?php while ($tarea = $result->fetch_assoc()): ?>
                <tr data-id="<?php echo $tarea['id']; ?>">
                    <td><?php echo htmlspecialchars($tarea['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($tarea['username']); ?></td>
                    <td><?php echo $tarea['completada'] ? 'Completada' : 'Pendiente'; ?></td>
                    <td>
                        <?php if ($rol === 'admin' || $tarea['usuario_id'] == $usuario_id): ?>
                        <button class="marcar-btn" data-id="<?php echo $tarea['id']; ?>" <?php if ($tarea['completada']) echo 'disabled'; ?>>Marcar</button>
                        <button class="eliminar-btn" data-id="<?php echo $tarea['id']; ?>">Eliminar</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
