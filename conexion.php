<?php
$host = "localhost"; 
$user = "u892175625_appuser"; 
$pass = "UPcafeyalgorico91218"; 
$db   = "u892175625_stock"; 

// Crear conexión
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión");
}
$conexion->set_charset("utf8"); // Establecer el conjunto de caracteres a UTF-8 (para no leer tildes y ñ como símbolos raros)
?>
