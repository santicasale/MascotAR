<?php
// --- Datos fijos de prueba ---
$mascotas = [
  ["especie"=>"Perro","nombre"=>"Juan","raza"=>"Beagle","sexo"=>"Macho","edad"=>"Adulto","color"=>"Blanco","foto"=>"imagenesong/juan.jpg"],
  ["especie"=>"Perro","nombre"=>"Max","raza"=>"Mestizo","sexo"=>"Macho","edad"=>"Adulto","color"=>"Marrón","foto"=>"imagenesong/Max.jpeg"],
  ["especie"=>"Perro","nombre"=>"Daisy","raza"=>"Mestizo","sexo"=>"Hembra","edad"=>"Adulta","color"=>"Amarillo","foto"=>"imagenesong/Daisy.avif"],
  ["especie"=>"Perro","nombre"=>"Buddy","raza"=>"Mestizo","sexo"=>"Macho","edad"=>"Adulto","color"=>"Blanco","foto"=>"imagenesong/Buddy.avif"],
  ["especie"=>"Perro","nombre"=>"Lola","raza"=>"Mestizo","sexo"=>"Hembra","edad"=>"Adulta","color"=>"Negro","foto"=>"imagenesong/Lola.jpg"],
  ["especie"=>"Perro","nombre"=>"Paco","raza"=>"Mestizo","sexo"=>"Macho","edad"=>"Adulto","color"=>"Marrón","foto"=>"imagenesong/Max.jpeg"],
  ["especie"=>"Gato","nombre"=>"Simba","raza"=>"Mestizo","sexo"=>"Macho","edad"=>"Cachorro","color"=>"Blanco","foto"=>"imagenesong/gato1.jpg"],
  ["especie"=>"Gato","nombre"=>"Misha","raza"=>"Mestizo","sexo"=>"Hembra","edad"=>"Adulta","color"=>"Gris","foto"=>"imagenesong/gato2.jpg"],
  ["especie"=>"Gato","nombre"=>"Tom","raza"=>"Mestizo","sexo"=>"Macho","edad"=>"Cachorro","color"=>"Blanco","foto"=>"imagenesong/gato3.jpg"],
  ["especie"=>"Gato","nombre"=>"Nina","raza"=>"Mestizo","sexo"=>"Hembra","edad"=>"Adulta","color"=>"Gris","foto"=>"imagenesong/gato4.jpg"],
  ["especie"=>"Gato","nombre"=>"Hugo","raza"=>"Persa","sexo"=>"Macho","edad"=>"Cachorro","color"=>"Blanco","foto"=>"imagenesong/gato5.jpg"]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adoptar Mascota - MascotAR</title>
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
          <li><a href="index.html">Inicio</a></li>
          <li>
            <a href="index.html#nosotros">Quiénes Somos</a>
            <ul class="submenu">
              <li><a href="Prensa.html">Prensa</a></li>
            </ul>
          </li>
          <li><a href="donar.html">Donar</a></li>
          <li><a href="adoptar.php" class="active">Adoptar</a></li>
          <li><a href="adoptados.html">Adoptados</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero -->
  <section class="adoptar-hero">
    <img src="img/adoptar-banner.jpg" alt="Adoptar Mascota">
    <div class="hero-text">
      <h1>Encontrá tu compañero ideal 🐾</h1>
      <p>Adoptá y cambiá dos vidas para siempre 💕</p>
    </div>
  </section>

  <!-- Lista de mascotas -->
  <section class="adoptar-lista">
    <h2>Mascotas disponibles</h2>
    <div class="adoptar-grid">
      <?php foreach ($mascotas as $m): ?>
        <div class="adoptar-card">
          <img src="<?= $m['foto'] ?>" alt="<?= $m['nombre'] ?>">
          <h3><?= $m['nombre'] ?></h3>
          <p><strong>Especie:</strong> <?= $m['especie'] ?></p>
          <p><strong>Raza:</strong> <?= $m['raza'] ?></p>
          <p><strong>Sexo:</strong> <?= $m['sexo'] ?></p>
          <p><strong>Edad:</strong> <?= $m['edad'] ?></p>
          <p><strong>Color:</strong> <?= $m['color'] ?></p>
          <button class="btn-adoptar">Adoptar</button>
        </div>
      <?php endforeach; ?>
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