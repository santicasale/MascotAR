<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascota_especie WHERE id_pet_species = $id");

header("Location: index.php");
exit();
?>