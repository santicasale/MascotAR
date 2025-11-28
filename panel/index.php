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
    <li><a href="tabla_mascotas_discapacidades.php">Mascotas Discapacidades</a></li>
    <li><a href="tabla_mascotas_historial_medico.php">Mascotas Historial Médico</a></li>
    <li><a href="tabla_mascotas_colores.php">Mascotas Colores</a></li>
    <li><a href="tabla_mascotas_edades.php">Mascotas Edades</a></li>
    <li><a href="tabla_mascotas_especies.php">Mascotas Especies</a></li>
    <li><a href="tabla_mascotas_estados.php">Mascotas Estados</a></li>
    <li><a href="tabla_mascotas_sexos.php">Mascotas Sexos</a></li>
    <li><a href="tabla_usuarios.php">Usuarios</a></li>
  </ul>
</div>

<footer>
  <div class="footer-container">
    <!-- Logo -->
    <div class="footer-logo">
      <img src="../imagenesong/logomascotar.png" alt="Logo MascotAR">
    </div>

    <div class="footer-section">
      <h3>Contactos</h3>
      <p><strong>Junta Directiva:</strong> Juan Pérez</p>
      <p><strong>Tel:</strong> 11 8822 8844</p>
      <p><strong>Email:</strong> info@mascotar.ong</p>
    </div>

    <div class="footer-section">
      <h3>Dónde estamos</h3>
      <p>Nos encontramos en Pilar,<br>Provincia de Buenos Aires.</p>
    </div>

    <div class="footer-section">
      <h3>Consultas</h3>
      <form action="procesar_consulta.php" method="post" class="footer-form">
        <input type="text" name="name" placeholder="Tu nombre" required>
        <input type="email" name="email" placeholder="Tu email" required>
        <textarea name="msg" placeholder="Tu mensaje" required></textarea>
        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>
</footer>

</body>
</html>
