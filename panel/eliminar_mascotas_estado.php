<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascota_estado WHERE id_pet_status = $id");

header("Location: index.php");
exit();
?>