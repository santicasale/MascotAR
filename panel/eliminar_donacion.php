<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM donaciones WHERE id_donacion = $id");

header("Location: index.php");
exit();
?>