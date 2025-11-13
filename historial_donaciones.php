<?php
session_start();

include 'conexion.php';

// --- Verificar sesión ---
if (!isset($_SESSION['email'])) {
  echo "<script>alert('Debes iniciar sesión para ver tu historial de donaciones.'); window.location.href='index.php';</script>";
  exit();
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

$stmt_historial = $conn->prepare($sql);
if (!$stmt_historial) {
  die("Error en la consulta SQL: " . $conn->error);
}

$stmt_historial->bind_param("s", $email_usuario);
$stmt_historial->execute();
$result = $stmt_historial->get_result();
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
          <li>
            <a href="index.php#nosotros">Quiénes Somos</a>
            <ul class="submenu">
              <li><a href="prensa.php">Prensa</a></li>
            </ul>
          </li>
          <li><a href="donacion.php">Donar</a></li>
          <li><a href="adoptar.php">Adoptar</a></li>

          <li class="user-menu">
            <?php if (isset($_SESSION['nick'])): ?>
            <li class="user-menu">
              <!-- Usuario logueado -->
              <a href="#"><i class="fas fa-user"></i> Hola, <?php echo htmlspecialchars($_SESSION['nick']); ?></a>
              <ul class="submenu">
                  
                <?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == "SÍ"): ?>
                  <!-- Menú exclusivo para administradores -->
                  <li><a href="ver_donaciones.php">Ver donaciones</a></li>
                  <li><a href="ver_adopciones.php">Ver adopciones</a></li>
                  <li><a href="ver_consultas.php">Ver consultas</a></li>
                  <li><a href="ingreso_mascotas.php">Ingreso de mascotas</a></li>
                  <hr>
                <?php endif; ?>
                <li><a href="historial_donaciones.php">Historial de donaciones</a></li>
                <li><a href="historial_adopciones.php">Historial de adopciones</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
              </ul>
            <?php else: ?>
              <!-- Usuario NO logueado -->
              <li class="user-menu">
                <a href="#"><i class="fas fa-user"></i></a>
                <ul class="submenu login-submenu">
                  <li>
                    <form class="login-form" action="login.php" method="post">
                      <h3>Iniciar sesión</h3>
                      <input type="email" name="email" placeholder="Ingrese su correo" required>
                      <input type="password" name="pass" placeholder="Ingrese su contraseña" required>
                      <button type="submit">Entrar</button>
                    </form>
                    <p class="register-link">
                      ¿No tenés cuenta? <a href="registrarse.php">Registrate</a>
                    </p>
                  </li>
              </ul>
            </li>
          <?php endif; ?>
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

<?php
$stmt_historial->close();
$conn->close();
?>

