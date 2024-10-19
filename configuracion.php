<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Verificar si el usuario es admin
if ($_SESSION['tipo_usuario'] !== 'admin') {
    echo "<div class='alert alert-danger'>No tienes permiso para acceder a esta página.</div>";
    exit();
}

include 'templates/header.php';
?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action" id="gestionarMensajes">Gestionar Mensajes</a>
            <a href="#" class="list-group-item list-group-item-action" id="gestionarUsuarios">Gestionar Usuarios</a>
            <a href="#" class="list-group-item list-group-item-action" id="actualizarDatos">Actualizar Datos</a>
        </div>
    </div>

    <div class="col-md-9">
        <div id="visualizacion" class="border p-4">
            <h3>Seleccione una opción del menú</h3>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function(){
        // Cargar el contenido para "Gestionar Mensajes"
        $("#gestionarMensajes").on('click', function(e){
            e.preventDefault();
            $("#visualizacion").html('<p>Cargando contenido...</p>');
            $("#visualizacion").load("gestionar_mensajes.php");
        });

        // Cargar el contenido para "Gestionar Usuarios"
        $("#gestionarUsuarios").on('click', function(e){
            e.preventDefault();
            $("#visualizacion").html('<p>Cargando contenido...</p>');
            $("#visualizacion").load("gestionar_usuarios.php", function() {
                // Agregar botón para agregar usuario después de cargar la página
                $("#visualizacion").append('<div class="text-right mt-2"><a href="agregar_usuario.php" class="btn btn-primary">Agregar Usuario</a></div>');
            });
        });

        // Cargar el contenido para "Actualizar Datos"
        $("#actualizarDatos").on('click', function(e){
            e.preventDefault();
            $("#visualizacion").html('<p>Cargando contenido...</p>');
            $("#visualizacion").load("perfil.php");
        });

        // Cargar gestionar_usuarios si viene de una redirección
        var view = new URLSearchParams(window.location.search).get('view');
        if (view === 'gestionar_usuarios') {
            $("#gestionarUsuarios").click();
        } else if (view === 'gestionar_mensajes') {
            $("#gestionarMensajes").click();  // Cargar "Gestionar Mensajes" si es la vista deseada
        }
    });
</script>

<?php include 'templates/footer.php'; ?>
