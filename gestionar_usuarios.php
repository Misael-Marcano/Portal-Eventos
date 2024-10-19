<?php
session_start();
include 'includes/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<h2 class="text-center mb-4">Gestión de Usuarios</h2>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Obtener todos los usuarios
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellido'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>
                        <a href='modificar_usuario.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Modificar</a>
                        <a href='message.php?status=confirm&message=¿Estás%20seguro%20de%20que%20deseas%20eliminar%20este%20usuario?&action=eliminar_usuario.php&id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
