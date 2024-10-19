<?php
session_start();
include 'includes/db.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashear la contraseña

    // Verificar si el usuario ya existe
    $checkUser = $conn->query("SELECT * FROM usuarios WHERE email='$email'");
    if ($checkUser->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password, tipo_usuario) 
                VALUES ('$nombre', '$apellido', '$email', '$password', 'usuario')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }
    }
}

include 'templates/header.php'; 
?>

<h2 class="text-center mb-4">Registrar Nuevo Usuario</h2>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="registrar_usuario.php">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrar Usuario</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
