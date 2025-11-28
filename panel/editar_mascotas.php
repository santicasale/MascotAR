<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Mascota</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
  <h1 class="bg-black p-2 text-white text-center">Editar Mascota</h1>

  <div class="container mt-3">

    <?php
      include("../conexion.php");

      $id = $_GET['Id'];

      // Traer datos actuales de la mascota
      $sql = "SELECT * FROM mascotas WHERE id_pet = $id LIMIT 1";
      $res = $conn->query($sql);
      $row = $res->fetch_assoc();
    ?>

    <form action="guardar_mascota.php" method="POST" enctype="multipart/form-data">

      <!-- ID -->
      <input type="hidden" name="id_pet" value="<?php echo $row['id_pet']; ?>">

      <label>Nombre</label>
      <input type="text" class="form-control mb-3" name="pet_name" value="<?php echo $row['pet_name']; ?>" required>

      <label>Raza</label>
      <input type="text" class="form-control mb-3" name="pet_breed" value="<?php echo $row['pet_breed']; ?>">

      <!-- Especie -->
      <label>Especie</label>
      <select name="pet_species" class="form-select mb-3" required>
        <?php
          $list = $conn->query("SELECT * FROM mascota_especie ORDER BY pet_species_name");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_species'] == $row['pet_species']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_species']}' $sel>{$opt['pet_species_name']}</option>";
          }
        ?>
      </select>

      <!-- Sexo -->
      <label>Sexo</label>
      <select name="pet_sex" class="form-select mb-3" required>
        <?php
          $list = $conn->query("SELECT * FROM mascota_sexo");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_sex'] == $row['pet_sex']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_sex']}' $sel>{$opt['pet_sex_name']}</option>";
          }
        ?>
      </select>

      <!-- Edad -->
      <label>Edad</label>
      <select name="pet_age" class="form-select mb-3" required>
        <?php
          $list = $conn->query("SELECT * FROM mascota_edad");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_age'] == $row['pet_age']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_age']}' $sel>{$opt['pet_age_name']}</option>";
          }
        ?>
      </select>

      <!-- Color primario -->
      <label>Color 1</label>
      <select name="pet_color1" class="form-select mb-3" required>
        <?php
          $list = $conn->query("SELECT * FROM mascota_color");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_color'] == $row['pet_color1']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_color']}' $sel>{$opt['pet_color_name']}</option>";
          }
        ?>
      </select>

      <!-- Color secundario -->
      <label>Color 2</label>
      <select name="pet_color2" class="form-select mb-3">
        <option value="">--Sin color secundario--</option>
        <?php
          $list = $conn->query("SELECT * FROM mascota_color");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_color'] == $row['pet_color2']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_color']}' $sel>{$opt['pet_color_name']}</option>";
          }
        ?>
      </select>

      <!-- Disponibilidad -->
      <label>Estado (pet_avail)</label>
      <select name="pet_avail" class="form-select mb-3" required>
        <?php
          $list = $conn->query("SELECT * FROM mascota_estado");
          while ($opt = $list->fetch_assoc()) {
            $sel = ($opt['ID_pet_status'] == $row['pet_avail']) ? "selected" : "";
            echo "<option value='{$opt['ID_pet_status']}' $sel>{$opt['status_name']}</option>";
          }
        ?>
      </select>

      <!-- Foto -->
      <label>Foto actual</label><br>
      <?php if ($row['pet_photo']) { ?>
        <img src="uploads/<?php echo $row['pet_photo']; ?>" width="150" class="mb-3">
      <?php } else { echo "<p class='text-muted'>Sin foto</p>"; } ?>

      <label>Cambiar foto</label>
      <input type="file" name="pet_photo" class="form-control mb-3">

      <div class="text-center">
        <button type="submit" class="btn btn-danger">Grabar</button>
        <a href="abmmascotas.php" class="btn btn-dark">Volver</a>
      </div>

    </form>

  </div>

</body>

</html>