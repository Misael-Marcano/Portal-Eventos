<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portal de Eventos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-register-container">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <h2>Log in to your Account</h2>
        <p>Welcome back! Please log in with your email and password:</p>

        <!-- Mostrar error si lo hay -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Formulario de login -->
        <form method="POST" action="login_process.php">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group d-flex justify-content-end align-items-center">
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="register.php">Create an account</a></p>
    </div>


</body>
</html>
