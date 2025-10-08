<?php
include("conexion.php");

// Recibir datos
$f_name   = $_POST['f_name'];
$l_name   = $_POST['l_name'];
$nick     = $_POST['nick'];
$pass     = $_POST['pass'];
$email    = $_POST['email'];
$birthday = $_POST['birthday'];

// Verificar si el email o nick ya existen
$check = "SELECT * FROM usuario_web WHERE email='$email' OR nick='$nick'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    //Usuario ya existente
    echo "<script>
            alert('El correo o nombre de usuario ya están registrados.');
            window.history.back(); // vuelve a la página anterior
          </script>";
} else {
    // Registro de nuevo usuario
    $sql = "INSERT INTO usuario_web (f_name, l_name, nick, pass, email, birthday)
            VALUES ('$f_name', '$l_name', '$nick', '$pass', '$email', '$birthday')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Usuario registrado correctamente.');
                window.location.href='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error al registrar usuario: " . $conn->error . "');
                window.history.back();
              </script>";
    }
}

$conn->close();
?>

