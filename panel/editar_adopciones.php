<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Adopción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Adopción</h1>

  <div class="container mt-3">

    <?php
      include("../conexion.php");

      $id = $_GET['id'];

      $sql = "SELECT * FROM adopciones WHERE id_adopt = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
      $estados = $conn->query("SELECT id_adopt_status, adopt_status FROM adopt_estado");
      $viviendas = $conn->query("SELECT id_vivienda, tipo_vivienda FROM adopt_vivienda");
    ?>

    <form class="row" action="guardar_adopciones.php" method="POST">

      <input type="hidden" name="id_adopt" value="<?php echo $row['id_adopt']; ?>">

      <label class="mb-1">Estado de Adopción</label>
      <select name="adopcion_status" class="form-select mb-3" required>
        <?php while ($e = $estados->fetch_assoc()) { ?>
            <option value="<?= $e['id_adopt_status'] ?>" <?= $e['id_adopt_status'] == $row['adopcion_status'] ? 'selected' : '' ?>>
                <?= $e['adopt_status'] ?>
            </option>
        <?php } ?>
      </select>

      <label class="mb-1">Tipo de Vivienda</label>
      <select name="id_vivienda" class="form-select mb-3" required>
        <?php while ($v = $viviendas->fetch_assoc()) { ?>
            <option value="<?= $v['id_vivienda'] ?>" <?= $v['id_vivienda'] == $row['id_vivienda'] ? 'selected' : '' ?>>
                <?= $v['tipo_vivienda'] ?>
            </option>
        <?php } ?>
      </select>

      <label class="mb-1">Motivo</label>
      <textarea class="form-control mb-3" name="motivo" rows="3"><?php echo $row['motivo']; ?></textarea>

      <label class="mb-1">Mascotas Previas</label>
      <select name='mascotas_previas' class='form-select mb-3' required>
        <option value='SÍ' $s1>SÍ</option>
        <option value='NO' $s2>NO</option>
      </select>
      

      <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="javascript:history.back()" class="btn btn-dark">Volver</a>
      </div>

    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
