<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Verificar si se recibió el ID del usuario
if (!isset($_GET['id'])) {
    echo "ID de usuario no especificado.";
    exit();
}

$id = intval($_GET['id']); // Convertir el ID a entero para evitar inyecciones

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $tipo_usuario = $conn->real_escape_string($_POST['tipo_usuario']); // Tipo de usuario (admin, usuario)

    // Si se proporciona una nueva contraseña, actualizar también la contraseña
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email', tipo_usuario='$tipo_usuario', password='$password' WHERE id=$id";
    } else {
        // Actualizar solo los datos sin la contraseña
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', email='$email', tipo_usuario='$tipo_usuario' WHERE id=$id";
    }

    // Ejecutar la actualización
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Usuario actualizado con éxito.";
        header("Location: message.php?status=success&message=Usuario actualizado con éxito&redirect=configuracion.php?view=gestionar_usuarios");
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

// Obtener los datos actuales del usuario
$sql = "SELECT * FROM usuarios WHERE id=$id";
$result = $conn->query($sql);

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "El usuario no existe.";
    exit();
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container">
    <h2 class="text-center mb-4">Modificar Usuario</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="modificar_usuario.php?id=<?php echo $id; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuario</label>
                    <select class="form-control" name="tipo_usuario" required>
                        <option value="admin" <?php echo ($usuario['tipo_usuario'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="usuario" <?php echo ($usuario['tipo_usuario'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Nueva Contraseña (opcional)</label>
                    <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no cambiar">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
            </form>
        </div>
    </div>
</div>
