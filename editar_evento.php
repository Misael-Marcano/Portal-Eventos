<?php
include 'templates/header.php';
include 'includes/db.php';

// Verificar si se envió un ID válido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar los datos del evento
    $sql = "SELECT * FROM eventos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $evento = $result->fetch_assoc();

    if (!$evento) {
        echo "<p class='text-center'>Evento no encontrado.</p>";
        exit();
    }
} else {
    echo "<p class='text-center'>ID de evento no especificado.</p>";
    exit();
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $estado = $conn->real_escape_string($_POST['estado']);

    $sql_update = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha = ?, ubicacion = ?, categoria = ?, ESTADO = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $titulo, $descripcion, $fecha, $ubicacion, $categoria, $estado, $id);

    if ($stmt_update->execute()) {
        // Redirigir a message.php para mostrar éxito
        header("Location: message.php?status=success&message=El evento se actualizó correctamente&redirect=eventos.php");
        exit();
    } else {
        echo "<p class='text-center'>Error al actualizar el evento: " . $conn->error . "</p>";
    }
}
?>

<div class="container">
    <h2 class="text-center mb-4">Editar Evento</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" name="titulo" value="<?php echo htmlspecialchars($evento['titulo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" name="fecha" value="<?php echo htmlspecialchars($evento['fecha']); ?>" required>
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input type="text" class="form-control" name="ubicacion" value="<?php echo htmlspecialchars($evento['ubicacion']); ?>" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría</label>
            <input type="text" class="form-control" name="categoria" value="<?php echo htmlspecialchars($evento['categoria']); ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="ACTIVO" <?php if ($evento['ESTADO'] == 'ACTIVO') echo 'selected'; ?>>ACTIVO</option>
                <option value="ANULADO" <?php if ($evento['ESTADO'] == 'ANULADO') echo 'selected'; ?>>ANULADO</option>
            </select>
        </div>

        <button type="submit" class="btn btn-custom btn-block">Actualizar Evento</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
