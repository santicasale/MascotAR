<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM adopt_vivienda WHERE id_adopt_vivienda = $id");

header("Location: index.php");
exit();
?>