<?php
session_start();
include("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['nick'])) {
    echo "<script>alert('Debes iniciar sesión para enviar la solicitud.'); window.location='index.php';</script>";
    exit;
}

// Capturar datos del formulario y la sesión
$id_pet = intval($_POST['id_pet']);
$id_user = intval($_SESSION['id_user']);
$id_vivienda = intval($_POST['id_vivienda']);
$motivo = $conn->real_escape_string($_POST['motivo']); 
$otras = $conn->real_escape_string($_POST['mascotas_previas']);

// Insertar la solicitud en la tabla adopciones
$sql_adopcion = "INSERT INTO adopciones (id_pet_adopt, id_user_adopt, motivo, mascotas_previas, id_vivienda, adopcion_status)
                 VALUES ($id_pet, $id_user, '$motivo', '$otras', $id_vivienda, 1)";

if ($conn->query($sql_adopcion) === TRUE) {
    $sql_update = "UPDATE mascotas SET pet_avail = 2 WHERE id_pet = $id_pet";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Solicitud enviada con éxito. La mascota fue marcada como en proceso de adopción.'); window.location='adoptar.php';</script>";
    } else {
        echo "<script>alert('La solicitud fue registrada, pero no se pudo actualizar el estado de la mascota: " . $conn->error . "');window.location='adoptar.php';</script>";
    }
} else {
    echo "<script>alert('Error al registrar la solicitud: " . $conn->error . "'); window.history.back(); </script>";
}

$conn->close();
?>
