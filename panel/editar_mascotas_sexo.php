<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Estado de Adopción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Donacion estado</h1>

  <div class="container mt-3">

    <?php
      include("conexion.php");
      $id = $_GET['id'];

      $sql = "SELECT * FROM mascota_sexo WHERE id_pet_sex = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
    ?>

    <form class="row" action="guardar_mascotas_sexo.php" method="POST">

      <input type="hidden" name="id_pet_sex" value="<?php echo $row['id_pet_sex']; ?>">

      <label class="mb-1">Estado de Adopción</label>
      <input type="text" class="form-control mb-3" name="pet_sex" value="<?php echo $row['pet_sex']; ?>" required>

      <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="javascript:history.back()" class="btn btn-dark">Volver</a>
      </div>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>