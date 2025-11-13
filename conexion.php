<?php
$servername = "sql111.infinityfree.com";
$username = "if0_40132447";
$password = "1zY0LORQz4gMI4";
$dbname = "if0_40132447_mascotar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} 
?>
