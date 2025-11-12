<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

session_start();
include("conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST" || empty(trim($_POST['respuesta']))) {
    echo "<script>alert('Método no permitido o respuesta vacía.'); window.location.href='ver_consultas.php';</script>";
    exit;
}

$id_ask = intval($_POST['id_ask']);
$result = $conn->query("SELECT email FROM ask WHERE id_ask = $id_ask");

if ($result->num_rows == 0) {
    echo "<script>alert('Consulta no encontrada.'); window.location.href='ver_consultas.php';</script>";
    exit;
}

$email = $result->fetch_assoc()['email'];

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mascotaresba@gmail.com';
    $mail->Password = 'toyd hpfr bxvi xlvg';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('mascotaresba@gmail.com', 'Mascotar');
    $mail->addAddress($email);
    $mail->Subject = 'Respuesta a tu consulta - Mascotar';
    $mail->Body = "Hola,\n\nGracias por contactarnos. Esta es la respuesta a tu consulta:\n\n" . trim($_POST['respuesta']) . "\n\nAtentamente,\nEquipo de Mascotar";
    $mail->send();
    echo "<script>alert('Respuesta enviada correctamente.'); window.location.href='ver_consultas.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Error al enviar el email: {$mail->ErrorInfo}'); window.location.href='ver_consultas.php';</script>";
}

$conn->close();
?>
