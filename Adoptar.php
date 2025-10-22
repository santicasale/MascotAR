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

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Asegurar uso de UTF-8
$conn->set_charset("utf8mb4");

// Consulta SQL
$query = "
 SELECT 
    mascotas.pet_photo, 
    mascota_especie.pet_species, 
    mascotas.pet_name, 
    mascotas.pet_breed, 
    mascota_sexo.pet_sex, 
    mascota_edad.pet_age, 
    mascota_color.pet_color, 
    mascota_estado.pet_status, 
    mascotas_hist_medico.vax_moq, 
    mascotas_hist_medico.vax_parvo, 
    mascotas_hist_medico.vax_rab, 
    mascotas_hist_medico.vax_lepto, 
    mascotas_hist_medico.vax_hep, 
    mascotas_hist_medico.vax_rino, 
    mascotas_hist_medico.vax_calci, 
    mascotas_hist_medico.vax_panleuc, 
    mascotas_hist_medico.neut, 
    mascotas_hist_medico.paras, 
    mascotas_discapacidad.disabl_blind, 
    mascotas_discapacidad.disabl_deaf, 
    mascotas_discapacidad.disabl_limp
 FROM mascotas
 INNER JOIN mascota_especie ON mascotas.pet_species = mascota_especie.id_pet_species
 INNER JOIN mascota_sexo ON mascotas.pet_sex = mascota_sexo.id_pet_sex
 INNER JOIN mascota_edad ON mascotas.pet_age = mascota_edad.id_pet_age
 INNER JOIN mascota_color ON mascotas.pet_color1 = mascota_color.id_pet_color
 INNER JOIN mascota_estado ON mascotas.pet_avail = mascota_estado.id_pet_status
 INNER JOIN mascotas_hist_medico ON mascotas.id_pet = mascotas_hist_medico.id_pet_med
 INNER JOIN mascotas_discapacidad ON mascotas.id_pet = mascotas_discapacidad.id_pet_disabl
 WHERE mascotas.pet_avail = 1
";

$result = $conn->query($query);
if (!$result) {
    die("Query error: " . $conn->error);
}

// Generar la cabecera de la tabla
echo "<center><table border='1'>";
echo "<tr>
        <th>Foto</th>
        <th>Especie</th>
        <th>Nombre</th>
        <th>Raza</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th>Color</th>
        <th>Estado</th>
        <th>Hist. Médico</th>
        <th>Discapacidad(es)</th>
      </tr>";

// Recorrer resultados para crear filas
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    // Foto
    $photo = htmlspecialchars($row['pet_photo'], ENT_QUOTES, 'UTF-8');
    echo '<td><img src="'. $photo .'" alt="Photo" style="max-width:120px; height:auto; display:block;" loading="lazy" onerror="this.onerror=null;this.src=\'/path/to/placeholder.png\'"></td>';

    // Especie
    echo "<td>". htmlspecialchars($row['pet_species']) ."</td>";
    // Nombre
    echo "<td>". htmlspecialchars($row['pet_name']) ."</td>";
    // Raza
    echo "<td>". htmlspecialchars($row['pet_breed']) ."</td>";
    // Sexo
    echo "<td>". htmlspecialchars($row['pet_sex']) ."</td>";
    // Edad
    echo "<td>". htmlspecialchars($row['pet_age']) ."</td>";
    // Color
    echo "<td>". htmlspecialchars($row['pet_color']) ."</td>";
    // Estado
    echo "<td>". htmlspecialchars($row['pet_status']) ."</td>";
    // Hist. Médico (vacunaciones)
    echo "<td>
            Vac. Moquillo: ". htmlspecialchars($row['vax_moq']) ."<br>
            Vac. Parvovirus: ". htmlspecialchars($row['vax_parvo']) ."<br>
            Vac. Anti-rábica: ". htmlspecialchars($row['vax_rab']) ."<br>
            Vac. Leptospirosis: ". htmlspecialchars($row['vax_lepto']) ."<br>
            Vac. Hepatitis: ". htmlspecialchars($row['vax_hep']) ."<br>
            Vac. Rinotraqueitis: ". htmlspecialchars($row['vax_rino']) ."<br>
            Vac. Calicivirus: ". htmlspecialchars($row['vax_calci']) ."<br>
            Vac. Panleucopenia: ". htmlspecialchars($row['vax_panleuc']) ."<br><br>
            Castrado/a: ". htmlspecialchars($row['neut']) ."<br>
            Desparasitado/a: ". htmlspecialchars($row['paras']) ."
          </td>";
// Discapacidad(es)
$discapacidades = [];
if (strtolower(trim($row['disabl_blind'])) === "SÍ") $discapacidades[] = "Ceguera";
if (strtolower(trim($row['disabl_deaf'])) === "SÍ") $discapacidades[] = "Audición";
if (strtolower(trim($row['disabl_limp'])) === "SÍ") $discapacidades[] = "Lisiado";

echo "<td>" . (count($discapacidades) > 0 ? implode(", ", $discapacidades) : "Ninguna") . "</td>";

    echo "</tr>";
}
echo "</table></center>";

// Cerrar conexión
$conn->close();
?>
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