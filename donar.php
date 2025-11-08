<?php
include("conexion.php");
// Configuración de Mercado Pago
define('MP_ACCESS_TOKEN', 'APP_USR-502327826682038-100521-ae23557030dcf30365aa3fa312265775-2906214560');
define('BASE_URL', 'https://mascotar.wuaze.com');
define('WEBHOOK_URL', BASE_URL . '/webhook.php');


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
$estado_id = 1; 

if ($monto <= 0) {
  die("⚠️ Monto inválido.");
}

// Leer el comprobante si se adjunta
$comprobanteData = null;
if (!empty($_FILES['comprobante']['tmp_name'])) {
  $comprobanteData = file_get_contents($_FILES['comprobante']['tmp_name']);
}

// Insertar la donación
$sql = "INSERT INTO donaciones (monto, name, email, donacion_status, comprobante_mp)
        VALUES (?, ?, ?, ?, ?)";
$stmt_donacion = $conn->prepare($sql);
$stmt_donacion->bind_param("dssis", $monto, $name, $email, $estado_id, $comprobanteData);
$stmt_donacion->send_long_data(4, $comprobanteData);
$stmt_donacion->execute();
$id_donacion = $stmt_donacion->insert_id;
$stmt_donacion->close();
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
$preference->notification_url = WEBHOOK_URL; 

$preference->save();

header("Location: " . $preference->init_point);
exit;
?>
