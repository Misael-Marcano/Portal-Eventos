<?php include 'templates/header.php'; ?>
<h2 class="text-center">Crear Nuevo Evento</h2>

<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Formulario para crear evento -->
        <form method="POST" action="evento_process.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título del Evento</label>
                <input type="text" class="form-control" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Evento</label>
                <input type="date" class="form-control" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <input type="text" class="form-control" name="categoria" required>
            </div>
            <div class="form-group">
                <label for="imagenes">Subir Imágenes</label>
                <input type="file" id="file-input" class="file-input" name="imagenes[]" multiple style="display: none;">
                <button type="button" id="file-button" class="btn btn-custom-upload">Elegir archivos</button>
                <span id="file-name">Sin archivos seleccionados</span>
            </div>

            <button type="submit" class="btn btn-custom btn-block">Crear Evento</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('file-button').addEventListener('click', function() {
        document.getElementById('file-input').click();
    });

    document.getElementById('file-input').addEventListener('change', function() {
        var fileName = this.files.length > 0 ? this.files.length + ' archivos seleccionados' : 'Sin archivos seleccionados';
        document.getElementById('file-name').textContent = fileName;
    });
</script>

<?php include 'templates/footer.php'; ?>
