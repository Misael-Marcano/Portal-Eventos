<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    
    // Si el usuario quiere cambiar la contraseña
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', password='$password' WHERE id=" . $_SESSION['id'];
    } else {
        // Actualizar solo nombre y apellido
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido' WHERE id=" . $_SESSION['id'];
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['nombre'] = $nombre; // Actualizar nombre en sesión
        header('Location: index.php');
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

// Obtener datos actuales del usuario
$sql = "SELECT nombre, apellido FROM usuarios WHERE id=" . $_SESSION['id'];
$result = $conn->query($sql);

// Comprobamos si hubo resultados en la consulta antes de hacer fetch
if ($result && $result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Error al obtener los datos del usuario.";
    exit();
}
?>

<h2 class="text-center">Actualizar Datos</h2>

<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="perfil.php">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Nueva Contraseña (opcional)</label>
                <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no cambiar">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
        </form>
    </div>
</div>
