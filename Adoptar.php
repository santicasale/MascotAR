<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adoptar - MascotAR</title>
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
          <li><a href="Donar.html">Donar</a></li>
          <li><a href="Adoptar.php" class="active">Adoptar</a></li>
          <li class="user-menu">
            <a href="#"><i class="fas fa-user"></i></a>
            <ul class="submenu login-submenu">
              <li>
                <form class="login-form">
                  <h3>Iniciar sesión</h3>
                  <input type="email" name="email" placeholder="Ingrese su correo" required>
                  <button type="submit">Entrar</button>
                </form>
                <p class="register-link">¿No tenés cuenta? <a href="registrarse.html">Registrate</a></p>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </header>

 <section class="adoptar-hero">
    <img src="imagenesong/adopta.01.webp" alt="Fondo Adoptar">
  <div class="hero-text">
    <h1>¡ADOPTÁ UN AMIGO PARA SIEMPRE!</h1>
    <p>Vení a conocernos y descubrí cómo trabajamos para darles una segunda oportunidad.</p>
  </div>
</section>

<center>
<table border="1">
  <tr>
    <th>Especie</th>
    <th>Nombre</th>
    <th>Raza</th>
    <th>Sexo</th>
    <th>Edad</th>
    <th>Color</th>
    <th>Estado</th>
    <th>¿Vacunado/a?</th>
    <th>¿Castrado/a?</th>
    <th>¿Desparasitado/a?</th>
    <th>¿Discapacidad?</th>
    <th>Foto</th>
  </tr>
  </center>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "sql313.infinityfree.com";
$username = "if0_40059520"; 
$password = "MightyNo9";     
$dbname = "if0_40059520_mascotar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Asegurar uso de UTF-8 para la conexión
$conn->set_charset("utf8mb4");
// o: mysqli_set_charset($conn, "utf8mb4");

$query = "
SELECT mascota_especie.pet_species, mascotas.pet_name, mascotas.pet_breed, mascota_sexo.pet_sex, mascota_edad.pet_age, mascota_color.pet_color, mascota_estado.pet_status, mascota_vacuna.pet_vax, mascota_castracion.pet_neut, mascota_desparasitacion.pet_paras, mascota_discapacidad.pet_disabl, mascotas.pet_photo
FROM mascotas
INNER JOIN mascota_especie ON mascotas.pet_species = mascota_especie.id_pet_species
INNER JOIN mascota_sexo ON mascotas.pet_sex = mascota_sexo.id_pet_sex
INNER JOIN mascota_edad ON mascotas.pet_age = mascota_edad.id_pet_age
INNER JOIN mascota_color ON mascotas.pet_color1 = mascota_color.id_pet_color
INNER JOIN mascota_estado ON mascotas.pet_avail = mascota_estado.id_pet_status
INNER JOIN mascota_vacuna ON mascotas.pet_vax = mascota_vacuna.id_pet_vax
INNER JOIN mascota_castracion ON mascotas.pet_neut = mascota_castracion.id_pet_neut
INNER JOIN mascota_desparasitacion ON mascotas.pet_paras = mascota_desparasitacion.id_pet_paras
INNER JOIN mascota_discapacidad ON mascotas.pet_disabl = mascota_discapacidad.id_pet_disabl
WHERE mascotas.pet_avail = 1
";

$result = $conn->query($query);

if (!$result) {
    die("Query error: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". htmlspecialchars($row['pet_species']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_name']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_breed']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_sex']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_age']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_color']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_status']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_vax']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_neut']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_paras']) ."</td>";
        echo "<td>". htmlspecialchars($row['pet_disabl']) ."</td>";
        $photo = htmlspecialchars($row['pet_photo'], ENT_QUOTES, 'UTF-8');
echo '<td><img src="'. $photo .'" alt="Photo" style="max-width:120px; height:auto; display:block;" loading="lazy" onerror="this.onerror=null;this.src=\'/path/to/placeholder.png\'"></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No pets found.</td></tr>";
}
$conn->close();
?>
 </tbody>
</table>
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