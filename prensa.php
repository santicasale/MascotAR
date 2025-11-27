<?php
session_start();
include("conexion.php");
?>
<!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias que Inspiran - MascotAR</title>
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
                <a href="#"><i class="fas fa-user"></i> Ingresar</a>
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

    <section class="prensa-hero">
        <img src="imagenesong/noticiasimg3.webp" alt="Fondo Prensa" class="fondo-img">
        
        <div class="hero-text">
        <h1>Noticias que Inspiran</h1>
        <p>
            En este espacio podrás acceder a las noticias más recientes, entrevistas y notas de prensa sobre MascotAR.  
            Encontrarás historias reales de rescates, adopciones y el trabajo que realizamos día a día para transformar vidas.
        </p>
        </div>
    </section>

    <section class="prensa-contenido">
        <h2>Últimas novedades</h2>
        <div class="noticias-grid">
        <article class="noticia-card">
            <img src="imagenesong/prensaimg2.png" alt="Noticia 1">
            <h3>Un nuevo hogar para Luna</h3>
            <p>Conocé la historia de Luna, una perrita que encontró familia gracias al programa de adopciones.</p>
            <a href="noticias_mas.php?id=1">Leer más</a>
        </article>
        
        <article class="noticia-card">
            <img src="imagenesong/prensaimg.png" alt="Noticia 2">
            <h3>La historia de Tomás, el gato con ruedas</h3>
            <p>Compartimos esta historia de superación.</p>
            <a href="noticias_mas.php?id=2">Leer más</a>
        </article>
        
        <article class="noticia-card">
            <img src="imagenesong/noticiasimg4.webp.png" alt="Noticia 3">
            <h3>Nos entrevistaron para el medio internacional</h3>
            <p>Amigos, compartimos la nota que nos realizaron para el medio internacional.  
            Vinieron a filmar al refugio y les agradecemos muchísimo el espacio.
            </p>
            <a href="noticias_mas.php?id=3">Leer más</a>
        </article>
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
