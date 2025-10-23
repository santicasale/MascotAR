<?php
session_start();
require_once __DIR__ . '/config.php';

// --- Verificar sesión ---
if (!isset($_SESSION['email'])) {
  echo "<script>alert('Debes iniciar sesión para ver tu historial de donaciones.'); window.location.href='index.php';</script>";
  exit();
}

// --- Conexión a BD ---
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// --- Obtener el email del usuario logueado ---
$email_usuario = $_SESSION['email'];

// --- Consulta de donaciones ---
$sql = "
  SELECT d.id_donacion, d.monto, d.fecha, e.don_status, d.comprobante_mp
  FROM donaciones d
  INNER JOIN donacion_estado e ON d.donacion_status = e.id_don_status
  WHERE d.email = ?
  ORDER BY d.fecha DESC
";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
  die("Error en la consulta SQL: " . $conexion->error);
}

$stmt->bind_param("s", $email_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Donaciones - MascotAR</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header>
  <div class="header-container">
    <div class="logo">
      <img src="imagenesong/logomascotar.png" alt="Logo MascotAR">
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="donacion.php">Donar</a></li>
        <li><a href="adoptar.php">Adoptar</a></li>
        <li class="user-menu">
          <a href="#"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['nick']); ?></a>
          <ul class="submenu">
            <li><a href="historial_donaciones.php">Historial de donaciones</a></li>
            <li><a href="#">Historial de adopciones</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</header>
<main>
  <section class="historial-donaciones">
    <div class="historial-container">
      <h2>Historial de Donaciones</h2>
      <p>Mostrando las donaciones realizadas por <strong><?php echo htmlspecialchars($_SESSION['nick']); ?></strong></p>

      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; width:85%; background:white; border-collapse:collapse;">
        <thead style="background-color:#ffcc80;">
          <tr>
            <th>ID Donación</th>
            <th>Fecha</th>
            <th>Monto (ARS)</th>
            <th>Estado</th>
            <th>Comprobante</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id_donacion']) . "</td>";
              echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
              echo "<td>$" . number_format($row['monto'], 2) . "</td>";
              echo "<td>" . htmlspecialchars($row['don_status']) . "</td>";

              if (!empty($row['comprobante_mp'])) {
                echo "<td><a href='ver_comprobante.php?id=" . $row['id_donacion'] . "' target='_blank'>Ver comprobante</a></td>";
              } else {
                echo "<td>-</td>";
              }

              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No realizaste ninguna donación aún 🐶</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
</main>


<footer>
  <div class="footer-container">
    <div class="footer-logo">
      <img src="imagenesong/logomascotar.png" alt="Logo MascotAR">
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
      <form action="#" method="post" class="footer-form">
        <input type="text" placeholder="Tu nombre" required>
        <input type="email" placeholder="Tu email" required>
        <textarea placeholder="Tu mensaje" required></textarea>
        <button type="submit">Enviar</button>
      </form>
    </div>
  </div>
</footer>

</body>
</html>

<?php
$stmt->close();
$conexion->close();
?>
