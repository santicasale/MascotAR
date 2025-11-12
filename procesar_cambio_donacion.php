<?php
session_start();
include("conexion.php");

// Verificar si es admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

// Verificar si llegaron los datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_donacion'], $_POST['accion'])) {
    
    $id_donacion = intval($_POST['id_donacion']);
    $accion = $_POST['accion'];

    // Determinar nuevo estado
    if ($accion === "aprobar") {
        $nuevo_estado = 2; // Aprobada
    } elseif ($accion === "rechazar") {
        $nuevo_estado = 3; // Rechazada
    } else {
        echo "<script>alert('Acción inválida.'); window.location.href='ver_donaciones.php';</script>";
        exit;
    }

    // Actualizar estado en la base de datos
    $sql = "UPDATE donaciones SET donacion_status = $nuevo_estado WHERE id_donacion = $id_donacion";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Estado actualizado correctamente.'); window.location.href='ver_donaciones.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el estado: " . $conn->error . "'); window.location.href='ver_donaciones.php';</script>";
    }

    $conn->close();
    exit;
} else {
    echo "<script>alert('Solicitud inválida.'); window.location.href='ver_donaciones.php';</script>";
    exit;
}
?>