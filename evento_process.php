<?php
session_start();
include 'includes/db.php'; // Incluir el archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: message.php?status=error&message=Acceso denegado. No has iniciado sesión.&action=try again");
    exit();
} elseif ($_SESSION['tipo_usuario'] != 'admin') {
    header("Location: message.php?status=error&message=Solo los administradores pueden crear eventos.&action=try again");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $creado_por = $_SESSION['id']; // Usar el ID del usuario que crea el evento

    // Insertar nuevo evento en la base de datos
    $sql = "INSERT INTO eventos (titulo, descripcion, fecha, ubicacion, categoria, creado_por) 
            VALUES ('$titulo', '$descripcion', '$fecha', '$ubicacion', '$categoria', '$creado_por')";

    if ($conn->query($sql) === TRUE) {
        // Obtener el ID del evento recién creado
        $evento_id = $conn->insert_id;

        // Procesar las imágenes si fueron subidas
        if (!empty($_FILES['imagenes']['name'][0])) {
            $total_imagenes = count($_FILES['imagenes']['name']);
            
            for ($i = 0; $i < $total_imagenes; $i++) {
                $imagen_tmp = $_FILES['imagenes']['tmp_name'][$i];
                $imagen_nombre = $_FILES['imagenes']['name'][$i];

                // Definir la ruta donde se guardará la imagen
                $ruta_imagen = "uploads/eventos/" . uniqid() . "_" . $imagen_nombre;
                move_uploaded_file($imagen_tmp, $ruta_imagen);

                // Insertar la imagen en la tabla imagenes_eventos
                $sql_imagen = "INSERT INTO imagenes_eventos (evento_id, imagen_url) VALUES ($evento_id, '$ruta_imagen')";
                $conn->query($sql_imagen);
            }
        }

        // Redirigir con éxito
        header("Location: message.php?status=success&message=Evento creado con éxito.&action=continue");
    } else {
        // Redirigir con error
        header("Location: message.php?status=error&message=Error al crear el evento.&action=try again");
    }
}
?>
