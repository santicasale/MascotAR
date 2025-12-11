<?php
include("../conexion.php");

$id = intval($_GET['id']);
$res = $conn->query("SELECT * FROM donaciones WHERE id_donacion = $id");
$row = $res->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1 class="p-2 text-white text-center" style="background-color: #f15a29;">Editar Donacion estado</h1>
    <form action="guardar_donacion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_donacion" value="<?= $row['id_donacion'] ?>">
        <label>Monto:</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="<?= $row['monto'] ?>" required>

        <label>Nombre:</label>
        <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>">

        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>">

        <label>Estado:</label>
        <select name="donacion_status" class="form-control">
            <option value="1" <?= $row['donacion_status']==1?"selected":"" ?>>Pendiente</option>
            <option value="2" <?= $row['donacion_status']==2?"selected":"" ?>>Aprobada</option>
            <option value="3" <?= $row['donacion_status']==3?"selected":"" ?>>Cancelada</option>
        </select>

        <label>Reemplazar comprobante (opcional):</label>
        <input type="file" name="comprobante" class="form-control">

        <div class="text-center d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-success mt-3">Guardar</button>
            <a href="javascript:history.back()" class="btn btn-dark mt-3">Volver</a>
        </div>
    </form>

</body>
</html>