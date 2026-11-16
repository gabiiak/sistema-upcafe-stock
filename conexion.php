<?php
//date_default_timezone_set('America/Argentina/Buenos_Aires'); 

$host = "localhost"; 
$user = "root"; 
$pass = "contraseña"; 
$db   = "stockdb"; 

// Crear conexión
$conexion = new mysqli($host, $user, $pass, $db);
$conexion->query("SET time_zone = '-03:00'");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión");
}
$conexion->set_charset("utf8"); // Establecer el conjunto de caracteres a UTF-8 (para no leer tildes y ñ como símbolos raros)
?>
