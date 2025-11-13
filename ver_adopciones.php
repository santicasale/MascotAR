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
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    <div class="header-container">
      <div class="logo">
        <img src="imagenesong/logomascotar.png" alt="Logo MascotAR">
      </div>

      <nav>
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li>
            <a href="index.php#nosotros">Quiénes Somos</a>
            <ul class="submenu">
              <li><a href="prensa.html">Prensa</a></li>
            </ul>
          </li>
          <li><a href="donacion.php">Donar</a></li>
          <li>
              <a href="adoptar.php">Adoptar</a>
               <ul class="submenu">
                   <li><a href="adoptados.php">Adoptados</a></li>
              </ul>
          </li>

          <li class="user-menu">
            <?php if (isset($_SESSION['nick'])): ?>
            <li class="user-menu">
              <!-- Usuario logueado -->
              <a href="#"><i class="fas fa-user"></i> Hola, <?php echo htmlspecialchars($_SESSION['nick']); ?></a>
              <ul class="submenu">
                  
                <?php if (!empty($_SESSION['admin']) && $_SESSION['admin'] == "SÍ"): ?>
                  <!-- Menú exclusivo para administradores -->
                  <li><a href="ver_donaciones.php">Ver donaciones</a></li>
                  <li><a href="ver_adopciones.php">Ver adopciones</a></li>
                  <li><a href="ver_consultas.php">Ver Consultas</a></li>
                  <li><a href="ingreso_mascotas.php">Ingreso de mascotas</a></li>
                  <hr>
                <?php endif; ?>
                <li><a href="historial_donaciones.php">Historial de donaciones</a></li>
                <li><a href="historial_adopciones.php">Historial de adopciones</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
              </ul>
            <?php else: ?>
              <!-- Usuario NO logueado -->
              <li class="user-menu">
                <a href="#"><i class="fas fa-user"></i></a>
                <ul class="submenu login-submenu">
                  <li>
                    <form class="login-form" action="login.php" method="post">
                      <h3>Iniciar sesión</h3>
                      <input type="email" name="email" placeholder="Ingrese su correo" required>
                      <input type="password" name="pass" placeholder="Ingrese su contraseña" required>
                      <button type="submit">Entrar</button>
                    </form>
                    <p class="register-link">
                      ¿No tenés cuenta? <a href="registrarse.php">Registrate</a>
                    </p>
                  </li>
              </ul>
            </li>
          <?php endif; ?>
          </li>
        </ul>
      </nav>
    </div>
  </header>

<section class="about">
  <div class="ver-admin-container">
    <h2>Adopciones realizadas</h2> 
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

