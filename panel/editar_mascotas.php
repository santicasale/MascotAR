<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

$id = intval($_GET['Id']);

$sql = $conn->query("SELECT * FROM mascotas WHERE ID_pet = $id");
$data = $sql->fetch_assoc();

$especies = $conn->query("SELECT id_pet_species, pet_species FROM mascota_especie");
$sexos = $conn->query("SELECT id_pet_sex, pet_sex FROM mascota_sexo");
$edades = $conn->query("SELECT id_pet_age, pet_age FROM mascota_edad");
$colores = $conn->query("SELECT id_pet_color, pet_color FROM mascota_color");
$estados = $conn->query("SELECT id_pet_status, pet_status FROM mascota_estado");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['pet_name'];
    $species = $_POST['pet_species'];
    $breed = $_POST['pet_breed'];
    $sex = $_POST['pet_sex'];
    $age = $_POST['pet_age'];
    $color1 = $_POST['pet_color1'];
    $color2 = $_POST['pet_color2'] ?: NULL;
    $photo = $_POST['pet_photo'];
    $avail = $_POST['pet_avail'];

    $sql = $conn->prepare("
        UPDATE mascotas
        SET pet_name=?, pet_species=?, pet_breed=?, pet_sex=?, pet_age=?, pet_color1=?, pet_color2=?, pet_photo=?, pet_avail=?
        WHERE ID_pet=?
    ");
    $sql->bind_param("sisiiiissi", $name, $species, $breed, $sex, $age, $color1, $color2, $photo, $avail, $id);
    $sql->execute();

    header("Location: tabla_mascotas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Mascota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Mascota</h1>
    <div class="container mt-3">
        <form class="row" action="guardar_mascotas.php" method="POST">
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
                <?php while ($c = $colores->fetch_assoc()) { ?>
                    <option value="<?= $c['id_pet_color'] ?>" <?= $c['id_pet_color'] == $data['pet_color1'] ? 'selected' : '' ?>>
                        <?= $c['pet_color'] ?>
                    </option>
                <?php } ?>
            </select>

            <label>Color 2 (opcional):</label>
            <select name="pet_color2" class="form-select mb-3">
                <option value="">Ninguno</option>
                <?php
                $colores->data_seek(0); 
                while ($c = $colores->fetch_assoc()) { ?>
                    <option value="<?= $c['id_pet_color'] ?>" <?= $c['id_pet_color'] == $data['pet_color2'] ? 'selected' : '' ?>>
                        <?= $c['pet_color'] ?>
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
