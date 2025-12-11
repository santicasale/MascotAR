<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include("conexion.php");

$f_name   = $_POST['f_name'];
$l_name   = $_POST['l_name'];
$nick     = $_POST['nick'];
$pass     = $_POST['pass'];
$email    = $_POST['email'];
$birthday = $_POST['birthday'];
$phone    = $_POST['phone'];
$domicilio = $_POST['domicilio'];
$admin = 'NO';

$check = "SELECT * FROM usuario WHERE email='$email' OR nick='$nick'";
$result = $conn->query($check);
if ($result->num_rows > 0) {
    echo "<script>alert('El email o nombre de usuario ya están registrados.');window.history.back();</script>";
} else {
    $sql = $conn->prepare(
    "INSERT INTO usuario (f_name, l_name, nick, pass, email, birthday, phone, domicilio, admin)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $sql->bind_param("sssssssss", $f_name, $l_name, $nick, $pass, $email, $birthday, $phone, $domicilio, $admin);
    if (!$sql->execute()) {
        echo "<script>alert('Error al registrar usuario: " . $conn->error . "'); window.history.back(); </script>";
        exit();
    }

    if ($conn->query($sql) === TRUE) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mascotaresba@gmail.com'; 
            $mail->Password   = 'toyd hpfr bxvi xlvg'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->setFrom('mascotaresba@gmail.com', 'Mascotar');
            $mail->addAddress($email, $nick);

            $mail->isHTML(true);
            $mail->Subject = 'Bienvenido a Mascotar';
            $mail->Body    = "
                <h2>¡Hola $nick!</h2>
                <p>Tu cuenta fue creada correctamente.</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>contraseña:</strong> $pass</p>
                <p>Si deseás cambiar tu contraseña, hacé clic aquí:</p>
                <a href='https://mascotar.wuaze.com/cambiar_pass.php'>Cambiar contraseña</a>
                <br><br>
                <p>Gracias por formar parte de la comunidad Mascotar</p>
            ";

            $mail->send();

            echo "<script>
                    alert('Usuario registrado correctamente. Se envió un correo de bienvenida.');
                    window.location.href='index.php';
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Usuario registrado, pero no se pudo enviar el correo: {$mail->ErrorInfo}');
                    window.location.href='index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Error al registrar usuario: " . $conn->error . "');
                window.history.back();
              </script>";
    }
}

$conn->close();
?>