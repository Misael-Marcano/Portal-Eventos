<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $tipo_usuario = $conn->real_escape_string($_POST['tipo_usuario']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido, email, tipo_usuario, password) VALUES ('$nombre', '$apellido', '$email', '$tipo_usuario', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Usuario agregado con éxito.";
        header('Location: configuracion.php?view=gestionar_usuarios');
    } else {
        echo "Error al agregar el usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Enlace correcto al CSS -->
</head>
<body>
    <div class="form-container">
        <form method="POST" action="agregar_usuario.php">
            <h2>Agregar Usuario</h2>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre del usuario" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" placeholder="Apellido del usuario" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="tipo_usuario">Tipo de Usuario</label>
                <select name="tipo_usuario" required>
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-custom">Agregar Usuario</button>
        </form>
    </div>
</body>
</html>
