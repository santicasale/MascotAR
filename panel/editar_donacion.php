<?php
include("../conexion.php");

$id = intval($_GET['id']);

// Obtener datos actuales
$query = $conn->query("SELECT * FROM donaciones WHERE id_donacion = $id");
$data = $query->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $monto = floatval($_POST['monto']);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $estado = intval($_POST['donacion_status']);

    // Si sube nuevo comprobante
    if (!empty($_FILES['comprobante']['tmp_name'])) {
        $comprobante = file_get_contents($_FILES['comprobante']['tmp_name']);
        $update = $conn->prepare("UPDATE donaciones SET monto=?, name=?, email=?, donacion_status=?, comprobante_mp=? WHERE id_donacion=?");
        $update->bind_param("dssisi", $monto, $name, $email, $estado, $comprobante, $id);
    } else {
        $update = $conn->prepare("UPDATE donaciones SET monto=?, name=?, email=?, donacion_status=? WHERE id_donacion=?");
        $update->bind_param("dssii", $monto, $name, $email, $estado, $id);
    }

    $update->execute();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Donación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<h2>Editar Donación</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Monto:</label>
    <input type="number" step="0.01" name="monto" class="form-control" value="<?= $data['monto'] ?>" required>

    <label>Nombre:</label>
    <input type="text" name="name" class="form-control" value="<?= $data['name'] ?>">

    <label>Email:</label>
    <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">

    <label>Estado:</label>
    <select name="donacion_status" class="form-control">
        <option value="1" <?= $data['donacion_status']==1?"selected":"" ?>>Pendiente</option>
        <option value="2" <?= $data['donacion_status']==2?"selected":"" ?>>Aprobada</option>
        <option value="3" <?= $data['donacion_status']==3?"selected":"" ?>>Rechazada</option>
    </select>

    <label>Reemplazar comprobante (opcional):</label>
    <input type="file" name="comprobante" class="form-control">

    <div class="text-center d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="index.php" class="btn btn-dark mt-3">Volver</a>
    </div>
</form>

</body>
</html>