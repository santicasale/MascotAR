<?php
include("../conexion.php");

$id_pet_disabl = $_POST['id_pet_disabl'];

$disabl_blind = $_POST['disabl_blind'];
$disabl_deaf  = $_POST['disabl_deaf'];
$disabl_limp  = $_POST['disabl_limp'];

$sql = "UPDATE mascotas_discapacidad SET 
            disabl_blind = '$disabl_blind', 
            disabl_deaf  = '$disabl_deaf', 
            disabl_limp  = '$disabl_limp' 
        WHERE id_pet_disabl = $id_pet_disabl";

if ($conn->query($sql)) {
    echo "<script>alert('Discapacidades de la mascota fue actualizada correctamente'); window.location='tabla_mascotas_disc.php';</script>";
} else {
    echo "Error al actualizar la discapacidad de la mascota: " . $conn->error;
}

// 4. Cerrar conexión
$conn->close();
?>