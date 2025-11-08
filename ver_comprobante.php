<?php
include("conexion.php");

$id = intval($_GET['id'] ?? 0);

$sql = "SELECT comprobante_mp FROM donaciones WHERE id_donacion = ?";
$stmt_comprobante = $conexion->prepare($sql);
$stmt_comprobante->bind_param("i", $id);
$stmt_comprobante->execute();
$stmt_comprobante->bind_result($data);
$stmt_comprobante->fetch();

if ($data) {
    header("Content-Type: application/pdf");
    echo $data;
} else {
    echo "No hay comprobante disponible.";
}

$stmt_comprobante->close();
$conexion->close();
?>
