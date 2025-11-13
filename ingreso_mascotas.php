<?php
session_start();
include("conexion.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Solo admins
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingreso de Mascotas - MascotAR</title>
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

<section class="register">
  <div class="full-form-container">
    <h2 class="ingreso">Panel de Administración - Ingreso de Mascotas</h2>
    <form action="procesar_mascota.php" method="post" class="form-grid">

      <!-- DATOS BÁSICOS -->
      <h3>Datos de la Mascota</h3>
      <label>Nombre:</label>
      <input type="text" name="pet_name" required>

      <label>Especie:</label>
      <select name="pet_species" required>
        <option value="1">Perro</option>
        <option value="2">Gato</option>
        <option value="3">Tortuga</option>
        <option value="4">Canario</option>
      </select>

      <label>Raza:</label>
      <input type="text" name="pet_breed">

      <label>Sexo:</label>
      <select name="pet_sex" required>
        <option value="1">Macho</option>
        <option value="2">Hembra</option>
      </select>

      <label>Edad:</label>
      <select name="pet_age" required>
        <option value="1">Cachorro</option>
        <option value="2">Adulto</option>
      </select>

      <label>Color 1:</label>
      <select name="pet_color1" required>
        <option value="1">Blanco</option>
        <option value="2">Negro</option>
        <option value="3">Marrón</option>
        <option value="4">Amarillo</option>
        <option value="5">Naranja</option>
        <option value="6">Gris</option>
        <option value="7">Otros</option>
      </select>

      <label>Color 2 (opcional):</label>
      <select name="pet_color2">
        <option value="">Ninguno</option>
        <option value="1">Blanco</option>
        <option value="2">Negro</option>
        <option value="3">Marrón</option>
        <option value="4">Amarillo</option>
        <option value="5">Naranja</option>
        <option value="6">Gris</option>
        <option value="7">Otros</option>
      </select>

      <label>Link de la foto:</label>
      <input type="url" name="pet_photo" placeholder="https://ejemplo.com/foto.jpg" required>

      <!-- HISTORIAL MÉDICO -->
      <h3>Historial Médico</h3>
      <?php
        $vacunas = ['vax_moq' => 'Moquillo','vax_parvo' => 'Parvovirus','vax_rab' => 'Rabia','vax_lepto' => 'Leptospirosis','vax_hep' => 'Hepatitis','vax_rino' => 'Rinotraqueítis','vax_calci' => 'Calicivirus','vax_panleuc' => 'Panleucopenia'];
        foreach ($vacunas as $name => $label) {
          echo "<label>$label:</label>
                <select name='$name' required>
                  <option value='SÍ'>SÍ</option>
                  <option value='NO'>NO</option>
                </select>";
        }
      ?>

      <label>Castrado/esterilizado:</label>
      <select name="neut" required>
        <option value="SÍ">SÍ</option>
        <option value="NO">NO</option>
      </select>

      <label>Desparasitado:</label>
      <select name="paras" required>
        <option value="SÍ">SÍ</option>
        <option value="NO">NO</option>
      </select>

      <!-- DISCAPACIDADES -->
      <h3>Discapacidades</h3>
      <label>Ceguera:</label>
      <select name="disabl_blind" required>
        <option value="NO">NO</option>
        <option value="SÍ">SÍ</option>
      </select>

      <label>Sordera:</label>
      <select name="disabl_deaf" required>
        <option value="NO">NO</option>
        <option value="SÍ">SÍ</option>
      </select>

      <label>Cojera:</label>
      <select name="disabl_limp" required>
        <option value="NO">NO</option>
        <option value="SÍ">SÍ</option>
      </select>

      <button type="submit">Registrar Mascota</button>
    </form>
  </div>
</section>

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