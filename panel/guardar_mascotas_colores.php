<?php
include("../conexion.php");

$id = $_POST['id_pet_color'];
$pet_color = $_POST['pet_color'];
$sql = "UPDATE mascota_color SET
          pet_color='$pet_color'
        WHERE id_pet_color=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Colores de las mascotas fue actualizado correctamente'); window.location='tabla_mascotas_colores.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
