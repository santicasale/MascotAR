<?php
include("../conexion.php");

$id = $_POST['id_vivienda'];

$tipo_vivienda = $_POST['tipo_vivienda'];

$sql = "UPDATE adopt_vivienda SET
          tipo_vivienda='$tipo_vivienda'
        WHERE id_vivienda=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Tipo de vivienda actualizado correctamente'); window.location='tabla_adopciones_viviendas.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
