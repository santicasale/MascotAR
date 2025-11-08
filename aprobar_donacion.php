<?php
session_start();
include("conexion.php"); 

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SI") {
    header('Location: index.php');
    exit;
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ver_donaciones.php?action_status=error');
    exit;
}

$id_donacion = intval($_GET['id']);
$estado_nuevo = 2; 

// 2. Sentencia SQL preparada para la actualización
$act_estado = $conn->prepare("UPDATE donaciones SET donacion_status = ? WHERE id_donacion = ? AND donacion_status = 1");


$act_estado->bind_param("ii", $estado_nuevo, $id_donacion);

if ($act_estado->execute()) {
    header('Location: ver_donaciones.php?action_status=success');
} else {
    error_log("Error al actualizar donación: " . $act_estado->error); 
    header('Location: ver_donaciones.php?action_status=error');
}

$act_estado->close();
$conn->close();
exit;
?>