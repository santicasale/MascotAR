<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}
$email_usuario = $_SESSION['email'];
$sql = " SELECT d.id_donacion, d.monto, d.fecha, e.don_status, d.comprobante_mp
  FROM donaciones d
  INNER JOIN donacion_estado e ON d.donacion_status = e.id_don_status
  WHERE d.email = ?
  ORDER BY d.fecha DESC, d.id_donacion DESC";
$historial = $conn->prepare($sql);
$historial->bind_param("s", $email_usuario);
$historial->execute();
$res = $historial->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tabla-donaciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="about">
  <div class="ver-admin-container">
    <h2>Tabla de Donaciones</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0"style="margin:auto; background:white; border-collapse:collapse; width:90%; font-family:Open Sans;">
        <tr style="background-color:#ffcc80; text-align:center;">
          <th>ID</th>
          <th>Fecha</th>
          <th>Monto</th>
          <th>Estado</th>
          <th>Comprobante</th>
          <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr style="text-align:center;">
          <td><?= $row['id_donacion'] ?></td>
          <td><?= htmlspecialchars($row['fecha']) ?></td>
          <td>$ <?= htmlspecialchars($row['monto']) ?></td>
          <td><?= htmlspecialchars($row['don_status']) ?></td>
          <td>
          <?php if (!empty($row['comprobante_mp'])): ?>
            <a href="../ver_comprobante.php?id=<?= $row['id_donacion'] ?>" target="_blank" style="color:#0077cc;">Ver comprobante</a>
            <?php else: ?>
              -
               <?php endif; ?>
          </td>
          <td>
            <a href="editar_donacion.php?id=<?= $row['id_donacion'] ?>" class="btn-table btn-warning" style="margin-right:5px;">Editar</a>
            <a href="eliminar_donacion.php?id=<?= $row['id_donacion'] ?>"  class="btn-table btn-danger">Eliminar</a>
          </td>
         </tr>
         <?php endwhile; ?>

        </table>
    <?php else: ?>
      <p style="text-align:center;">No hay estados de donaciones registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>
<?php
$historial->close();
$conn->close();
?>
