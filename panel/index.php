<?php
session_start();
include("../conexion.php");

// Check if user is admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
    echo "<script>alert('Acceso denegado.'); window.location.href='../index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Administrativo - Nuevo</title>
    <link rel="stylesheet" href="../style.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include("./header.php"); ?>
<div class="admin-container">
  <h1>Panel Administrativo - Tablas</h1>
  <ul class="main-menu">
    <li><a href="tabla_adopciones.php">Adopciones</a></li>
    <li><a href="tabla_adopciones_estados.php">Adopciones Estados</a></li>
    <li><a href="tabla_adopciones_viviendas.php">Adopciones Viviendas</a></li>
    <li><a href="tabla_consultas.php">Consultas</a></li>
    <li><a href="tabla_donacion.php">Donacion</a></li>
    <li><a href="tabla_donacion_estados.php">Donacion Estado</a></li>
    <li><a href="tabla_mascotas.php">Mascotas</a></li>
    <li><a href="tabla_mascotas_disc.php">Mascotas Discapacidades</a></li>
    <li><a href="tabla_mascotas_hist_medico.php">Mascotas Historial Médico</a></li>
    <li><a href="tabla_mascotas_colores.php">Mascotas Colores</a></li>
    <li><a href="tabla_mascotas_edad.php">Mascotas Edades</a></li>
    <li><a href="tabla_mascotas_especies.php">Mascotas Especies</a></li>
    <li><a href="tabla_mascotas_estados.php">Mascotas Estados</a></li>
    <li><a href="tabla_mascotas_sexos.php">Mascotas Sexos</a></li>
    <li><a href="tabla_usuarios.php">Usuarios</a></li>
  </ul>
</div>

</body>
</html>
