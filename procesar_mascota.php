<?php
include("conexion.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pet_name = $_POST['pet_name'];
$pet_species = $_POST['pet_species'];
$pet_breed = $_POST['pet_breed'];
$pet_sex = $_POST['pet_sex'];
$pet_age = $_POST['pet_age'];
$pet_color1 = $_POST['pet_color1'];
$pet_color2 = $_POST['pet_color2'] ?: NULL;
$pet_photo = $_POST['pet_photo'];

// 1️⃣ Insertar mascota
$mascota_nueva = $conn->prepare("INSERT INTO mascotas (pet_species, pet_name, pet_breed, pet_sex, pet_age, pet_color1, pet_color2, pet_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$mascota_nueva->bind_param("issiiiis", $pet_species, $pet_name, $pet_breed, $pet_sex, $pet_age, $pet_color1, $pet_color2, $pet_photo);
$mascota_nueva->execute();
$id_pet = $mascota_nueva->insert_id;

// 2️⃣ Historial médico
$hist_medico = $conn->prepare("INSERT INTO mascotas_hist_medico (id_pet_med, vax_moq, vax_parvo, vax_rab, vax_lepto, vax_hep, vax_rino, vax_calci, vax_panleuc, neut, paras)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$hist_medico->bind_param("issssssssss", $id_pet,
  $_POST['vax_moq'], $_POST['vax_parvo'], $_POST['vax_rab'],
  $_POST['vax_lepto'], $_POST['vax_hep'], $_POST['vax_rino'],
  $_POST['vax_calci'], $_POST['vax_panleuc'], $_POST['neut'], $_POST['paras']);
$hist_medico->execute();

// 3️⃣ Discapacidad
$discapacidad = $conn->prepare("INSERT INTO mascotas_discapacidad (id_pet_disabl, disabl_blind, disabl_deaf, disabl_limp)
                         VALUES (?, ?, ?, ?)");
$discapacidad->bind_param("isss", $id_pet, $_POST['disabl_blind'], $_POST['disabl_deaf'], $_POST['disabl_limp']);
$discapacidad->execute();

echo "Mascota registrada correctamente.";
?>
