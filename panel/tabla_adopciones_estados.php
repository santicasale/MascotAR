<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

$sql = "SELECT * FROM adopt_estado ORDER BY id_adopt_status ASC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tabla-estado-de-adopciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="about">
  <div class="ver-admin-container">
    <h2>tabla de estado de adopciones</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
        <tr style="background-color:#ffcc80;">
          <th>ID</th>
          <th>estado de adopcion</th>
          <th>acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_adopt_status']; ?></td>
            <td><?php echo htmlspecialchars($row['adopt_status']); ?></td>
            <td>
              <a href="editar_adopciones_estado.php?Id=<?php echo $row['id_adopt_status']; ?>" class="btn-table btn-warning">Editar</a>

              <a href="eliminar_adopciones_estado.php?Id=<?php echo $row['id_adopt_status']; ?>" class="btn-table btn-danger">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="text-align:center;">No hay consultas registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>