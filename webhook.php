<?php
// webhook.php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\SDK;

SDK::setAccessToken(MP_ACCESS_TOKEN);

// Capturar la notificación enviada por Mercado Pago
$body = file_get_contents('php://input');
$data = json_decode($body, true);

// Guardar registro del webhook (útil para depurar)
file_put_contents(__DIR__ . '/logs/webhook_log.txt', date('Y-m-d H:i:s') . " => " . $body . PHP_EOL, FILE_APPEND);

if (!isset($data['type']) || $data['type'] !== 'payment') {
    http_response_code(200);
    exit("Notificación ignorada (no es de tipo 'payment').");
}

// Obtener ID del pago desde la notificación
$payment_id = $data['data']['id'] ?? null;
if (!$payment_id) {
    http_response_code(400);
    exit("Sin ID de pago.");
}

try {
    // Consultar información del pago en MP
    $payment = MercadoPago\Payment::find_by_id($payment_id);

    // Datos útiles
    $status = $payment->status; // approved | rejected | pending
    $external_reference = $payment->external_reference; // ID de la donación en tu BD

    // Conexión a la base de datos
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conexion->connect_error) {
        throw new Exception("Error al conectar a la base de datos: " . $conexion->connect_error);
    }

    // Actualizar el estado de la donación
    $sql = "UPDATE donaciones SET donacion_status = ? WHERE id_donacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $status, $external_reference);
    $stmt->execute();
    $stmt->close();

    http_response_code(200);
    echo "Webhook procesado correctamente.";

} catch (Exception $e) {
    file_put_contents(__DIR__ . '/logs/webhook_error.txt', date('Y-m-d H:i:s') . " => " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    http_response_code(500);
    echo "Error al procesar webhook.";
}
?>