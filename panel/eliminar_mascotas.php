<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM mascotas WHERE id_pet = $id");

header("Location: index.php");
exit();
?>