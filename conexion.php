<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "mascotar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>