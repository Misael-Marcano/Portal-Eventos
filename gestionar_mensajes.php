<?php

include 'includes/db.php'; // Incluimos la conexión a la base de datos

// Obtener todos los mensajes de la tabla de mensajes de contacto
$query = "SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="text-center">Gestionar Mensajes</h2>
    
    <!-- Lista de mensajes recibidos -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                <td><?php echo htmlspecialchars($row['mensaje']); ?></td>
                <td>
                    <!-- Botón para responder al mensaje -->
                    <button class="btn btn-info" onclick="showResponseForm(<?php echo $row['id']; ?>)">Responder</button>
                    <!-- Botón para culminar conversación -->
                    <button class="btn btn-success" onclick="culminarConversacion(<?php echo $row['id']; ?>)">Culminar</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Formulario para responder mensajes -->
    <div id="response-form" style="display:none;">
        <h3>Responder Mensaje</h3>
        <form action="responder_mensaje.php" method="POST">
            <input type="hidden" name="mensaje_id" id="mensaje_id">
            <div class="form-group">
                <label for="respuesta">Escribe tu respuesta:</label>
                <textarea class="form-control" name="respuesta" id="respuesta" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
            <button type="button" class="btn btn-secondary" onclick="hideResponseForm()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function showResponseForm(id) {
    document.getElementById('mensaje_id').value = id;
    document.getElementById('response-form').style.display = 'block';
}

function hideResponseForm() {
    document.getElementById('response-form').style.display = 'none';
}

function culminarConversacion(id) {
    if(confirm('¿Estás seguro de que deseas marcar esta conversación como culminada?')) {
        window.location.href = 'culminar_mensaje.php?id=' + id;
    }
}
</script>




