<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $msg = $conn->real_escape_string(trim($_POST['msg']));

    if (!empty($name) && !empty($email) && !empty($msg)) {
        $sql = "INSERT INTO ask (name, email, msg) VALUES ('$name', '$email', '$msg')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Consulta enviada con éxito. Gracias por contactarnos.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error al enviar la consulta: " . $conn->error . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Método no permitido.'); window.history.back();</script>";
}

$conn->close();
?>
