<?php
include("conexion.php");

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Content-Type: text/plain");
    exit("ID inválido");
}

$row = $conn->query("SELECT comprobante_mp FROM donaciones WHERE id_donacion = $id")->fetch_assoc();
if (!$row || empty($row['comprobante_mp'])) {
    header("Content-Type: text/plain");
    exit("No hay comprobante");
}

$data = $row['comprobante_mp'];

// Decodificar si está en base64
$decoded = @base64_decode($data, true);
if ($decoded !== false && strlen($decoded) > 0) {
    $data = $decoded;
}

// Detectar tipo MIME
$mime = "application/octet-stream";
if (substr($data, 0, 4) === '%PDF') {
    $mime = "application/pdf";
} elseif (substr($data, 0, 4) === "\x89PNG") {
    $mime = "image/png";
} elseif (substr($data, 0, 3) === "\xFF\xD8\xFF") {
    $mime = "image/jpeg";
} elseif (substr($data, 0, 4) === "RIFF" && substr($data, 8, 4) === "WEBP") {
    $mime = "image/webp";
}

header("Content-Type: $mime");
header("Content-Length: " . strlen($data));
header("Content-Disposition: inline");
header("Cache-Control: public, max-age=3600");

echo $data;
$conn->close();
exit;


