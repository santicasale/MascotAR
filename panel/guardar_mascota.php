<?php
include("../conexion.php");

$id     = $_POST['id_pet'];
$nombre = $_POST['pet_name'];
$raza   = $_POST['pet_breed'];
$spec   = $_POST['pet_species'];
$sexo   = $_POST['pet_sex'];
$edad   = $_POST['pet_age'];
$color1 = $_POST['pet_color1'];
$color2 = $_POST['pet_color2'] ?: "NULL";
$estado = $_POST['pet_avail'];

// FOTO
$foto = "";

if (!empty($_FILES['pet_photo']['name'])) {
    $foto = time() . "_" . $_FILES['pet_photo']['name'];
    move_uploaded_file($_FILES['pet_photo']['tmp_name'], "uploads/" . $foto);

    $sql = "UPDATE mascotas SET
      pet_name='$nombre',
      pet_breed='$raza',
      pet_species=$spec,
      pet_sex=$sexo,
      pet_age=$edad,
      pet_color1=$color1,
      pet_color2=$color2,
      pet_avail=$estado,
      pet_photo='$foto'
      WHERE id_pet=$id";
} else {
    $sql = "UPDATE mascotas SET
      pet_name='$nombre',
      pet_breed='$raza',
      pet_species=$spec,
      pet_sex=$sexo,
      pet_age=$edad,
      pet_color1=$color1,
      pet_color2=$color2,
      pet_avail=$estado
      WHERE id_pet=$id";
}

if ($conn->query($sql)) {
    echo "<script>alert('Mascota actualizada correctamente'); window.location='mascotas.php.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>