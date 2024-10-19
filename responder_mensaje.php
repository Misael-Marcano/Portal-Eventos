<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje_id = $_POST['mensaje_id'];
    $respuesta = mysqli_real_escape_string($conn, $_POST['respuesta']);

    // Guardar la respuesta en la tabla (opcional: puedes tener una tabla aparte para respuestas)
    $query = "INSERT INTO respuestas_contacto (mensaje_id, respuesta, fecha_respuesta) 
              VALUES ('$mensaje_id', '$respuesta', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: message.php?status=success&message=" . urlencode("Respuesta enviada exitosamente.") . "&redirect=gestionar_mensajes.php");
    } else {
        $error_message = "Error al enviar la respuesta: " . mysqli_error($conn);
        header("Location: message.php?status=error&message=" . urlencode($error_message) . "&redirect=gestionar_mensajes.php");
    }

    mysqli_close($conn);
}
?>
