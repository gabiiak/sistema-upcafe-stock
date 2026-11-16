<?php
include 'conexion.php'; 

// Inicializamos un mensaje para mostrar el resultado al usuario
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Capturar y sanear el ID
    // intval() es bueno, pero la consulta preparada hace el trabajo de seguridad
    $id_a_eliminar = intval($_POST['id']); 

    // 2. Preparar la Consulta (Usando ? para el ID)
    $sql = "DELETE FROM Productos WHERE id = ?";
    
    // Prepara la consulta para evitar inyecciones SQL
    $stmt = $conexion->prepare($sql);

    if ($stmt === FALSE) {
        $mensaje = "<p class='mensaje-error'>Error al preparar la consulta: " . $conexion->error . "</p>";
    } else {
        // 3. Vincular (Bind) el parámetro: 'i' = integer
        $stmt->bind_param("i", $id_a_eliminar);
        
        // 4. Ejecutar la Consulta
        if ($stmt->execute()) {
            // Verificar si alguna fila fue eliminada
            if ($stmt->affected_rows > 0) {
                $mensaje = "<p class='mensaje-exito'>Producto ID " . $id_a_eliminar . " eliminado con éxito.</p>";
            } else {
                $mensaje = "<p class='mensaje-alerta'>No se encontró ningún producto con ID " . $id_a_eliminar . ".</p>";
            }
        } else {
            $mensaje = "<p class='mensaje-error'>Error al eliminar: " . $stmt->error . "</p>";
        }

        // Cerrar el statement
        $stmt->close();
    }

    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Eliminar</title>
</head>
<body>
    <?php echo $mensaje; ?>
    <h1>Eliminar producto</h1>
<form method="POST" action="" class="formulario">
    <label>ID del producto a eliminar:</label>
    <input type="number" name="id" required inputmode="numeric"><br><br>
    <input type="submit" value="Eliminar" class="boton_eliminar">
</form>
<p><a href="index.php" class="boton_inicio">Volver al inicio</a></p>
</body>
</html>
