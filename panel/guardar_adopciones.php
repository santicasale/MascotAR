<?php
include("../conexion.php");

$id_adopt         = $_POST['id_adopt'];
$adopcion_status  = $_POST['adopcion_status'];
$id_vivienda      = $_POST['id_vivienda'];
$motivo           = addslashes($_POST['motivo']); 
$mascotas_previas = $_POST['mascotas_previas'];

$sql = "UPDATE adopciones SET 
            adopcion_status  = '$adopcion_status', 
            id_vivienda      = '$id_vivienda', 
            motivo           = '$motivo', 
            mascotas_previas = '$mascotas_previas' 
        WHERE id_adopt = $id_adopt";

if ($conn->query($sql)) {
    echo "<script>alert('Adopcion actualizada correctamente'); window.location='tabla_adopciones.php';</script>";
} else {
    echo "Error al actualizar la adopción: " . $conn->error;
}

$conn->close();
?>