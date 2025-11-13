
<?php
session_start();
include("conexion.php");
$noticias = [
    1 => [
        "titulo" => "Un nuevo hogar para Luna",
        "imagen" => "imagenesong/lunadoptada.jpg",
        "alt" => "Luna adoptada",
        "contenido" => '
            <p>Luna fue rescatada de las calles por nuestro equipo de voluntarios. Cuando llegó al refugio estaba asustada, débil y desconfiada. 
            Con paciencia, amor y cuidados médicos, poco a poco volvió a confiar en las personas.</p>

            <p>Después de varios meses, Luna conoció a su nueva familia adoptiva durante una jornada de adopción organizada por MascotAR. 
            Hoy vive feliz en su nuevo hogar, rodeada de cariño y con un jardín donde puede correr y jugar todos los días.</p>

            <p>Historias como la de Luna son las que nos motivan a seguir trabajando. ¡Gracias a todos los que colaboran para que más animales encuentren un hogar!</p>
        '
    ],

    2 => [
        "titulo" => "La historia de Tomás, el gato con ruedas",
        "imagen" => "imagenesong/prensaimg.png",
        "alt" => "Tomás el gato con ruedas",
        "contenido" => '
            <p>Tomás llegó a MascotAR luego de haber sufrido un accidente que le provocó una lesión irreversible en su columna. 
            A pesar de perder la movilidad en sus patas traseras, nunca perdió las ganas de vivir ni su espíritu curioso.</p>

            <p>Nuestro equipo veterinario trabajó durante semanas en su recuperación, y gracias a la colaboración de voluntarios y donaciones, 
            pudimos conseguirle una pequeña silla de ruedas adaptada especialmente para él.</p>

            <p>Hoy Tomás se desplaza con total independencia, juega con otros gatos y disfruta de cada día al sol. 
            Su historia es un recordatorio de que la discapacidad no es un obstáculo cuando hay amor, cuidado y segundas oportunidades.</p>

            <p>Gracias a quienes colaboraron con MascotAR, historias como la de Tomás son posibles.</p>
        '
    ],

    3 => [
        "titulo" => "Nos entrevistaron para el medio internacional",
        "imagen" => "imagenesong/noticiasimg4.webp.png",
        "alt" => "Entrevista en el refugio",
        "contenido" => '
            <p>Hace unas semanas recibimos la visita de un medio internacional que se interesó por nuestro trabajo en el rescate y la adopción responsable de animales. 
            Vinieron a filmar al refugio y entrevistaron a nuestros voluntarios, quienes contaron sus experiencias y los desafíos diarios de mantener el espacio funcionando.</p>

            <p>La nota fue publicada en su plataforma digital y alcanzó miles de visualizaciones, ayudando a que MascotAR sea reconocido fuera de Argentina. 
            Gracias a esto, recibimos nuevos donantes y colaboradores.</p>

            <p>Seguiremos trabajando con el mismo compromiso, buscando que cada vez más animales tengan una segunda oportunidad.</p>
        '
    ]
];

// Capturar el ID de la noticia desde la URL
$id = $_GET['id'] ?? null;

// Verificar existencia
if (!$id || !isset($noticias[$id])) {
    echo "<h2>Noticia no encontrada</h2>";
    echo '<a href="prensa.php" class="btn-volver">← Volver a Prensa</a>';
    exit;
}

// Cargar datos
$noticia = $noticias[$id];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($noticia['titulo']) ?></title>
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
     <main class="contenido-noticia">
        <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
        <img src="<?= htmlspecialchars($noticia['imagen']) ?>" 
             alt="<?= htmlspecialchars($noticia['alt']) ?>" 
             class="imagen-noticia">
        
        <?= $noticia['contenido'] ?>

        <a href="prensa.php" class="btn-volver">← Volver a Prensa</a>
    </main>
</body>
</html>
