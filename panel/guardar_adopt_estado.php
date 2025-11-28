<?php

include("../conexion.php");

$id  = $_POST['id_adopt_status'];
$estado = $_POST['adopt_status'];

$sql = "UPDATE adopt_estado 
        SET adopt_status = '$estado' 
        WHERE id_adopt_status = $id";

if ($conn->query($sql)) {
    echo "<script>alert('Estado actualizado correctamente'); window.location='index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
