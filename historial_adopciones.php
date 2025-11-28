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

<?php include("header.php"); ?>

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
<?php include("footer.php"); ?>
</body>
</html>

<?php
$stmt_historial->close();
$conn->close();
?>

