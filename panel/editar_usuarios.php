<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Usuario</h1>

  <div class="container mt-3">

    <?php
      include("conexion.php");

      $id = $_GET['id'];

      $sql = "SELECT * FROM usuario WHERE id_user = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
    ?>

    <form action="guardar_usuarios.php" method="POST">

      <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">

      <label>Nombre</label>
      <input type="text" class="form-control mb-3" name="f_name" value="<?php echo $row['f_name']; ?>" required>

      <label>Apellido</label>
      <input type="text" class="form-control mb-3" name="l_name" value="<?php echo $row['l_name']; ?>" required>

      <label>Email</label>
      <input type="email" class="form-control mb-3" name="email" value="<?php echo $row['email']; ?>" required>

      <label>Nick</label>
      <input type="text" class="form-control mb-3" name="nick" value="<?php echo $row['nick']; ?>" required>

      <label>Admin</label>
      <select name="admin" class="form-select mb-3" required>
        <option value="SÍ" <?= $row['admin'] == "SÍ" ? 'selected' : '' ?>>SÍ</option>
        <option value="NO" <?= $row['admin'] == "NO" ? 'selected' : '' ?>>NO</option>
      </select>

      <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="tabla_usuarios.php" class="btn btn-dark">Volver</a>
      </div>

    </form>

  </div>

</body>

</html>
