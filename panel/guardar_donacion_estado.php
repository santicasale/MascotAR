<?php
include("../conexion.php");

$id = $_POST['id_don_status'];
$don_status = $_POST['don_status'];
$sql = "UPDATE donacion_estado SET
          don_status='$don_status'
        WHERE id_don_status=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Estado de Donacion actualizado correctamente'); window.location='tabla_donacion_estados.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
