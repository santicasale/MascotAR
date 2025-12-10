<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Eliminar adopción
$conn->query("DELETE FROM mascota_sexo WHERE id_pet_sex = $id");

header("Location: index.php");
exit();
?>