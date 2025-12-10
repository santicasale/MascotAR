<?php
include("../conexion.php");

$id = $_POST['id_user'];

$f_name = $_POST['f_name'];
$l_name = $_POST['l_name'];
$nick = $_POST['nick'];
$email = $_POST['email'];
$birthday = $_POST['birthday'];
$phone = $_POST['phone'];
$admin = $_POST['admin'];

$sql = "UPDATE usuario SET
          f_name='$f_name',
          l_name='$l_name',
          nick='$nick',
          email='$email',
          birthday='$birthday',
          phone='$phone',
          admin='$admin'
        WHERE id_user=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Usuario actualizado correctamente'); window.location='tabla_usuarios.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
