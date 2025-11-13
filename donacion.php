<?php
session_start();
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Donar - MascotAR</title>
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

  <section class="donar">
    <div class="donar-container">
      <h2>Tu donación nos ayuda a ayudar</h2>
      <p>
        Nuestro trabajo es imposible sin ayuda. 
        Te agradecemos desde ya tu voluntad de colaborar con nuestra misión 
        de encontrar hogares definitivos para nuestros rescatados, y también brindar un hogar digno a los que no tienen la suerte de ser adoptados. 
      </p>
      <p><strong>Gracias a tu donación podemos mantener activa esta ONG</strong></p>

      <div class="donar-grid">
        <!-- Formulario -->
        <div class="donar-form">
          <form id="donar-form" action="donar.php" method="post" enctype="multipart/form-data">
            <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" required minlength="2" maxlength="25"pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{2,25}"title="Solo letras (2 a 25 caracteres)">
            <input type="email" name="email"  id="email"  placeholder="Tu correo electrónico" required minlength="6" maxlength="30" pattern="[A-Za-z0-9._%+-@-]{6,30}" title="Debe tener entre 6 y 30 caracteres válidos (A-Z, a-z, 0-9, @, ., -, _)" >
            <input type="number" name="monto" id="monto" placeholder="Monto a donar" required min="0.01"  max="9999999999999.99" step="0.01" title="Debe ser un número decimal con hasta 2 decimales (1 a 15 dígitos)">
            <label for="alias"><strong>Alias para transferir:</strong></label>
            <div class="alias-box">
              <span>mascotar.donar</span>
              <img src="imagenesong/mp.webp" alt="Alias de transferencia">
            </div>

            <label for="comprobante"><strong>Adjuntar comprobante de transferencia: <span style="color:red;">*</span></strong></label>
              <input type="file" id="comprobante" name="comprobante" accept="application/pdf,image/png,image/jpeg,image/jpg,image/webp" required title="Debe adjuntar un PDF o imagen (PNG, JPEG, WebP) máximo 8MB como comprobante">
              <p id="archivo-nombre"></p>
            <button type="submit">Donar Ahora</button>
          </form>
        </div>

        <!-- Imagen -->
        <div class="donar-image">
          <img src="imagenesong/donar.jpg" alt="Imagen de donación">
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
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

  <!-- Script -->
  <script>
    // Mensaje de donación
    document.getElementById("donar-form").addEventListener("submit", function(event) {
      const monto = document.getElementById("monto").value;
      const comprobante = document.getElementById("comprobante").files.length;
      
      if (!monto || monto <= 0) {
        event.preventDefault();
        mostrarMensaje("Por favor ingresá un monto válido.");
        return false;
      }
      
      if (comprobante === 0) {
        event.preventDefault();
        mostrarMensaje("Debes adjuntar un comprobante de transferencia.");
        return false;
      }
      
      const archivo = document.getElementById("comprobante").files[0];
      if (archivo && archivo.size > 8 * 1024 * 1024) {
        event.preventDefault();
        mostrarMensaje("El archivo debe ser menor a 8MB.");
        return false;
      }
      
      mostrarMensaje("¡Gracias por tu donación! Procesando...");
    });

    function mostrarMensaje(texto) {
      const mensaje = document.createElement("div");
      mensaje.className = "mensaje-flotante";
      mensaje.innerText = texto;
      document.body.appendChild(mensaje);
      setTimeout(() => mensaje.classList.add("visible"), 100);
      setTimeout(() => {
        mensaje.classList.remove("visible");
        setTimeout(() => mensaje.remove(), 500);
      }, 5000);
    }

    // Mostrar nombre de archivo seleccionado
    const fileInput = document.getElementById("comprobante");
    const fileName = document.getElementById("archivo-nombre");

    fileInput.addEventListener("change", () => {
      if(fileInput.files.length > 0){
        fileName.textContent = `Archivo seleccionado: ${fileInput.files[0].name}`;
      } else {
        fileName.textContent = '';
      }
    });
  </script>

</body>
</html>
