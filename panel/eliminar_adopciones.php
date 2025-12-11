<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM adopciones WHERE id_adopt = $id");

header("Location: index.php");
exit();
?>