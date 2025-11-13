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

// Consulta SQL - verificar si comprobante existe usando LENGTH para no cargar el BLOB completo
$sql = "SELECT id_donacion, monto, name, email, fecha, donacion_status, 
        CASE WHEN comprobante_mp IS NOT NULL AND LENGTH(comprobante_mp) > 0 THEN 1 ELSE 0 END as tiene_comprobante
        FROM donaciones " . $tipo_de_estado . " ORDER BY fecha DESC";

$res = $conn->query($sql);
if (!$res) {
    die("Error en la consulta SQL: " . $conn->error);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Donaciones - MascotAR</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        <h2>Ver Donaciones</h2>       
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
                            // Verificar si hay comprobante usando el campo calculado
                            if (isset($row['tiene_comprobante']) && $row['tiene_comprobante'] == 1) {
                                echo '<a href="ver_comprobante.php?id=' . $row['id_donacion'] . '" target="_blank" style="color:blue; text-decoration:underline;">Ver Comprobante</a>';
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        
                        <td>
                            <?php if ($row['donacion_status'] == 1): ?>
                                <form method="POST" action="procesar_estado.php" style="display:inline;">
                                    <input type="hidden" name="id_donacion" value="<?php echo $row['id_donacion']; ?>">
                                    <input type="hidden" name="accion" value="aprobar">
                                    <button type="submit" class="btn aprobar" onclick="return confirm('¿Estás seguro de que deseas APROBAR esta donación?');">Aprobar</button>
                                </form>

                                <form method="POST" action="procesar_estado.php" style="display:inline;">
                                    <input type="hidden" name="id_donacion" value="<?php echo $row['id_donacion']; ?>">
                                    <input type="hidden" name="accion" value="rechazar">
                                    <button type="submit" class="btn rechazar" onclick="return confirm('¿Estás seguro de que deseas RECHAZAR esta donación?');">Rechazar</button>
                                </form>
                            <?php else: ?>
                                <?php echo $row['donacion_status'] == 2 ? 'Aprobada' : ($row['donacion_status'] == 3 ? 'Rechazada' : 'Otro'); ?>
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