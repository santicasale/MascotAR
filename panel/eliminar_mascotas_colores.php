<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascota_color WHERE id_pet_color = $id");

header("Location: index.php");
exit();
?>