<?php
include("../conexion.php");

$id = $_POST['id_pet_med'];

$vax_moq    = $_POST['vax_moq'];
$vax_parvo  = $_POST['vax_parvo'];
$vax_rab    = $_POST['vax_rab'];
$vax_lepto  = $_POST['vax_lepto'];
$vax_hep    = $_POST['vax_hep'];
$vax_rino   = $_POST['vax_rino'];
$vax_calci  = $_POST['vax_calci'];
$vax_panleuc= $_POST['vax_panleuc'];
$neut       = $_POST['neut'];
$paras      = $_POST['paras'];

$sql = "UPDATE mascotas_hist_medico SET
          vax_moq='$vax_moq',
          vax_parvo='$vax_parvo',
          vax_rab='$vax_rab',
          vax_lepto='$vax_lepto',
          vax_hep='$vax_hep',
          vax_rino='$vax_rino',
          vax_calci='$vax_calci',
          vax_panleuc='$vax_panleuc',
          neut='$neut',
          paras='$paras'
        WHERE id_pet_med=$id";

if ($conn->query($sql)) {
    echo "<script>alert('Historial actualizado correctamente'); window.location='../index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
