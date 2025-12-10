<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Eliminar adopción
$conn->query("DELETE FROM mascotas_hist_medico WHERE id_pet_med = $id");

header("Location: index.php");
exit();
?>