<?php
include("../conexion.php");

$id     = intval($_POST['id_pet']);
$nombre = $_POST['pet_name'];
$raza   = $_POST['pet_breed'];
$spec   = intval($_POST['pet_species']);
$sexo   = intval($_POST['pet_sex']);
$edad   = intval($_POST['pet_age']);
$color1 = intval($_POST['pet_color1']);
$color2 = empty($_POST['pet_color2']) ? "NULL" : intval($_POST['pet_color2']);
$estado = intval($_POST['pet_avail']);
$foto   = $_POST['pet_photo']; 

$sql = "
UPDATE mascotas SET
  pet_name='$nombre',
  pet_breed='$raza',
  pet_species=$spec,
  pet_sex=$sexo,
  pet_age=$edad,
  pet_color1=$color1,
  pet_color2=$color2,
  pet_avail=$estado,
  pet_photo='$foto'
  WHERE ID_pet=$id
";

if ($conn->query($sql)) {
    echo "<script>alert('Mascota actualizada correctamente'); window.location='tabla_mascotas.php';</script>";
} else {
    echo "Error: " . $conn->error . "<br><br> SQL: " . $sql;
}
?>
