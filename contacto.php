<?php include 'templates/header.php'; ?>

<!-- Banner de Contacto -->
<div class="contact-banner">
    <div class="banner-content">
        <h1>Contact Us</h1>
    </div>
</div>

<!-- Sección de información de contacto -->
<div class="contact-info">
    <div class="container">
        <div class="info-cards">
            <div class="info-card">
                <div class="icon">
                    <img src="assets/icons/location.png" alt="Contact Icon">
                </div>
                <h3>Contact Us</h3>
                <p>Alcazar, 09 Downtown st, Victoria, Australia</p>
            </div>
            <div class="info-card">
                <div class="icon">
                    <img src="assets/icons/phone.png" alt="Phone Icon">
                </div>
                <h3>Call Us</h3>
                <p>(+01) 123 456 7896<br>(+01) 123 456 7890</p>
            </div>
            <div class="info-card">
                <div class="icon">
                    <img src="assets/icons/email.png" alt="Email Icon">
                </div>
                <h3>Mail Us</h3>
                <p>info@eventoscomunity.com<br>support@eventoscomunity.com</p>
            </div>
        </div>
    </div>
</div>

<!-- Sección de formulario de contacto -->
<div class="contact-form-section">
    <div class="container">
        <div class="form-title text-center">
            <h2>Send Us Message</h2>
            <p>Today still wanted their sure solutions</p>
        </div>
        <form action="procesar_contacto.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="nombre" class="form-control" placeholder="Your Name*" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Your Email*" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="telefono" class="form-control" placeholder="Phone" required>
                </div>
                <div class="form-group">
                    <input type="text" name="asunto" class="form-control" placeholder="Subject" required>
                </div>
            </div>
            <div class="form-group">
                <textarea name="mensaje" class="form-control" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-custom">Send Us Message</button>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
