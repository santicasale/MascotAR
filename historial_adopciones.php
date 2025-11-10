<?php
session_start();
include("conexion.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- Verificar sesión ---
if (!isset($_SESSION['nick'])) {
  echo "<script>alert('Debes iniciar sesión para ver tu historial de adopciones.'); window.location.href='index.php';</script>";
  exit();
}

// --- Obtener el id del usuario logueado ---
$id_usuario = $_SESSION['id_user'];

// --- Consulta de adopciones ---
$sql = "
  SELECT a.id_adopt, e.adopt_status, m.pet_name, m.pet_photo, a.motivo, a.mascotas_previas, v.tipo_vivienda
  FROM adopciones a
  INNER JOIN mascotas m ON a.id_pet_adopt = m.id_pet
  LEFT JOIN adopt_estado e ON a.adopcion_status = e.id_adopt_status 
  LEFT JOIN adopt_vivienda v ON a.id_vivienda = v.id_vivienda
  WHERE a.id_user_adopt = ?
  ORDER BY a.id_adopt DESC
";
$stmt_historial = $conn->prepare($sql);
if (!$stmt_historial) {
  die("Error en la consulta SQL: " . $conn->error);
}

$stmt_historial->bind_param("i", $id_usuario);
$stmt_historial->execute();
$result = $stmt_historial->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Adopciones - MascotAR</title>
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
            <li><a href="prensa.html">Prensa</a></li>
          </ul>
        </li>
        <li><a href="donacion.php">Donar</a></li>
        <li><a href="adoptar.php">Adoptar</a></li>
        <?php if (isset($_SESSION['nick'])): ?>
          <li class="user-menu">
            <!-- Usuario logueado -->
            <a href="#"><i class="fas fa-user"></i> Hola, <?php echo htmlspecialchars($_SESSION['nick']); ?></a>
            <ul class="submenu">
              <?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == "SI"): ?>
                <!-- Menú exclusivo para administradores -->
                <li><a href="ver_usuarios.php">Gestión de usuarios</a></li>
                <li><a href="ver_donaciones.php">Ver donaciones</a></li>
                <li><a href="ver_adopciones.php">Ver adopciones</a></li>
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
      </ul>
    </nav>
  </div>
</header>
<main>
  <section class="historial-adopciones">
    <div class="historial-container">
      <h2>Historial de Adopciones</h2>
      <p>Mostrando las adopciones realizadas por <strong><?php echo htmlspecialchars($_SESSION['nick']); ?></strong></p>

      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; width:85%; background:white; border-collapse:collapse;">
        <thead style="background-color:#ffcc80;">
          <tr>
            <th>ID Adopción</th>
            <th>Mascota</th>
            <th>Foto</th>
            <th>Estado</th>
            <th>Motivo</th>
            <th>Mascotas Previas</th>
            <th>Tipo de Vivienda</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id_adopt']) . "</td>";
              echo "<td>" . htmlspecialchars($row['pet_name']) . "</td>";
              echo "<td><img src='" . htmlspecialchars($row['pet_photo']) . "' alt='Foto mascota' style='max-width:100px; height:auto;'></td>";
              echo "<td>" . htmlspecialchars($row['adopt_status']) . "</td>";
              echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
              echo "<td>" . htmlspecialchars($row['mascotas_previas'] ?? 'N/A') . "</td>";
              echo "<td>" . htmlspecialchars($row['tipo_vivienda'] ?? 'N/A') . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='8' style='text-align:center;'>No realizaste ninguna adopción aún 🐶</td></tr>";
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

    
  </div>
</footer>

</body>
</html>

<?php
$stmt_historial->close();
$conn->close();
?>

