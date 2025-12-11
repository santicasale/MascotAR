<?php
include("../conexion.php");

$id = $_POST['id_donacion'];
$monto = $_POST['monto'];
$name = $_POST['name'];
$email = $_POST['email'];
$estado = $_POST['donacion_status'];

if (!empty($_FILES['comprobante']['tmp_name'])) {
    $comprobante = addslashes(file_get_contents($_FILES['comprobante']['tmp_name']));
    $query = "UPDATE donaciones SET monto = '$monto', name = '$name', email = '$email', donacion_status = '$estado', comprobante_mp = '$comprobante' WHERE id_donacion = $id";
} 

else {
    $query = "UPDATE donaciones SET monto = '$monto', name = '$name', email = '$email', donacion_status = '$estado' WHERE id_donacion = $id";
}

if ($conn->query($query)) {
    echo "<script>alert('Donacion actualizada correctamente'); window.location='tabla_donacion.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>