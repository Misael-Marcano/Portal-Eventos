<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; ?>

<h2 class="text-center mb-3">Gestión de Eventos</h2>

<div class="container">
    <div class="text-center mb-2">
        <a href="crear_evento.php" class="btn btn-custom">Crear Evento</a>
    </div>

    <div class="event-container">
        <?php
        $sql = "SELECT * FROM eventos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($row['fecha']); ?></p>
                    <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($row['ubicacion']); ?></p>
                    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($row['categoria']); ?></p>
                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($row['ESTADO']); ?></p>
                    <div class="text-right">
                        <a href="editar_evento.php?id=<?php echo $row['id']; ?>" class="btn btn-custom">Editar</a>
                        <a href="message.php?action=delete&id=<?php echo $row['id']; ?>&message=¿Estás seguro de que deseas eliminar este evento?&redirect=eliminar_evento.php" class="btn btn-custom btn-danger-custom">Eliminar</a>
                        <!-- Botón de Más Información -->
                        <a href="detalle_evento.php?id=<?php echo $row['id']; ?>" class="btn btn-custom btn-info">Más Información</a>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p class='no-events-message text-center'>No hay eventos disponibles en este momento.</p>";
        }
        ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
