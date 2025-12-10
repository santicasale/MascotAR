<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Eliminar adopción
$conn->query("DELETE FROM donacion_estado WHERE id_don_status = $id");

header("Location: index.php");
exit();
?>