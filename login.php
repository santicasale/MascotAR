<?php
session_start();
include("conexion.php");

$email = $_POST['email'];
$pass  = $_POST['pass'];

// Buscar usuario por email y contraseña
$sql = "SELECT * FROM usuario_web WHERE email='$email' AND pass='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Guardar datos en la sesión
    $_SESSION['nick']  = $user['nick'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['f_name'] = $user['f_name'];

    // Muestra mensaje y lo manda a la pagina principal
    echo "<script>
            alert('Bienvenido, {$user['nick']}');
            window.location.href = 'index.php'
          </script>";
} else {
    echo "<script>
            alert('Usuario o contraseña incorrectos.');
            window.history.back();
          </script>";
}

$conn->close();
?>