<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Estado de Adopción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar tipo de vivienda</h1>

  <div class="container mt-3">

    <?php
      include("conexion.php");
      $id = $_GET['id'];
      $sql = "SELECT * FROM adopt_vivienda WHERE id_vivienda = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
    ?>

    <form class="row" action="guardar_adopciones_vivienda.php" method="POST">

      <input type="hidden" name="id_vivienda" value="<?php echo $row['id_vivienda']; ?>">

      <label class="mb-1">Tipo de vivienda</label>
      <input type="text" class="form-control mb-3" name="tipo_vivienda" value="<?php echo $row['tipo_vivienda']; ?>" required>

      <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="javascript:history.back()" class="btn btn-dark">Volver</a>
      </div>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>