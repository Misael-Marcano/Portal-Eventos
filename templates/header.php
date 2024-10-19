<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo iniciar la sesión si no está activa
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Eventos Comunitarios</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/logo.png" alt="Logo" width="50" height="50" class="mr-2">
            <span style="color: #28392a; font-weight: bold;">Eventos Comunitarios</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php" style="color: #28392a;">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="eventos.php" style="color: #28392a;">Eventos</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php" style="color: #28392a;">Contacto</a></li>

                <!-- Mostrar usuario si ha iniciado sesión -->
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #28392a;">
                            <img src="assets/images/user.png" alt="User Icon" width="30" height="30" class="rounded-circle mr-2">
                            <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <!-- Mostrar Configuración solo si es admin -->
                            <?php if ($_SESSION['tipo_usuario'] == 'admin'): ?>
                                <a class="dropdown-item" href="configuracion.php">Configuración</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php" style="color: #28392a;">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <script>
        // Usar jQuery en modo no conflicto
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            // Usar el control de Bootstrap directamente para manejar el dropdown
            $('#userDropdown').on('click', function (e) {
                e.preventDefault();
                var $dropdown = $(this).parent();
                if ($dropdown.hasClass('show')) {
                    $dropdown.dropdown('toggle');
                } else {
                    $('.dropdown-menu').removeClass('show');
                    $(this).dropdown('toggle');
                }
            });

            // Cerrar el menú dropdown si se hace clic fuera del área
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-menu').length && !$(e.target).closest('#userDropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        });
    </script>
</body>
</html>
