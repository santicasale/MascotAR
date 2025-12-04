<?php
include("conexion.php");

$name  = trim($_POST['name']);
$email = trim($_POST['email']);
$msg   = trim($_POST['msg']);

if ($name === "" || $email === "" || $msg === "") {
    echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
    exit();
}

$sql = $conn->prepare("INSERT INTO ask (name, email, msg) VALUES (?, ?, ?)");
$sql->bind_param("sss", $name, $email, $msg);

if ($sql->execute()) {
    echo "<script>alert('Consulta enviada con éxito. Gracias por contactarnos.'); window.history.back();</script>";
} else {
    echo "<script>alert('Error al enviar la consulta: " . $conn->error . "'); window.history.back();</script>";
}

$sql->close();
$conn->close();
?>