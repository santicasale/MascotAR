<?php
session_start();
include("conexion.php");
// Solo admins
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ") {
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

// Si se envió acción (aprobar o rechazar)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_adopt'], $_POST['accion'])) {
    // 1. Obtener y sanitizar datos (¡Sanitizar es vital aquí!)
    $id_adopt = intval($_POST['id_adopt']);
    $accion = $_POST['accion'];

    // 2. Determinar el nuevo estado
    $nuevo_estado = 0;

    if ($accion === "aprobar") {
        $nuevo_estado = 2;
    } elseif ($accion === "rechazar") {
        $nuevo_estado = 3;
    } else {
        exit("Acción inválida.");
    }

    $sql_update_adopcion = "UPDATE adopciones SET adopcion_status = $nuevo_estado WHERE id_adopt = $id_adopt";
    $conn->query($sql_update_adopcion);

    if ($accion === "aprobar") {
        // pet_avail = 3 (no disponible)
        $sql_update_pet = "
            UPDATE mascotas m
            INNER JOIN adopciones a ON m.id_pet = a.id_pet_adopt
            SET m.pet_avail = 3
            WHERE a.id_adopt = $id_adopt;
        ";
        $conn->query($sql_update_pet);
    }

    echo "<script>alert('Estado actualizado correctamente.'); window.location.href='ver_adopciones.php';</script>";
    exit;
}

// Consulta principal
$sql = "
SELECT
  a.id_adopt,
  m.pet_name,
  u.nick AS adoptante,
  e.adopt_status, 
  a.motivo,
  a.mascotas_previas,
  v.tipo_vivienda
FROM
  adopciones a
  INNER JOIN mascotas m ON a.id_pet_adopt = m.id_pet
  LEFT JOIN usuario u ON a.id_user_adopt = u.id_user
  LEFT JOIN adopt_vivienda v ON a.id_vivienda = v.id_vivienda
  LEFT JOIN adopt_estado e ON a.adopcion_status = e.id_adopt_status 
ORDER BY a.id_adopt DESC;
";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Adopciones - MascotAR</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      margin: auto;
      background: white;
      border-collapse: collapse;
      width: 90%;
    }
    th, td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ccc;
    }
    th {
      background-color: #ffcc80;
    }
    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      color: white;
      font-weight: bold;
    }
    .aprobar { background-color: #4CAF50; } /* Verde */
    .rechazar { background-color: #f44336; } /* Rojo */
  </style>
</head>
<body>

<header>
  <h1 style="text-align:center; margin:20px;">Adopciones Realizadas</h1>
</header>

<section class="about">
  <div class="about-container">
    <?php if ($res->num_rows > 0): ?>
      <table>
        <tr>
          <th>Nro de adopción</th>
          <th>Mascota</th>
          <th>Adoptante</th>
          <th>Estado</th>
          <th>Motivo</th>
          <th>Mascotas Previas</th>
          <th>Tipo de Vivienda</th>
          <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_adopt']; ?></td>
            <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
            <td><?php echo htmlspecialchars($row['adoptante'] ?? 'Presencial'); ?></td>
            <td><?php echo htmlspecialchars($row['adopt_status']); ?></td>
            <td><?php echo htmlspecialchars($row['motivo']); ?></td>
            <td><?php echo htmlspecialchars($row['mascotas_previas'] ?? 'N/A'); ?></td>
            <td><?php echo htmlspecialchars($row['tipo_vivienda'] ?? 'N/A'); ?></td>
            <td>
              <?php if ($row['adopt_status'] === "PENDIENTE"): ?>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="id_adopt" value="<?php echo $row['id_adopt']; ?>">
                  <input type="hidden" name="accion" value="aprobar">
                  <button type="submit" class="btn aprobar">Aprobar</button>
                </form>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="id_adopt" value="<?php echo $row['id_adopt']; ?>">
                  <input type="hidden" name="accion" value="rechazar">
                  <button type="submit" class="btn rechazar">Rechazar</button>
                </form>
              <?php else: ?>
                <em><?php echo $row['adopt_status']; ?></em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="text-align:center;">No hay adopciones registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="panel_admin.php" class="btn" style="background:#2196F3;">⬅ Volver al panel</a>
</p>

</body>
</html>
