<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascota_edad WHERE id_pet_age = $id");

header("Location: index.php");
exit();
?>