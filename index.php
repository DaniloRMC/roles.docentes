<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/conexion.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accion = $_POST['accion'];
    if ($accion === 'login') {
        $stmt = $conexion->prepare('SELECT id, password, rol FROM usuarios WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hash, $rol);
            $stmt->fetch();
            // DEPURACIÓN: Mostrar datos obtenidos
            // echo "<pre>Usuario: $username\nPassword ingresada: $password\nHash en BD: $hash\nRol: $rol</pre>";
            if (password_verify($password, $hash)) {
                $_SESSION['usuario_id'] = $id;
                $_SESSION['rol'] = $rol;
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Contraseña incorrecta.';
                // DEPURACIÓN: Mostrar hash y password ingresada
                // echo "<pre>Hash: $hash\nPassword: $password</pre>";
            }
        } else {
            $error = 'Usuario no encontrado.';
        }
        $stmt->close();
    } elseif ($accion === 'register') {
        $stmt = $conexion->prepare('SELECT id FROM usuarios WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $rol = 'usuario';
            $stmt2 = $conexion->prepare('INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)');
            $stmt2->bind_param('sss', $username, $hash, $rol);
            $stmt2->execute();
            $stmt2->close();
            $error = 'Usuario registrado. Ahora puedes iniciar sesión.';
        } else {
            $error = 'El usuario ya existe.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Lista de Tareas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error) echo '<p class="error">'.$error.'</p>'; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit" name="accion" value="login">Entrar</button>
            <button type="submit" name="accion" value="register">Registrarse</button>
        </form>
    </div>
</body>
</html>
