<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

// Configurar Mercado Pago
SDK::setAccessToken(MP_ACCESS_TOKEN);

// Capturar datos del formulario
$name = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$monto = floatval($_POST['monto'] ?? 0);
$estado_id = 1; // 1 = PENDIENTE según tu tabla donacion_estado

if ($monto <= 0) {
  die("⚠️ Monto inválido.");
}

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Leer el comprobante si se adjunta
$comprobanteData = null;
if (!empty($_FILES['comprobante']['tmp_name'])) {
  $comprobanteData = file_get_contents($_FILES['comprobante']['tmp_name']);
}

// Insertar la donación
$sql = "INSERT INTO donaciones (monto, name, email, donacion_status, comprobante_mp)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dssis", $monto, $name, $email, $estado_id, $comprobanteData);
$stmt->send_long_data(4, $comprobanteData);
$stmt->execute();
$id_donacion = $stmt->insert_id;
$stmt->close();
$conn->close();

// Crear preferencia de pago
$item = new Item();
$item->title = "Donación a MascotAR";
$item->quantity = 1;
$item->currency_id = "ARS";
$item->unit_price = $monto;

$preference = new Preference();
$preference->items = [$item];
$preference->external_reference = $id_donacion;
$preference->notification_url = WEBHOOK_URL; // Mantener si usás webhook

$preference->save();

// Redirigir al checkout de Mercado Pago
header("Location: " . $preference->init_point);
exit;
?>