<?php
include("../conexion.php");

$id = $_POST['id_pet_age'];
$pet_age = $_POST['pet_age'];
$sql = "UPDATE mascota_edad SET
          pet_age='$pet_age'
        WHERE id_pet_age=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Edades de las mascotas fue actualizado correctamente'); window.location='tabla_mascotas_edad.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
