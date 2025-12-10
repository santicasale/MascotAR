<?php
include("../conexion.php");

$id = $_POST['id_adopt_status'];

$adopt_status = $_POST['adopt_status'];

$sql = "UPDATE adopt_estado SET
          adopt_status='$adopt_status'
        WHERE id_adopt_status=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Estado de adopción actualizado correctamente'); window.location='tabla_adopciones_estados.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
