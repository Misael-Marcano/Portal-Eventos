<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Portal de Eventos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-register-container">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <h2>Create an Account</h2>
        <p>Join us today! Please fill in the details to create your account:</p>

        <!-- Mostrar error si lo hay -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Mostrar éxito si lo hay -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form method="POST" action="register_process.php">
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <p class="mt-3">Already have an account? <a href="login.php">Log in here</a></p>
    </div>

    <footer>
        <p>© 2024 Portal de Eventos Comunitarios</p>
    </footer>
</body>
</html>
