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

$sql = "UPDATE usuario SET f_name = ?, l_name = ?, nick = ?, email = ?, birthday = ?, phone = ?, admin = ? WHERE id_user = ?";

$act = $conn->prepare($sql);
$act->bind_param("sssssssi", $f_name, $l_name, $nick, $email, $birthday, $phone, $admin,$id);

if ($act->execute()) {
    echo "<script>alert('Usuario actualizado correctamente'); window.location='tabla_usuarios.php';</script>";
} else {
    echo "Error: " . $act->error;
}

$act->close();
$conn->close();
?>
