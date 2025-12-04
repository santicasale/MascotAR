<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Obtener datos actuales
$sql = $conn->query("SELECT * FROM adopciones WHERE id_adopt = $id");
$data = $sql->fetch_assoc();

// Cargar selects
$mascotas = $conn->query("SELECT id_pet, pet_name FROM mascotas");
$usuarios = $conn->query("SELECT id_user, nick FROM usuario");
$estados = $conn->query("SELECT id_adopt_status, adopt_status FROM adopt_estado");
$viviendas = $conn->query("SELECT id_vivienda, tipo_vivienda FROM adopt_vivienda");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pet = $_POST['id_pet_adopt'];
    $user = $_POST['id_user_adopt'];
    $motivo = $_POST['motivo'];
    $previas = $_POST['mascotas_previas'];
    $estado = $_POST['adopcion_status'];
    $vivienda = $_POST['id_vivienda'];

    $sql = $conn->prepare("
        UPDATE adopciones
        SET id_pet_adopt=?, id_user_adopt=?, motivo=?, mascotas_previas=?, adopcion_status=?, id_vivienda=?
        WHERE id_adopt=?
    ");
    $sql->bind_param("iissiii", $pet, $user, $motivo, $previas, $estado, $vivienda, $id);
    $sql->execute();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ver consultas</title>
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
</head>

<body class="p-4">

<h2>Editar Adopción</h2>

<form method="POST">
    <label>Mascota:</label>
    <select name="id_pet_adopt" class="form-select mb-3">
        <?php while ($m = $mascotas->fetch_assoc()) { ?>
            <option value="<?= $m['id_pet'] ?>" <?= $m['id_pet'] == $data['id_pet_adopt'] ? 'selected' : '' ?>>
                <?= $m['pet_name'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Usuario:</label>
    <select name="id_user_adopt" class="form-select mb-3">
        <?php while ($u = $usuarios->fetch_assoc()) { ?>
           <option value="<?= $u['id_user'] ?>" <?= $u['id_user'] == $data['id_user_adopt'] ? 'selected' : '' ?>>
                <?= $u['nick'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Motivo:</label>
    <textarea name="motivo" class="form-control mb-3"><?= $data['motivo'] ?></textarea>

    <label>Mascotas Previas:</label>
    <select name="mascotas_previas" class="form-select mb-3">
        <option value="SÍ" <?= $data['mascotas_previas'] == "SÍ" ? 'selected' : '' ?>>SÍ</option>
        <option value="NO" <?= $data['mascotas_previas'] == "NO" ? 'selected' : '' ?>>NO</option>
    </select>

    <label>Estado:</label>
    <select name="adopcion_status" class="form-select mb-3">
        <?php while ($e = $estados->fetch_assoc()) { ?>
            <option value="<?= $e['id_adopt_status'] ?>" <?= $e['id_adopt_status'] == $data['adopcion_status'] ? 'selected' : '' ?>>
                <?= $e['adopt_status'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Vivienda:</label>
    <select name="id_vivienda" class="form-select mb-3">
        <?php while ($v = $viviendas->fetch_assoc()) { ?>
            <option value="<?= $v['id_vivienda'] ?>" <?= $v['id_vivienda'] == $data['id_vivienda'] ? 'selected' : '' ?>>
                <?= $v['tipo_vivienda'] ?>
            </option>
        <?php } ?>
    </select>

    <button class="btn btn-primary">Actualizar</button>
</form>

</body>
</html>