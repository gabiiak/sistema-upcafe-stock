<?php 
    include 'conexion.php';
    $mensaje = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = trim($_POST["nombre"]);
        $cantidad = (int) $_POST["cantidad"]; //captura segura de datos

        $sql = "INSERT INTO Productos (nombre, cantidad) VALUES (?, ?)"; //consulta preparada
        $stmt = $conexion->prepare($sql);
        if($stmt === FALSE){
            die("Error en la preparación de la consulta: " . $conexion->error);
        }else{
            $stmt->bind_param("si", $nombre, $cantidad); // "si" indica que son string e integer
            if($stmt->execute()){
                $mensaje = "Producto agregado con éxito.";
            } else {
                $mensaje = "Error al agregar producto: " . $stmt->error;
            }
            $stmt->close();
        }
        $conexion->close();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Agregar</title>
</head>
<body>
    <?= $mensaje ?>
    <h1>Agregar producto</h1>
    <form method="post" action="" class="formulario">
            Nombre: <input type="text" name="nombre" required><br><br>
            Cantidad: <input type="number" name="cantidad" required inputmode="numeric"><br><br>
            <input type="submit" value="Guardar" class="boton_guardar">
    </form>

    <a href="index.php" class="boton_inicio">Volver al inicio</a>
</body>
</html>