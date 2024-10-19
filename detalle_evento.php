<?php
include 'templates/header.php'; // session_start() ya está en el header
include 'includes/db.php'; // Conectar a la base de datos

ob_start(); // Iniciar el buffer de salida

if (isset($_GET['id'])) {
    $evento_id = intval($_GET['id']);
    
    // Consulta para obtener detalles del evento
    $sql_evento = "SELECT * FROM eventos WHERE id = ?";
    $stmt_evento = $conn->prepare($sql_evento);
    $stmt_evento->bind_param("i", $evento_id);
    $stmt_evento->execute();
    $result_evento = $stmt_evento->get_result();

    if ($result_evento->num_rows > 0) {
        $evento = $result_evento->fetch_assoc();
        ?>
        <div class="container mt-4">
            <!-- Detalles del evento -->
            <h1><?php echo htmlspecialchars($evento['titulo']); ?></h1>
            <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
            <p><strong>Fecha del evento:</strong> <?php echo htmlspecialchars($evento['fecha']); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion']); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($evento['ESTADO']); ?></p>
            
            <hr> <!-- Divisor para separar secciones -->

            <!-- Usuarios que asistirán al evento -->
            <h3>Usuarios que asistirán al evento</h3>
            <div class="user-slider">
            <?php
            // Consulta para obtener los usuarios que asistirán al evento
            $sql_asistentes = "SELECT usuarios.nombre, usuarios.apellido FROM asistencia_eventos 
                               INNER JOIN usuarios ON asistencia_eventos.usuario_id = usuarios.id
                               WHERE asistencia_eventos.evento_id = ?";
            $stmt_asistentes = $conn->prepare($sql_asistentes);
            $stmt_asistentes->bind_param("i", $evento_id);
            $stmt_asistentes->execute();
            $result_asistentes = $stmt_asistentes->get_result();

            if ($result_asistentes->num_rows > 0) {
                while ($asistente = $result_asistentes->fetch_assoc()) {
                    // Usamos el mismo estilo que para los comentarios
                    $nombre_completo = htmlspecialchars($asistente['nombre']) . ' ' . htmlspecialchars($asistente['apellido']);
                    $avatar_url = "assets/images/default-avatar.png"; // Imagen predeterminada del avatar
                    echo '<div class="comment-card" style="min-width: 150px;">'; // Reutilizamos el estilo de comment-card para los asistentes
                    echo '<div class="comment-body">';
                    echo '<div class="avatar-container">';
                    echo '<img src="' . $avatar_url . '" alt="Avatar" class="comment-avatar">';
                    echo '</div>';
                    echo '<h5>' . $nombre_completo . '</h5>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay usuarios registrados para asistir a este evento.</p>';
            }
            ?>
            </div>

            <!-- Formulario para registrar o eliminar asistencia -->
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php
                $usuario_id = $_SESSION['id'];
                // Verificar si el usuario ya está registrado como asistente
                $sql_check_asistencia = "SELECT * FROM asistencia_eventos WHERE usuario_id = ? AND evento_id = ?";
                $stmt_check = $conn->prepare($sql_check_asistencia);
                $stmt_check->bind_param("ii", $usuario_id, $evento_id);
                $stmt_check->execute();
                $result_check = $stmt_check->get_result();

                if ($result_check->num_rows == 0): ?>
                    <form action="detalle_evento.php?id=<?php echo $evento_id; ?>" method="POST">
                        <button type="submit" name="asistir" class="btn btn-custom">Registrar mi asistencia</button>
                    </form>
                <?php else: ?>
                    <form action="detalle_evento.php?id=<?php echo $evento_id; ?>" method="POST">
                        <button type="submit" name="eliminar_asistencia" class="btn btn-danger-custom">Eliminar mi asistencia</button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-danger">Debes iniciar sesión para registrar o eliminar tu asistencia.</p>
            <?php endif; ?>

            <?php
            // Procesar la asistencia cuando se hace clic en el botón
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['asistir']) && isset($_SESSION['id'])) {
                $usuario_id = $_SESSION['id'];

                // Insertar asistencia en la base de datos
                $sql_insert_asistencia = "INSERT INTO asistencia_eventos (usuario_id, evento_id) VALUES (?, ?)";
                $stmt_insert_asistencia = $conn->prepare($sql_insert_asistencia);
                $stmt_insert_asistencia->bind_param("ii", $usuario_id, $evento_id);

                if ($stmt_insert_asistencia->execute()) {
                    echo "<p class='text-success'>Te has registrado correctamente para asistir al evento.</p>";
                    // Redirigir para evitar el reenvío del formulario
                    header("Location: detalle_evento.php?id=$evento_id");
                    exit();
                } else {
                    echo "<p class='text-danger'>Error al registrar la asistencia: " . $conn->error . "</p>";
                }
            }

            // Procesar la eliminación de asistencia
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_asistencia']) && isset($_SESSION['id'])) {
                $usuario_id = $_SESSION['id'];

                // Eliminar asistencia de la base de datos
                $sql_eliminar_asistencia = "DELETE FROM asistencia_eventos WHERE usuario_id = ? AND evento_id = ?";
                $stmt_eliminar_asistencia = $conn->prepare($sql_eliminar_asistencia);
                $stmt_eliminar_asistencia->bind_param("ii", $usuario_id, $evento_id);

                if ($stmt_eliminar_asistencia->execute()) {
                    echo "<p class='text-success'>Has eliminado tu asistencia al evento.</p>";
                    // Redirigir para evitar el reenvío del formulario
                    header("Location: detalle_evento.php?id=$evento_id");
                    exit();
                } else {
                    echo "<p class='text-danger'>Error al eliminar la asistencia: " . $conn->error . "</p>";
                }
            }
            ?>

            <hr> <!-- Divisor para separar secciones -->

            <!-- Comentarios y Valoraciones -->
            <h3>Comentarios y Valoraciones</h3>
            <div class="comment-slider">
            <?php
            // Consulta para obtener los comentarios del evento
            $sql_comentarios = "SELECT comentarios.*, usuarios.nombre, usuarios.apellido, comentarios.valoracion 
                                FROM comentarios 
                                INNER JOIN usuarios ON comentarios.usuario_id = usuarios.id
                                WHERE comentarios.evento_id = ? 
                                ORDER BY comentarios.id DESC";
            $stmt_comentarios = $conn->prepare($sql_comentarios);
            $stmt_comentarios->bind_param("i", $evento_id);
            $stmt_comentarios->execute();
            $result_comentarios = $stmt_comentarios->get_result();

            if ($result_comentarios->num_rows > 0) {
                while ($comentario = $result_comentarios->fetch_assoc()) {
                    // Comprobar si la imagen del avatar existe
                    $nombre_completo = htmlspecialchars($comentario['nombre']) . ' ' . htmlspecialchars($comentario['apellido']);
                    $avatar_url = "assets/images/default-avatar.png"; // Asegúrate de que este archivo exista
                    echo '<div class="comment-card">';
                    echo '<div class="comment-body">';
                    echo '<div class="avatar-container">';
                    echo '<img src="' . $avatar_url . '" alt="Avatar" class="comment-avatar">';
                    echo '</div>';
                    echo '<h5>' . $nombre_completo . '</h5>';
                    echo '<p>' . htmlspecialchars($comentario['comentario']) . '</p>';
                    echo '<p>' . str_repeat('⭐', $comentario['valoracion']) . '</p>'; // Solo estrellas
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay comentarios todavía.</p>';
            }
            ?>
            </div>

            <!-- Formulario para agregar un comentario -->
            <h4>Agregar un comentario y valorar el evento</h4>
            <?php if (isset($_SESSION['usuario'])): ?>
                <form action="detalle_evento.php?id=<?php echo $evento_id; ?>" method="POST">
                    <div class="form-group">
                        <textarea class="form-control" name="comentario" placeholder="Escribe tu comentario aquí..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="valoracion">Valoración del evento (1-5):</label>
                        <select class="form-control" name="valoracion" required>
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-custom">Agregar Comentario</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Debes iniciar sesión para agregar un comentario y una valoración.</p>
            <?php endif; ?>

            <?php
            // Procesar el comentario cuando se envía el formulario
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id']) && !isset($_POST['asistir']) && !isset($_POST['eliminar_asistencia'])) {
                $comentario = $conn->real_escape_string($_POST['comentario']);
                $valoracion = intval($_POST['valoracion']); // Capturamos la valoración
                $usuario_id = $_SESSION['id'];

                // Insertar el comentario y la valoración en la base de datos
                $sql_insert = "INSERT INTO comentarios (comentario, valoracion, usuario_id, evento_id) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("siii", $comentario, $valoracion, $usuario_id, $evento_id);

                if ($stmt_insert->execute()) {
                    echo "<p class='text-success'>Comentario y valoración agregados correctamente.</p>";
                    // Redirigir para evitar que el formulario se vuelva a enviar al actualizar la página
                    header("Location: detalle_evento.php?id=$evento_id");
                    exit();
                } else {
                    echo "<p class='text-danger'>Error al agregar el comentario y la valoración: " . $conn->error . "</p>";
                }
            }
            ?>
        </div>
        <?php
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID de evento no especificado.</p>";
}

include 'templates/footer.php';
ob_end_flush(); // Vaciar el buffer de salida y enviarlo
?>
