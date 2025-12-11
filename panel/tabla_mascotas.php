<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

$sql = "SELECT  mascotas.ID_pet, 
mascotas.pet_photo,
mascota_especie.pet_species, 
mascotas.pet_name, 
mascotas.pet_breed, 
mascota_sexo.pet_sex, 
mascota_edad.pet_age, 
color1.pet_color AS pet_color1, 
color2.pet_color AS pet_color2, 
mascota_estado.pet_status
FROM mascotas
INNER JOIN mascota_especie ON mascotas.pet_species = mascota_especie.id_pet_species
INNER JOIN mascota_sexo ON mascotas.pet_sex = mascota_sexo.id_pet_sex
INNER JOIN mascota_edad ON mascotas.pet_age = mascota_edad.id_pet_age
INNER JOIN mascota_estado ON mascotas.pet_avail = mascota_estado.id_pet_status
INNER JOIN mascota_color AS color1 ON mascotas.pet_color1 = color1.id_pet_color
LEFT JOIN mascota_color AS color2 ON mascotas.pet_color2 = color2.id_pet_color
WHERE mascotas.pet_avail = 1
ORDER BY mascotas.ID_pet DESC";  

$res= $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Tabla-Mascotas</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="about">
  <div class="ver-admin-container">
    <h2>tabla de Mascotas</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
        <tr style="background-color:#ffcc80;">
            <th>ID Mascota</th>
            <th>Nombre</th>
            <th>Especie</th>
            <th>Raza</th>
            <th>Sexo</th>
            <th>Edad</th>
            <th>Color 1</th>
            <th>Color 2</th>
            <th>Estado</th>
            <th>Foto</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID_pet']; ?></td> 
                <td><?php echo htmlspecialchars($row['pet_name']); ?></td> 
                <td><?php echo $row['pet_species']; ?></td> 
                <td><?php echo htmlspecialchars($row['pet_breed']); ?></td>
                <td><?php echo $row['pet_sex']; ?></td>
                <td><?php echo $row['pet_age']; ?></td> 
                <td><?php echo $row['pet_color1']; ?></td>
                <td><?php echo $row['pet_color2']; ?></td>
                <td><?php echo $row['pet_status']; ?></td>
                <td><?php echo $row['pet_photo']; ?></td>  
                <td>
                    <a href="editar_mascotas.php?Id=<?php echo $row['ID_pet']; ?>" class="btn-table btn-warning">Editar</a>
                    <a href="eliminar_mascotas.php?Id=<?php echo $row['ID_pet']; ?>" class="btn-table btn-danger">Eliminar</a>
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
