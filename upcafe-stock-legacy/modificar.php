<?php
include 'conexion.php'; 
$producto = null;
$mensaje = '';


// Paso 2: ACTUALIZAR PRODUCTO (si se presionó el botón 'modificar')
if (isset($_POST['modificar'])) {
    
    // 1. Capturar y sanear los datos
    $id       = intval($_POST['id']);
    $nombre   = trim($_POST['nombre']);
    $cantidad = intval($_POST['cantidad']);

    // 2. Preparar la Consulta UPDATE 
    $sql = "UPDATE Productos SET nombre = ?, cantidad = ? WHERE id = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt === FALSE) {
        //echo "Error en la preparación: " . $conexion->error;
        $mensaje = "<p class='mensaje-error'>Error al preparar la actualización: " . $conexion->error . "</p>";
    } else {
        // 3. Vincular los parámetros: 's' para nombre, 'i' para cantidad, 'i' para id
        $stmt->bind_param("sii", $nombre, $cantidad, $id);
        
        // 4. Ejecutar la Consulta
        if ($stmt->execute()) {
            //echo "Producto ID " . $id . " modificado con éxito.";
            $mensaje = "<p class='mensaje-exito'>Producto ID " . $id . " modificado con éxito.</p>";
        } else {
            //echo "Error al modificar: " . $stmt->error;
            $mensaje = "<p class='mensaje-error'>Error al modificar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}


// Paso 1: BUSCAR PRODUCTO (Lógica limpia)
// Esta sección se ejecuta si: 1) se pulsó 'Buscar' O 2) se pulsó 'Modificar' y no hubo error
if (isset($_POST['buscar']) || (isset($_POST['modificar']) && $mensaje !== '')) { 
    // ^ Usar $mensaje !== '' (no es vacío) en lugar de $mensaje == '' (es vacío) para recargar solo si no hubo error
    
    // Si hay datos en POST, toma el ID; si no, es 0
    $id_buscar = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    if ($id_buscar > 0) {
        // 1. Preparar la Consulta SELECT (¡SEGURO!)
        $sql = "SELECT id, nombre, cantidad FROM Productos WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt === FALSE) {
            //echo "Error en la preparación: " . $conexion->error; 
            $mensaje = "<p class='mensaje-error'>Error al preparar la búsqueda: " . $conexion->error . "</p>";
        } else {
            // 2. Vincular y ejecutar
            $stmt->bind_param("i", $id_buscar);
            $stmt->execute();
            $resultado = $stmt->get_result(); 
            $producto = $resultado->fetch_assoc(); 

            if (!$producto) {
                //echo "No se encontró ningún producto con ID " . $id_buscar . ".";
                $mensaje = "<p class='mensaje-alerta'>No se encontró ningún producto con ID " . $id_buscar . ".</p>";
            }
            $stmt->close();
        }
    }
}

$conexion->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modificar</title>
</head>
<body>
    <?php echo $mensaje; ?>
    <h1>Modificar producto</h1>
<form method="POST" action="" class="formulario">
    <label>ID del producto:</label>
    <input type="number" name="id" required inputmode="numeric">
    <input type="submit" name="buscar" value="Buscar" class="boton_buscar">
    <p><a href="index.php" class="boton_inicio">Volver al inicio</a></p>
</form>
<?php if ($producto): ?>
<form method="POST" action="" class="formulario">
    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>"><br><br>
    
    <label>Cantidad:</label>
    <input type="number" name="cantidad" required inputmode="numeric" value="<?php echo $producto['cantidad']; ?>"><br><br>
    
    <input type="submit" name="modificar" value="Guardar cambios" class="boton_guardar">
</form>
<?php endif; ?>
</body>
</html>