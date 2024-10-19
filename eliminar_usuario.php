<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    die("Acceso denegado.");
}

// Verificar si se pasó un ID de usuario
if (isset($_GET['id'])) {
    $usuario_id = (int)$_GET['id'];

    // Eliminar usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $usuario_id";

    if ($conn->query($sql) === TRUE) {
        header('Location: message.php?status=success&message=Usuario%20eliminado%20con%20éxito&redirect=configuracion.php?view=gestionar_usuarios');
        exit();
    } else {
        echo "Error al eliminar usuario: " . $conn->error;
    }
} else {
    echo "ID de usuario no válido.";
}
?>
