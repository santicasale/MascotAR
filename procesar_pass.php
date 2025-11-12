<?php
session_start();
include("conexion.php");

$email =$_POST['email'];
$pass_actual =$_POST['pass_actual'];
$nuevo_pass = $_POST['nuevo_pass'];
$confirmar_pass = $_POST['confirmar_pass'];


if ($nuevo_pass !== $confirmar_pass){
    echo "<script>alert('las contraseñas nuevas no coinciden.'); window.history.back();</script>";
} 
else{
    $verificacion = "SELECT * FROM usuario WHERE email='$email' and pass='$pass_actual'";
    $result = $conn->query($verificacion);
    if ($result->num_rows > 0) {
        $update = "UPDATE usuario SET pass='$nuevo_pass' WHERE email='$email'";
        if ($conn->query($update) === TRUE) {
            echo "<script>alert('Contraseña actualizada correctamente. Iniciá sesión nuevamente.');window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar la contraseña.'); window.history.back();</script>";
        }} else {
            echo "<script>alert('Email o contraseña incorrectos'); window.history.back();</script>";
        }
} 
