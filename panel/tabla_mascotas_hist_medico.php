<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}
$sql = "SELECT * FROM mascotas_hist_medico ORDER BY id_pet_med DESC";
$res = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ver consultas</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="about">
  <div class="ver-admin-container">
    <h2>tabla de historial medico</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
        <tr style="background-color:#ffcc80;">
            <th>ID Mascota</th>
            <th>Vacunas Moquillo</th>
            <th>Vacunas Parvovirus</th>
            <th>Vacunas Rabia</th>
            <th>Vacunas Leptospirosis</th>
            <th>Vacunas Hepatitis</th>
            <th>Vacunas Rinotraqueitis</th>
            <th>Vacunas Calicivirus</th>
            <th>Vacunas Panleucopenia</th>
            <th>Castrado</th>
            <th>Parásitos</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_pet_med']; ?></td>
                <td><?php echo $row['vax_moq']; ?></td>
                <td><?php echo $row['vax_parvo']; ?></td>
                <td><?php echo $row['vax_rab']; ?></td>
                <td><?php echo $row['vax_lepto']; ?></td>
                <td><?php echo $row['vax_hep']; ?></td>
                <td><?php echo $row['vax_rino']; ?></td>
                <td><?php echo $row['vax_calci']; ?></td>
                <td><?php echo $row['vax_panleuc']; ?></td>
                <td><?php echo $row['neut']; ?></td>
                <td><?php echo $row['paras']; ?></td>
                <td>
                    <a href="editar_mascotas_hist_medico.php?id=<?= $row['id_pet_med'] ?>" class="btn-table btn-warning ">Editar</a>
                    <a href="eliminar_mascotas_hist_medico.php?id=<?= $row['id_pet_med'] ?>" class="btn-table btn-danger "onclick="return confirm('¿Eliminar este historial?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
      <p style="text-align:center;">No hay mascotas registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>