<?php
// Conexión a la base de datos
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
    $asunto = mysqli_real_escape_string($conn, $_POST['asunto']);
    $mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);

    // Insertar los datos en la tabla de mensajes de contacto
    $query = "INSERT INTO mensajes_contacto (nombre, email, telefono, asunto, mensaje) 
              VALUES ('$nombre', '$email', '$telefono', '$asunto', '$mensaje')";

    if (mysqli_query($conn, $query)) {
        // Redirigir a message.php con mensaje de éxito
        header("Location: message.php?status=success&message=" . urlencode('Mensaje enviado exitosamente') . "&redirect=contacto.php");
        exit(); // Detener la ejecución del script
    } else {
        // Redirigir a message.php con mensaje de error
        $error_message = "Error: " . mysqli_error($conn);
        header("Location: message.php?status=error&message=" . urlencode($error_message) . "&redirect=contacto.php");
        exit(); // Detener la ejecución del script
    }

    // Cerrar conexión
    mysqli_close($conn);
}
?>
