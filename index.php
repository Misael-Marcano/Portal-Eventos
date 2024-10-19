<?php include 'templates/header.php'; ?>
<?php include 'includes/db.php'; // Asegúrate de incluir el archivo de conexión ?>

<!-- Jumbotron principal -->
<div class="jumbotron text-center">
    <h1 class="display-4">Bienvenido al Portal de Eventos Comunitarios</h1>
    <p class="lead">Conéctate con tu comunidad y participa en eventos locales.</p>
    <a class="btn btn-custom btn-lg" href="eventos.php" role="button">Explorar Eventos</a>
</div>

<!-- Sección de eventos -->
<div class="container">
    <div class="event-container">
        <?php
        // Consulta para obtener eventos de la base de datos
        $sql = "SELECT * FROM eventos"; // Asegúrate de que 'eventos' es el nombre correcto de tu tabla
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Si hay resultados, recorrer cada evento y mostrarlo
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                        <a href="detalle_evento.php?id=<?php echo $row['id']; ?>" class="btn btn-custom">Más Información</a>
                    </div>
                </div>
                <?php
            }
        } else {
            // Si no hay eventos, mostrar un mensaje estilizado
            echo "<p class='no-events-message'>No hay eventos disponibles en este momento.</p>";
        }
        ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
