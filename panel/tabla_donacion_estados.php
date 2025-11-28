<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}
$email_usuario = $_SESSION['email'];
$sql = " SELECT d.id_donacion, d.monto, d.fecha, e.don_status, d.comprobante_mp
  FROM donaciones d
  INNER JOIN donacion_estado e ON d.donacion_status = e.id_don_status
  WHERE d.email = ?
  ORDER BY d.fecha DESC";
$historial = $conn->prepare($sql);
$historial->bind_param("s", $email_usuario);
$historial->execute();
$res = $historial->get_result();
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
<body>


 <header>
    <div class="header-container">
      <div class="logo">
        <img src="../imagenesong/logomascotar.png" alt="Logo MascotAR">
      </div>

      <nav>
        <ul>
          <li><a href="index.php">Inicio</a></li>
          <li>
            <a href="index.php#nosotros">Quiénes Somos</a>
            <ul class="submenu">
              <li><a href="prensa.php">Prensa</a></li>
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
    <h2>tabla de Usuarios</h2> 
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0"style="margin:auto; background:white; border-collapse:collapse; width:90%; font-family:Open Sans;">
        <tr style="background-color:#ffcc80; text-align:center;">
          <th>ID</th>
          <th>Fecha</th>
          <th>Monto</th>
          <th>Estado</th>
          <th>Comprobante</th>
          <th>Acciones</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr style="text-align:center;">
          <td><?= $row['id_donacion'] ?></td>
          <td><?= htmlspecialchars($row['fecha']) ?></td>
          <td>$ <?= htmlspecialchars($row['monto']) ?></td>
          <td><?= htmlspecialchars($row['don_status']) ?></td>
          <td>
          <?php if (!empty($row['comprobante_mp'])): ?>
            <a href="../ver_comprobante.php?id=<?= $row['id_donacion'] ?>" target="_blank" style="color:#0077cc;">Ver comprobante</a>
            <?php else: ?>
              -
               <?php endif; ?>
          </td>
          <td>
            <a href="editar_donacion_estado.php?id=<?= $row['id_donacion'] ?>" class="btn-table btn-warning" style="margin-right:5px;">Editar</a>
            <a href="eliminar_donacion_estado.php?id=<?= $row['id_donacion'] ?>"  class="btn-table btn-danger">Eliminar</a>
          </td>
         </tr>
         <?php endwhile; ?>

        </table>
    <?php else: ?>
      <p style="text-align:center;">No hay estados de donaciones registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>
<?php
$historial->close();
$conn->close();
?>
