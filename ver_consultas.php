<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != "SÍ"){
  echo "<script>alert('Acceso denegado.'); window.location.href='index.php';</script>";
  exit;
}

$sql = "SELECT id_ask, email, msg FROM ask ORDER BY id_ask ASC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ver consultas</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1 style="text-align:center; margin:20px;">Consultas de usuarios</h1>
</header>

<section class="about">
  <div class="about-container">
    <?php if ($res->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0" style="margin:auto; background:white; border-collapse:collapse; width:90%;">
        <tr style="background-color:#ffcc80;">
          <th>ID</th>
          <th>Email</th>
          <th>Consulta</th>
          <th>Respuesta</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_ask']; ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['msg']); ?></td>
            <td style="width: 25%;">
              <form action="responder_consulta.php" method="POST" style="display:inline;">
                <input type="hidden" name="id_ask" value="<?php echo $row['id_ask']; ?>">

                <textarea
                  name="respuesta"
                  rows="3"
                  cols="30"
                  placeholder="Escribe tu respuesta aquí..."
                  required
                  class="respuesta-textarea"
                ></textarea><br>

                <button
                  type="submit"
                  class="respuesta-button"
                >
                  Enviar Respuesta
                </button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p style="text-align:center;">No hay consultas registradas.</p>
    <?php endif; ?>
  </div>
</section>

<p style="text-align:center; margin:20px;">
  <a href="index.php" class="btn">⬅ Volver al inicio</a>
</p>

</body>
</html>