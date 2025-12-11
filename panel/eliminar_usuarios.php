<?php
include("../conexion.php");

$id = intval($_GET['id']);

$conn->query("DELETE FROM usuario WHERE id_user = $id");

header("Location: index.php");
exit();
?>