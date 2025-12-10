<?php
include("../conexion.php");

$id = $_POST['id_pet_status'];
$pet_status = $_POST['pet_status'];
$sql = "UPDATE mascota_estado SET
          pet_status='$pet_status'
        WHERE id_pet_status=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Estados de las mascotas fue actualizado correctamente'); window.location='tabla_mascotas_estados.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>