<?php
include("../conexion.php");

$id = $_POST['id_pet_species'];
$pet_species = $_POST['pet_species'];
$sql = "UPDATE mascota_especie SET
          pet_species='$pet_species'
        WHERE id_pet_species=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Especie de las mascotas fue actualizado correctamente'); window.location='tabla_mascotas_especies.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>