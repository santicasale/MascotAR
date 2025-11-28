<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Eliminar adopción
$conn->query("DELETE FROM adopciones WHERE id_adopt = $id");

header("Location: index.php");
exit();
?>