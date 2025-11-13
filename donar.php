<?php
include("conexion.php");

$name  = $_POST['nombre'];
$email = $_POST['email'];
$monto = $_POST['monto'];
$estado_id = 1;

// Leer comprobante si se adjunta
$comprobanteData = '';
if (!empty($_FILES['comprobante']['tmp_name'])) {
    $comprobanteData = addslashes(file_get_contents($_FILES['comprobante']['tmp_name']));
}

$tipo = $_FILES['comprobante']['type'];
$permitidos = ['application/pdf', 'image/png', 'image/jpeg', 'image/webp'];
if (!in_array($tipo, $permitidos)) {
    echo "<script>alert('Solo se aceptan archivos PDF, PNG, JPEG o WebP .'); window.history.back();</script>";
    exit;
}

// Insertar donación en la base
$sql = "INSERT INTO donaciones (monto, name, email, donacion_status, comprobante_mp)
        VALUES ('$monto', '$name', '$email', '$estado_id', '$comprobanteData')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('¡Gracias por tu donación! Se registró correctamente.');
            window.location.href='index.php';
          </script>";
} else {
    echo "<script>
            alert('Error al registrar la donación: " . $conn->error . "');
            window.history.back();
          </script>";
}

$conn->close();
?>