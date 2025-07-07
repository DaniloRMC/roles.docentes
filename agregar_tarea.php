<?php
session_start();
if (!isset($_SESSION['usuario_id'])) exit('No autorizado');
require 'includes/conexion.php';
$descripcion = $_POST['descripcion'] ?? '';
$usuario_id = $_SESSION['usuario_id'];
if ($descripcion) {
    $stmt = $conexion->prepare('INSERT INTO tareas (descripcion, usuario_id) VALUES (?, ?)');
    $stmt->bind_param('si', $descripcion, $usuario_id);
    $stmt->execute();
    $stmt->close();
    echo 'ok';
} else {
    echo 'error';
}
