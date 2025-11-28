<?php
require("conexion.php");

$id   = $_GET['Id']; 
    $sql = "update ooss_especialidad set activo=0 where id=".$id ; 
    //$sql = "DELETE FROM ooss_especialidad where id=".$id ; 
    $resultado = mysqli_query($conn, $sql); 
    if($resultado === TRUE){
        header("location: abmatencion.php"); 
    } else {
        echo "Datos NO eliminados"; 
    }

