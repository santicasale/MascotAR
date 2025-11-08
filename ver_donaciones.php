<?php
session_start();
include("conexion.php");

// Solo admins
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
    exit;
}

// LÓGICA DEL FILTRO (se mantiene igual)
$filtro_de_estado = '';
$tipo_de_estado = '';

if (isset($_GET['status']) && in_array($_GET['status'], ['1', '2'])) {
    $filtro_de_estado = $_GET['status'];
    $tipo_de_estado = " WHERE donacion_status = '" . $conn->real_escape_string($filtro_de_estado) . "'";
}

// Consulta SQL
$sql = "SELECT id_donacion, monto, name, email, fecha, donacion_status, comprobante_mp
        FROM donaciones " . $tipo_de_estado . " ORDER BY fecha DESC";

$res = $conn->query($sql);
if (!$res) {
    die("Error en la consulta SQL: " . $conn->error);
}

// Lógica para mostrar mensajes de estado (si viene de aprobar_donacion.php)
$status_message = '';
if (isset($_GET['action_status'])) {
    if ($_GET['action_status'] == 'success') {
        $status_message = '<p style="color: green; font-weight: bold; text-align: center;">Estado de donación actualizado a APROBADA (2).</p>';
    } elseif ($_GET['action_status'] == 'error') {
        $status_message = '<p style="color: red; font-weight: bold; text-align: center;">Error al actualizar el estado de la donación.</p>';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Donaciones - MascotAR</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header>
    <h1 style="text-align:center; margin:20px;">Donaciones Recibidas</h1>
</header>

<section class="about">
    <div class="about-container">
        
        <?php echo $status_message; // Muestra el mensaje de estado ?>

        <div style="text-align:center; margin-bottom: 20px;">
            <strong>Filtrar por Estado:</strong>
            <a href="ver_donaciones.php" style="margin-left: 15px; text-decoration: none; padding: 5px 10px; border: 1px solid #ccc; background-color: <?php echo $filtro_de_estado == '' ? '#ffcc80' : '#f4f4f4'; ?>;">Ver Todo</a>
            <a href="ver_donaciones.php?status=1" style="margin-left: 15px; text-decoration: none; padding: 5px 10px; border: 1px solid #ccc; background-color: <?php echo $filtro_de_estado == '1' ? '#ffcc80' : '#f4f4f4'; ?>;">Pendientes (1)</a>
            <a href="ver_donaciones.php?status=2" style="margin-left: 15px; text-decoration: none; padding: 5px 10px; border: 1px solid #ccc; background-color: <?php echo $filtro_de_estado == '2' ? '#ffcc80' : '#f4f4f4'; ?>;">Aprobadas (2)</a>
        </div>
        
        <?php if ($res->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
                <tr style="background-color:#ffcc80;">
                    <th>ID</th>
                    <th>Monto</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Comprobante MP</th> 
                    <th>Acción</th> </tr>
                <?php while ($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_donacion']; ?></td>
                        <td>$<?php echo number_format($row['monto'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td> 
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['donacion_status']); ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td>
                            <?php 
                            $comprobante_mp = htmlspecialchars($row['comprobante_mp']);
                            if (!empty($comprobante_mp)) {
                                echo '<a href="' . $comprobante_mp . '" target="_blank" style="color:blue;">Ver Comprobante</a>';
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        
                        <td>
                            <?php if ($row['donacion_status'] == 1): ?>
                                <a class="btn" href="aprobar_donacion.php?id= <?php echo $row['id_donacion']; ?>" 
                                   onclick="return confirm('¿Estás seguro de que deseas APROBAR esta donación?');">
                                    Aprobar
                                </a>
                            <?php else: ?>
                                Aprobada
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center;">No hay donaciones registradas con el filtro actual.</p>
        <?php endif; ?>
    </div>
</section>

<p style="text-align:center; margin:20px;">
    <a href="panel_admin.php" class="btn">⬅ Volver al panel</a>
</p>

</body>
</html>