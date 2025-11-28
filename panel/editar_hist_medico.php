<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Historial Médico</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<h1 class="bg-dark p-2 text-white text-center">Historial Médico de Mascota</h1>

<div class="container mt-4">

<?php
include("../conexion.php");

$id = $_GET['id'];

// Obtener el historial
$sql = "SELECT * FROM mascotas_hist_medico WHERE id_pet_med = $id LIMIT 1";
$res = $conn->query($sql);
$row = $res->fetch_assoc();

// Si no existe historial aún, crear registro vacío
if (!$row) {
    $conn->query("INSERT INTO mascotas_hist_medico (id_pet_med, vax_moq, vax_parvo, vax_rab, vax_lepto, vax_hep, vax_rino, vax_calci, vax_panleuc, neut, paras) 
                  VALUES ($id, 'NO','NO','NO','NO','NO','NO','NO','NO','NO','NO')");
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

<form action="guardar_historial.php" method="POST">

    <input type="hidden" name="id_pet_med" value="<?php echo $id; ?>">

    <label>Vacuna Moquillo</label>
    <?php echo selectYN('vax_moq', $row['vax_moq']); ?>

    <label>Vacuna Parvovirus</label>
    <?php echo selectYN('vax_parvo', $row['vax_parvo']); ?>

    <label>Vacuna Rabia</label>
    <?php echo selectYN('vax_rab', $row['vax_rab']); ?>

    <label>Vacuna Leptospirosis</label>
    <?php echo selectYN('vax_lepto', $row['vax_lepto']); ?>

    <label>Vacuna Hepatitis</label>
    <?php echo selectYN('vax_hep', $row['vax_hep']); ?>

    <label>Vacuna Rinotraqueitis</label>
    <?php echo selectYN('vax_rino', $row['vax_rino']); ?>

    <label>Vacuna Calcivirus</label>
    <?php echo selectYN('vax_calci', $row['vax_calci']); ?>

    <label>Vacuna Panleucopenia</label>
    <?php echo selectYN('vax_panleuc', $row['vax_panleuc']); ?>

    <label>Castrado / Esterilizado</label>
    <?php echo selectYN('neut', $row['neut']); ?>

    <label>Desparasitado</label>
    <?php echo selectYN('paras', $row['paras']); ?>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-danger">Grabar</button>
        <a href="../index.php" class="btn btn-dark">Volver</a>
    </div>

</form>

</div>

</body>
</html>
