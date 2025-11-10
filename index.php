<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MascotAR</title>
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
              <li><a href="Prensa.html">Prensa</a></li>
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
                    <form class="login-form" action="login.php" method="post" autocomplete="off">
                       <h3>Iniciar sesión</h3>
                       <input type="email" name="email" placeholder="Ingrese su correo" required autocomplete="off">
                       <input type="password" name="pass" placeholder="Ingrese su contraseña" required autocomplete="off">
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

  <section class="hero">
    <div class="hero-container">
      <div class="carousel">
        <div class="carousel-track">
          <img src="imagenesong/slider_perrito2.png" alt="Perro rescatado">
          <img src="imagenesong/istockphoto-1254477516-612x612.jpg" alt="Otro animal rescatado">
        </div>
      </div>

      <div class="hero-text">
        <?php if (isset($_SESSION['nick'])): ?>
          <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nick']); ?> </h1>
          <p>Gracias por formar parte de MascotAR y apoyar nuestra misión.</p>
        <?php else: ?>
          <h1>Bienvenidos a MascotAR</h1>
          <p>Rescatamos, ayudamos y damos en adopción.<br>
          Súmate a nuestra misión de darles una segunda oportunidad.</p>
          <a href="Adoptar.html" class="btn">Quiero Adoptar</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="about" id="nosotros">
    <div class="about-container">
      <h2>Sobre Nosotros</h2>
      <p>
        En MascotAR trabajamos para rescatar, cuidar y dar en adopción a animales que necesitan 
        una segunda oportunidad. Nuestro equipo está formado por personas comprometidas que ponen 
        el corazón cada día en esta causa.
      </p>

      <div class="about-grid">
        <div class="about-card">
          <img src="imagenesong/rescatistas.jpg" alt="Rescatistas">
          <h3>Rescatistas</h3>
          <p>Acuden al rescate de animales en situación de peligro o abandono.</p>
        </div>
        <div class="about-card">
          <img src="imagenesong/vet.jpg" alt="Veterinarios">
          <h3>Veterinarios</h3>
          <p>Brindan atención médica y garantizan el bienestar de cada rescatado.</p>
        </div>
        <div class="about-card">
          <img src="imagenesong/cuidadores.webp" alt="Cuidadores">
          <h3>Cuidadores</h3>
          <p>Ofrecen amor, alimento y un lugar seguro hasta que encuentren un hogar.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="team">
    <div class="team-container">
      <h2>Nuestro Equipo</h2>
      <p>
        Detrás de cada rescate y cada adopción hay un grupo de personas que ponen alma, tiempo y
        esfuerzo para que todo sea posible. 
        Voluntarios, veterinarios y rescatistas que trabajan unidos con un solo objetivo: darles a los animales
        la oportunidad de tener una vida mejor.
      </p>

      <div class="team-grid">
        <div class="team-card">
          <img src="imagenesong/equipo.jpg" alt="Equipo MascotAR">
          <h3>Voluntarios y Rescatistas</h3>
          <p>Trabajan en el rescate, cuidado y bienestar de los animales.</p>
        </div>
        <div class="team-card">
          <img src="imagenesong/Veterinaria.jpg" alt="Veterinarios MascotAR">
          <h3>Veterinarios</h3>
          <p>Brindan atención médica y acompañamiento en todo el proceso de recuperación.</p>
        </div>
      </div>
    </div>
  </section>

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

      
    </div>
  </footer>

</body>
</html>
