<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Estado de Adopción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Estado de Adopción</h1>

  <div class="container mt-3">

    <?php
      include("../conexion.php");

      $id = $_GET['id'];

      $sql = "SELECT * FROM adopt_estado WHERE id_adopt_status = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
    ?>

    <form class="row" action="guardar_adopciones_estado.php" method="POST">

      <input type="hidden" name="id_adopt_status" value="<?php echo $row['id_adopt_status']; ?>">

      <label class="mb-1">Estado de Adopción</label>
      <input type="text" class="form-control mb-3" name="adopt_status" value="<?php echo $row['adopt_status']; ?>" required>

      <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="javascript:history.back()" class="btn btn-dark">Volver</a>
      </div>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>