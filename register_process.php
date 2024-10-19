<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
    
    // Verificar si el email ya existe
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Registrar nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            header('Location: message.php?status=success&message=Usuario%20creado%20con%20éxito&redirect=configuracion.php?view=gestionar_usuarios');
            exit();
        } else {
            $_SESSION['error'] = "Error al crear el usuario: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "El correo ya está registrado.";
    }

    header('Location: register.php');
}
?>
