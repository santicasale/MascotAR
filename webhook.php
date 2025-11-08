<?php
include("conexion.php");

// Configuración de Mercado Pago
define('MP_ACCESS_TOKEN', 'APP_USR-502327826682038-100521-ae23557030dcf30365aa3fa312265775-2906214560');

require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\SDK;

// Configurar SDK
SDK::setAccessToken(MP_ACCESS_TOKEN);

// Recibir contenido de Mercado Pago (JSON)
$data = file_get_contents("php://input");
if (!$data) {
    http_response_code(400);
    exit("Sin datos recibidos");
}

$event = json_decode($data, true);

// Verificar que la notificación sea de un pago
if (isset($event["type"]) && $event["type"] === "payment") {
    $payment_id = $event["data"]["id"];

    // Consultar el pago en Mercado Pago
    $ch = curl_init("https://api.mercadopago.com/v1/payments/$payment_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . MP_ACCESS_TOKEN
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $payment = json_decode($response, true);

    // Si el pago fue aprobado
    if (isset($payment["status"]) && $payment["status"] === "approved") {
        $external_reference = intval($payment["external_reference"]); // ID de la donación

        // Actualizar el estado a 2
        $sql = "UPDATE donaciones SET donacion_status = 2 WHERE id_donacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $external_reference);
        $stmt->execute();
        $stmt->close();
        $conexion->close();
    }
}

http_response_code(200); // Confirmar recepción a Mercado Pago
?>
