<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include('includes/db.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar las entradas del formulario para evitar inyecciones SQL
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Consultar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql); // Usar prepared statements para mayor seguridad
    $stmt->bind_param("s", $email); // Vincular el parámetro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Verificar la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Iniciar sesión
            $_SESSION['usuario'] = $row['nombre']; // Nombre de usuario
            $_SESSION['id'] = $row['id']; // ID del usuario
            $_SESSION['tipo_usuario'] = $row['tipo_usuario']; // Tipo de usuario (admin, etc.)

            // Redirigir según el tipo de usuario
            if ($_SESSION['tipo_usuario'] == 'admin') {
                header("Location: index.php"); // Redirigir a la página de creación de eventos si es admin
            } else {
                header("Location: index.php"); // Redirigir al index si no es admin
            }
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Contraseña incorrecta";
            header("Location: login.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        $_SESSION['error'] = "El correo no existe";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
