<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Eliminar adopción
$conn->query("DELETE FROM ask WHERE id_ask = $id");

header("Location: index.php");
exit();
?>