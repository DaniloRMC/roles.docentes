<?php
session_start();
if (!isset($_SESSION['usuario_id'])) exit('No autorizado');
require 'includes/conexion.php';
$id = $_POST['id'] ?? 0;
$usuario_id = $_SESSION['usuario_id'];
$rol = $_SESSION['rol'];
if ($rol === 'admin') {
    $stmt = $conexion->prepare('DELETE FROM tareas WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo 'ok';
} else {
    $stmt = $conexion->prepare('DELETE FROM tareas WHERE id = ? AND usuario_id = ?');
    $stmt->bind_param('ii', $id, $usuario_id);
    $stmt->execute();
    $stmt->close();
    echo 'ok';
}
