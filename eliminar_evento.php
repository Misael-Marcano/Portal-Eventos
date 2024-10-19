<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: message.php?status=error&message=Acceso denegado. Solo los administradores pueden eliminar eventos.&action=back');
    exit();
}

// Verificar si se pasó un ID de evento
if (isset($_GET['id'])) {
    $evento_id = (int)$_GET['id'];

    // Preparar la consulta para eliminar el evento
    $stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->bind_param('i', $evento_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a message.php con éxito y redirigir a eventos.php
        header('Location: message.php?status=success&message=Evento eliminado correctamente.&redirect=eventos.php');
    } else {
        // Redirigir a message.php con error
        header('Location: message.php?status=error&message=Error al eliminar el evento. Inténtalo de nuevo.&action=back');
    }

    // Cerrar la consulta preparada
    $stmt->close();
} else {
    // Redirigir a message.php con error
    header('Location: message.php?status=error&message=ID de evento no válido.&action=back');
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
