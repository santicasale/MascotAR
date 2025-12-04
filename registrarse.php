<?php
session_start();
// Si el usuario ya está logueado, lo redirigimos al inicio
if (isset($_SESSION['nick'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse - MascotAR</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include("header.php"); ?>
<section class="register">
  <div class="register-container">
    <div class="register-form">
      <h2>Crear cuenta</h2>

      <form action="registrar.php" method="post">
        <span style="color:red;">*</span>
        <input type="text" name="f_name" placeholder="Nombre" required minlength="2" maxlength="25" pattern="[A-Za-z\u00C0-\u017F\s']{2,25}" title="Solo letras, tildes, apóstrofos y espacios, de 2 a 25 caracteres.">
        <input type="text" name="l_name" placeholder="Apellido" required minlength="2" maxlength="50" pattern="[A-Za-z\u00C0-\u017F\s']{2,50}" title="Solo letras, tildes, apóstrofos y espacios, de 2 a 50 caracteres.">
        <input type="text" name="nick" placeholder="Nombre de usuario" required minlength="3" maxlength="15" title="Nombre de usuario de 3 a 15 caracteres.">
        <input type="password" name="pass" placeholder="Contraseña" required minlength="6" maxlength="15" title="Contraseña de 6 a 15 caracteres.">
        <input type="email" name="email" placeholder="Email" required  minlength="6" maxlength="60" title="Email de 6 a 60 caracteres (incluyendo @).">
        <input type="date"  name="birthday" required min="1925-01-01"  max="2012-12-31" title="Fecha de nacimiento entre 1925 y 2012.">
        <input  type="tel"  name="phone"  placeholder="Telefono"  required  maxlength="10"  pattern="[0-9]{10}"title="Número de teléfono de exactamente 10 dígitos." >
        <input type="text" name="domicilio"  placeholder="domicilio"  required>
        <button type="submit">Registrarme</button>
      </form>

      <p>¿Ya tenés cuenta? <a href="index.php">Iniciá sesión</a></p>
    </div>

    <div class="register-image">
      <img src="imagenesong/perrosgatos.jpg" alt="Registro MascotAR">
    </div>
  </div>
</section>

<?php include("footer.php"); ?>
</body>
</html>