<?php
session_start();
if (!isset($_SESSION['nick'])) {
  echo "<script>alert('Debes iniciar sesión para adoptar una mascota.'); window.location='index.php';</script>";
  exit;
}

if (!isset($_GET['id_pet'])) {
  echo "<script>alert('Mascota no especificada.'); window.location='Adoptar.php';</script>";
  exit;
}

$id_pet = intval($_GET['id_pet']);
include("conexion.php");
// Verificar si el usuario ya ha enviado una solicitud para esta mascota
$id_user = intval($_SESSION['id_user']);
$query_check = "SELECT id_adopt FROM adopciones WHERE id_pet_adopt = $id_pet AND id_user_adopt = $id_user";
$result_check = $conn->query($query_check);
if ($result_check->num_rows > 0) {
  echo "<script>alert('Ya has enviado una solicitud para esta mascota.'); window.location='adoptar.php';</script>";
  exit;
}


// Consultar los datos de la mascota
$query_mascota = "SELECT pet_name, pet_photo FROM mascotas WHERE id_pet = $id_pet";
$result_mascota = $conn->query($query_mascota);
$mascota = $result_mascota->fetch_assoc();

// Consultar los tipos de vivienda
$query_vivienda = "SELECT id_vivienda, tipo_vivienda FROM adopt_vivienda";
$result_vivienda = $conn->query($query_vivienda);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Adopción - MascotAR</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
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
          <li>
              <a href="adoptar.php">Adoptar</a>
               <ul class="submenu">
                   <li><a href="adoptados.php">Adoptados</a></li>
              </ul>
          </li>

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
                  <li><a href="ver_consultas.php">Ver Consultas</a></li>
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
        <div class="form-container">
            <h2>Formulario de Adopción</h2>
            <p class="form-intro">
                Para poder adoptar, necesitás tener una cuenta registrada.<br>
                Si todavía no la tenés, <a href="registrarse.html" class="register-highlight">registrate aquí</a>.
            </p>
            <form action="procesar_adopcion.php" method="post">
                <h2>Estás adoptando a: <?php echo htmlspecialchars($mascota['pet_name']); ?></h2>
                <img src="<?php echo htmlspecialchars($mascota['pet_photo']); ?>" alt="Mascota" style="max-width:200px; border-radius:10px;">
                <input type="hidden" name="id_pet" value="<?php echo $id_pet; ?>">

                <label for="motivo">Motivo por el que deseas adoptar:</label>
                <textarea name="motivo" required placeholder="Contanos por qué querés adoptar esta mascota..."></textarea>

                <label for="otras">¿Tenés otras mascotas?</label>
                <select name="mascotas_previas" required>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                </select>


                <label for="vivienda">Tipo de vivienda:</label>
                <select id="vivienda" name="id_vivienda" required>
                    <option value="">Seleccioná una opción</option>
                    <?php
                    while ($row = $result_vivienda->fetch_assoc()) {
                        echo '<option value="' . $row['id_vivienda'] . '">' . htmlspecialchars($row['tipo_vivienda']) . '</option>';
                    }
                    ?>
                </select>

                <button type="submit">Enviar Solicitud</button>
            </form>
        </div>
    </main>

<footer>
    <div class="footer-container">
      <!-- Logo -->
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
   