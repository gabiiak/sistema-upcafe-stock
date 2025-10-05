<?php
include 'conexion.php';
$sql = "SELECT id, nombre, cantidad FROM Productos ORDER BY id"; //consulta SQL
$resultado = $conexion->query($sql); //ejecuta la consulta
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="main_header">
        <h1>Lista de productos</h1>
    </header>
    <?php 
        if ($resultado && $resultado->num_rows > 0){
           echo '<div class="tabla_responsive">';
            echo '<table>';
            echo '<thead><tr>';
            echo '<th>ID</th>';
            echo '<th>Nombre</th>';
            echo '<th>Cantidad</th>';
            echo '</tr></thead>';
            echo '<tbody>';
        
            while($row = $resultado->fetch_assoc()) {
            echo '<tr>';
            // Usar htmlspecialchars() es crucial para sanear la salida y evitar XSS
            echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["nombre"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["cantidad"]) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Cierre del div responsive

    } else {
        echo "<p class='no-productos'>No hay productos cargados.</p>";
    }

    $conexion->close();
    ?>
    <a href="index.php" class="boton_inicio" >Volver al inicio</a>    
</body>
</html>