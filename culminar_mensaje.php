<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $mensaje_id = $_GET['id'];

    // Actualizar el estado del mensaje para marcarlo como finalizado
    $query = "UPDATE mensajes_contacto SET estado = 'finalizado' WHERE id = $mensaje_id";

    if (mysqli_query($conn, $query)) {
        header("Location: message.php?status=success&message=" . urlencode("Conversación marcada como finalizada.") . "&redirect=gestionar_mensajes.php");
    } else {
        $error_message = "Error al culminar la conversación: " . mysqli_error($conn);
        header("Location: message.php?status=error&message=" . urlencode($error_message) . "&redirect=gestionar_mensajes.php");
    }

    mysqli_close($conn);
}
?>
