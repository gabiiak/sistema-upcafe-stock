<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Argentina/Buenos_Aires');
include 'conexion.php';
$sql = "SELECT id, nombre, cantidad, ultima_modificacion FROM Productos ORDER BY nombre ASC /*ORDER BY id*/ "; //consulta SQL
$resultado = $conexion->query($sql); //ejecuta la consulta
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
    <link rel="stylesheet" href="style.css?v=5"> 
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
            echo '<th>Última modificación</th>';
            echo '</tr></thead>';
            echo '<tbody>';
        
            while($row = $resultado->fetch_assoc()) {
                $timestamp = $row["ultima_modificacion"];
                $claseFila = '';
                if((int)$row['cantidad'] == 0){
                    $claseFila = 'sin-stock';
                }elseif ((int)$row['cantidad'] < 10) {
                    $claseFila = 'stock-bajo';
                }
                //$claseFila = ($row['cantidad'] == 0) ? 'style="color: red;"' : '';
                /*$id_producto = $row["id"];
                $sql_fecha = "SELECT ultima_modificacion FROM Productos WHERE id = $id_producto";
                $resultado_fecha = $conexion->query($sql_fecha);
                $row_fecha = $resultado_fecha->fetch_assoc();
                $timestamp = $row_fecha["ultima_modificacion"];
                */
                echo '<tr class="' . $claseFila . '">';
                // Usar htmlspecialchars() es crucial para sanear la salida y evitar XSS
                echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nombre"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["cantidad"]) . '</td>';
                echo '<td>';
                    if(!empty($timestamp) && $timestamp != '0000-00-00 00:00:00'){
                        echo date('d/m H:i', strtotime($timestamp));
                    }else{
                        echo 'Sin modificaciones';
                    }//celda dinacmica
                    //echo 'ID'.htmlspecialchars($row["id"]) .'sin registro';
                    /*if(!empty($timestamp) && $timestamp != '0000-00-00 00:00:00'){
                        echo date ('d/m/Y H:i:s', strtotime($timestamp));
                    } else {
                        echo 'Sin modificaciones';
                    }*/
                echo '</td>';
                echo '</tr>';
            }

        echo '</tbody>';
        echo '</table>';
        echo '</div>'; // Cierre del div responsive

    } else {
        echo "<p>No hay productos cargados.</p>";
    }

    $conexion->close();
    ?>
    <a href="index.php" class="boton_inicio" >Volver al inicio</a>    
</body>
</html>