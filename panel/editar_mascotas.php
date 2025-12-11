<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

// Traer ID
$id = intval($_GET['id']);

$sql = $conn->query("SELECT * FROM mascotas WHERE ID_pet = $id");
$data = $sql->fetch_assoc();

$especies = $conn->query("SELECT * FROM mascota_especie");
$sexos = $conn->query("SELECT * FROM mascota_sexo");
$edades = $conn->query("SELECT * FROM mascota_edad");
$colores1 = $conn->query("SELECT * FROM mascota_color");
$colores2 = $conn->query("SELECT * FROM mascota_color");
$estados = $conn->query("SELECT * FROM mascota_estado");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Mascota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<h1 class="p-2 text-white text-center" style="background-color:#f15a29;">Editar Mascota</h1>

<div class="container mt-3">
    <form class="row" action="guardar_mascotas.php" method="POST">
        <input type="hidden" name="id_pet" value="<?= $data['id_pet'] ?>">

        <label>Nombre:</label>
        <input type="text" name="pet_name" value="<?= $data['pet_name'] ?>" class="form-control mb-3" required>

        <label>Especie:</label>
        <select name="pet_species" class="form-select mb-3" required>
            <?php while ($e = $especies->fetch_assoc()) { ?>
                <option value="<?= $e['id_pet_species'] ?>" <?= $e['id_pet_species'] == $data['pet_species'] ? 'selected' : '' ?>>
                    <?= $e['pet_species'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Raza:</label>
        <input type="text" name="pet_breed" value="<?= $data['pet_breed'] ?>" class="form-control mb-3">

        <label>Sexo:</label>
        <select name="pet_sex" class="form-select mb-3" required>
            <?php while ($s = $sexos->fetch_assoc()) { ?>
                <option value="<?= $s['id_pet_sex'] ?>" <?= $s['id_pet_sex'] == $data['pet_sex'] ? 'selected' : '' ?>>
                    <?= $s['pet_sex'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Edad:</label>
        <select name="pet_age" class="form-select mb-3" required>
            <?php while ($a = $edades->fetch_assoc()) { ?>
                <option value="<?= $a['id_pet_age'] ?>" <?= $a['id_pet_age'] == $data['pet_age'] ? 'selected' : '' ?>>
                    <?= $a['pet_age'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Color 1:</label>
        <select name="pet_color1" class="form-select mb-3" required>
            <?php while ($c = $colores1->fetch_assoc()) { ?>
                <option value="<?= $c['id_pet_color'] ?>" <?= $c['id_pet_color'] == $data['pet_color1'] ? 'selected' : '' ?>>
                    <?= $c['pet_color'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Color 2 (opcional):</label>
        <select name="pet_color2" class="form-select mb-3">
            <option value="">Ninguno</option>
            <?php while ($c2 = $colores2->fetch_assoc()) { ?>
                <option value="<?= $c2['id_pet_color'] ?>" <?= $c2['id_pet_color'] == $data['pet_color2'] ? 'selected' : '' ?>>
                    <?= $c2['pet_color'] ?>
                </option>
            <?php } ?>
        </select>

        <label>Link de la foto:</label>
        <input type="url" name="pet_photo" value="<?= $data['pet_photo'] ?>" class="form-control mb-3" required>

        <label>Estado:</label>
        <select name="pet_avail" class="form-select mb-3" required>
            <?php while ($st = $estados->fetch_assoc()) { ?>
                <option value="<?= $st['id_pet_status'] ?>" <?= $st['id_pet_status'] == $data['pet_avail'] ? 'selected' : '' ?>>
                    <?= $st['pet_status'] ?>
                </option>
            <?php } ?>
        </select>

        <div class="text-center d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-success mt-3">Guardar</button>
            <a href="javascript:history.back()" class="btn btn-dark mt-3">Volver</a>
        </div>

    </form>
</div>

</body>
</html>
