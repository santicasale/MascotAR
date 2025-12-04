<?php
session_start();

include 'conexion.php';

// --- Verificar sesión ---
if (!isset($_SESSION['email'])) {
  echo "<script>alert('Debes iniciar sesión para ver tu historial de donaciones.'); window.location.href='index.php';</script>";
  exit();
}

// --- Obtener el email del usuario logueado ---
$email_usuario = $_SESSION['email'];

// --- Consulta de donaciones ---
$sql = "
  SELECT d.id_donacion, d.monto, d.fecha, e.don_status, d.comprobante_mp
  FROM donaciones d
  INNER JOIN donacion_estado e ON d.donacion_status = e.id_don_status
  WHERE d.email = ?
  ORDER BY d.fecha DESC, d.id_donacion DESC
";

$stmt_historial = $conn->prepare($sql);
if (!$stmt_historial) {
  die("Error en la consulta SQL: " . $conn->error);
}

$stmt_historial->bind_param("s", $email_usuario);
$stmt_historial->execute();
$result = $stmt_historial->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial de Donaciones - MascotAR</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <?php include("header.php"); ?>
<main>
  <section class="historial-donaciones">
    <div class="historial-container">
      <h2>Historial de Donaciones</h2>
      <p>Mostrando las donaciones realizadas por <strong><?php echo htmlspecialchars($_SESSION['nick']); ?></strong></p>

      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; width:85%; background:white; border-collapse:collapse;">
        <thead style="background-color:#ffcc80;">
          <tr>
            <th>ID Donación</th>
            <th>Fecha</th>
            <th>Monto (ARS)</th>
            <th>Estado</th>
            <th>Comprobante</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['id_donacion']) . "</td>";
              echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
              echo "<td>$" . number_format($row['monto'], 2) . "</td>";
              echo "<td>" . htmlspecialchars($row['don_status']) . "</td>";

              if (!empty($row['comprobante_mp'])) {
                echo "<td><a href='ver_comprobante.php?id=" . $row['id_donacion'] . "' target='_blank'>Ver comprobante</a></td>";
              } else {
                echo "<td>-</td>";
              }

              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No realizaste ninguna donación aún 🐶</td></tr>";
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

