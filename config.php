<?php
// config.php
// === CONFIGURACIÓN DE BASE DE DATOS ===
define('DB_HOST', 'sql313.infinityfree.com');
define('DB_USER', 'if0_40059520');
define('DB_PASS', 'MightyNo9');
define('DB_NAME', 'if0_40059520_mascotar');  

// === CONFIGURACIÓN DE MERCADO PAGO ===
// Acces Token de pruebas o producción
define('MP_ACCESS_TOKEN', 'APP_USR-502327826682038-100521-ae23557030dcf30365aa3fa312265775-2906214560');

// === CONFIGURACIÓN DE RUTAS ===
define('BASE_URL', 'https://mascot-ar.kesug.com');
define('WEBHOOK_URL', BASE_URL . '/webhook.php');

// === OPCIONAL ===
error_reporting(E_ALL);
ini_set('display_errors', 0); // 0 = No mostrar en pantalla, 1 = mostrar errores
?>
