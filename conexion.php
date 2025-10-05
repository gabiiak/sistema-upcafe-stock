<?php
$host = "localhost"; 
$user = "root"; 
$pass = "contraseña"; 
$db   = "stockdb"; 

// Crear conexión
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión");
}
$conexion->set_charset("utf8"); // Establecer el conjunto de caracteres a UTF-8 (para no leer tildes y ñ como símbolos raros)
?>
