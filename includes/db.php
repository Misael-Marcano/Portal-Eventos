<?php
$host = "localhost";
$dbname = "eventos_comunitarios";
$username = "root"; // usuario por defecto en XAMPP
$password = "";

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
