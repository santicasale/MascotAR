<?php
include("../conexion.php");

$id = $_POST['id_pet_sex'];
$pet_sex = $_POST['pet_sex'];
$sql = "UPDATE mascota_sexo SET
          pet_sex='$pet_sex'
        WHERE id_pet_sex=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Sexos de las mascotas fue actualizado correctamente'); window.location='tabla_mascotas_sexos.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>