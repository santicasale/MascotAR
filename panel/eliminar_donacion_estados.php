<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM donacion_estado WHERE id_don_status = $id");

header("Location: index.php");
exit();
?>