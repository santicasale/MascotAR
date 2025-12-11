<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascotas_discapacidad WHERE id_pet_disabl = $id");

header("Location: index.php");
exit();
?>