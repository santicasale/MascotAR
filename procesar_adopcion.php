<?php
session_start();
include("conexion.php");
if (!isset($_SESSION['nick'])) {
  echo "<script>alert('Debes iniciar sesión para enviar la solicitud.'); window.location='index.php';</script>";
  exit;
}

$id_pet = intval($_POST['id_pet']);
$id_user = intval($_SESSION['id_user']);
$id_vivienda = intval($_POST['id_vivienda']);
$motivo = $conn->real_escape_string($_POST['motivo']); 
$otras = $conn->real_escape_string($_POST['mascotas_previas']);


// Insertar la solicitud de adopción

$sql = "INSERT INTO adopciones (id_pet_adopt, id_user_adopt, motivo, mascotas_previas, id_vivienda,adopcion_status)
        VALUES ($id_pet, $id_user, '$motivo', '$otras',$id_vivienda ,1)";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Solicitud enviada con éxito. Pronto nos contactaremos.'); window.location='adoptar.php';</script>";
} else {
    echo "<script>alert('Error al registrar la solicitud: " . $conn->error . "'); window.history.back();</script>";
}

?>