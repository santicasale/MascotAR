<?php
session_start();
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Mascotar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="cambiar-pass">
<div class="cambiar-pass-box">
    <h2>Cambiar Contraseña</h2>
    <form action="procesar_pass.php"method="POST" >
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" placeholder="Ingrese su email" required>

        <label for="pass_actual">Contraseña actual:</label>
        <input type="password" name="pass_actual" id="pass_actual" placeholder="Ingrese su contraseña actual" required>

        <label for="nuevo_pass">Nueva contraseña:</label>
        <input type="password" name="nuevo_pass" id="nuevo_pass" placeholder="Ingrese nueva contraseña" required>

        <label for="confirmar_pass">Confirmar nueva contraseña:</label>
        <input type="password" name="confirmar_pass" id="confirmar_pass" placeholder="Repita la nueva contraseña" required>

        <button type="submit">Actualizar Contraseña</button>
    </form>
</div>
</body>
</html>
