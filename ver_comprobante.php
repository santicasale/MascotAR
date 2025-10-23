<?php
require_once __DIR__ . '/config.php';
$id = intval($_GET['id'] ?? 0);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Error de conexión");

$sql = "SELECT comprobante_mp FROM donaciones WHERE id_donacion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($data);
$stmt->fetch();

if ($data) {
    header("Content-Type: application/pdf"); 
    echo $data;
} else {
    echo "No hay comprobante disponible.";
}

$stmt->close();
$conn->close();
?>
