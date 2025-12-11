<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Discapacidad de Mascota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Discapacidad de Mascota</h1>

<div class="container mt-4">

<?php
include("../conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM mascotas_discapacidad WHERE id_pet_disabl = $id LIMIT 1";
$res = $conn->query($sql);
$row = $res->fetch_assoc();

if (!$row) {
    $conn->query("INSERT INTO mascotas_discapacidad (id_pet_disabl, disabl_blind, disabl_deaf, disabl_limp)
                  VALUES ($id, 'NO','NO','NO')");
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
}

function selectYN($campo, $valor) {
    $s1 = ($valor == "SÍ") ? "selected" : "";
    $s2 = ($valor == "NO") ? "selected" : "";
    return "
      <select name='$campo' class='form-select mb-3' required>
        <option value='SÍ' $s1>SÍ</option>
        <option value='NO' $s2>NO</option>
      </select>
    ";
}
?>

<form action="guardar_mascotas_disc.php" method="POST">

    <input type="hidden" name="id_pet_disabl" value="<?php echo $id; ?>">

    <label>Ciego</label>
    <?php echo selectYN('disabl_blind', $row['disabl_blind']); ?>

    <label>Sordo</label>
    <?php echo selectYN('disabl_deaf', $row['disabl_deaf']); ?>

    <label>Lisiado</label>
    <?php echo selectYN('disabl_limp', $row['disabl_limp']); ?>

    <div class="text-center">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="javascript:history.back()" class="btn btn-dark">Volver</a>
      </div>
</form>

</div>

</body>
</html>
