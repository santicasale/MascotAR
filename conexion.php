<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "MascotAR";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
