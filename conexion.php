<?php
$servername = "sql313.infinityfree.com";
$username = "if0_40059520"; 
$password = "MightyNo9";     
$dbname = "if0_40059520_mascotar";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
