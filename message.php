<?php
session_start();
$status = isset($_GET['status']) ? $_GET['status'] : 'confirm';
$message = isset($_GET['message']) ? $_GET['message'] : '¿Estás seguro de que deseas realizar esta acción?';
$action = isset($_GET['action']) ? $_GET['action'] : 'continue';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'eventos.php'; // Redirigir por defecto a eventos.php

// Icono según la acción
$icon = ($status == 'success') ? 'assets/images/correcto.png' : 'assets/images/advertencia.png';
$btn_class = ($status == 'success') ? 'btn-success' : 'btn-error';
$btn_text = ($status == 'success') ? 'Continuar' : 'Eliminar';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="message-container">
        <div class="message-box">
            <img src="<?php echo $icon; ?>" alt="Icon">
            <h3><?php echo $status == 'success' ? '¡Éxito!' : 'Advertencia'; ?></h3>
            <p><?php echo htmlspecialchars($message); ?></p>

            <?php if ($status == 'success'): ?>
                <a href="<?php echo $redirect; ?>" class="btn btn-success">Continuar</a>
            <?php else: ?>
                <!-- Si es advertencia, muestra botones para confirmar o cancelar -->
                <a href="<?php echo $redirect . '?id=' . $id; ?>" class="btn btn-error">Confirmar</a>
                <button class="btn btn-custom-cancel" onclick="window.history.back()">Cancelar</button>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Si la acción es exitosa, redirige automáticamente a la página correspondiente después de 3 segundos
        <?php if ($status == 'success'): ?>
        setTimeout(function() {
            window.location.href = '<?php echo $redirect; ?>';
        }, 3000);
        <?php endif; ?>
    </script>
</body>
</html>
