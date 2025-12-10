<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

$sql = "SELECT
  a.id_adopt,
  m.pet_name,
  CONCAT(u.f_name, ' ', u.l_name) AS adoptante,
  e.adopt_status, 
  a.motivo,
  a.mascotas_previas,
  v.tipo_vivienda
FROM
  adopciones a
  INNER JOIN mascotas m ON a.id_pet_adopt = m.id_pet
  LEFT JOIN usuario u ON a.id_user_adopt = u.id_user
  LEFT JOIN adopt_vivienda v ON a.id_vivienda = v.id_vivienda
  LEFT JOIN adopt_estado e ON a.adopcion_status = e.id_adopt_status 
ORDER BY a.id_adopt DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tabla-adopciones</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="about">
  <div class="ver-admin-container">
    <h2>tabla de adopciones</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
        <tr style="background-color:#ffcc80;">
            <th>ID</th>
            <th>Mascota</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Motivo</th>
            <th>Vivienda</th>
            <th>Mascotas Previas</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
           <td><?= $row['id_adopt'] ?></td>
            <td><?= $row['pet_name'] ?></td>
            <td><?= $row['adoptante'] ?></td>
            <td><?= $row['adopt_status'] ?></td>
            <td><?php echo htmlspecialchars($row['motivo']); ?></td>
            <td><?= $row['tipo_vivienda'] ?></td>
            <td><?= $row['mascotas_previas'] ?></td>
            <td>
                <a href="editar_adopciones.php?id=<?= $row['id_adopt'] ?>" class="btn-table btn-warning">Editar</a>
                <a href="eliminar_adopciones.php?id=<?= $row['id_adopt'] ?>" class="btn-table btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta adopción?');">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="text-align:center;">No hay adopciones registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>