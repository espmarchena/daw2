<?php
include('config.php');
include('inc_libreria.php');

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

if(isset($_GET['idcat'])) { // si existe el id de la categoria ....
    $id_categoria = $_GET['idcat'];
    
    // consulta para obtener solo productos de la categoria seleccionada
    $sql_productos = "SELECT * FROM productos2 WHERE id_categoria = :id_categoria";
    $stmt_productos = $conexion->prepare($sql_productos);
    $stmt_productos->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    $stmt_productos->execute();

    $listadoproductoscat = ''; //listado de productos por categoria, su funcion es generar contenido dinamico en respuesta a una solicitud AJAX del navegador, sin recargar toda la pagina, por eso va en este archivo y no en el principal
    while ($reg = $stmt_productos->fetch()) {
        $listadoproductoscat .= '<div class="producto">';
            $listadoproductoscat .= '<img src="images/'.$reg['foto'].'" alt="'. $reg['nombre_producto'].'">';
            $listadoproductoscat .= '<div class="nombre">' . $reg['nombre_producto'] . '</div>';
            $listadoproductoscat .= '<div class="valoracion-botones">'; 
            $listadoproductoscat .= '<div class="like-btn" id="like_'.$reg['id'].'"><img src="images/like.png" alt="Like"></div>';
            $listadoproductoscat .= '<div class="dislike-btn" id="dislike_'.$reg['id'].'"><img src="images/dislike.png" alt="Dislike"></div>';
            $listadoproductoscat .= '</div>'; // cierre del div de valoracion-botones
        $listadoproductoscat .= '</div>';
    }
    
    echo $listadoproductoscat;
    exit; // el exit aqui detiene la ejecución para que no se ejecute la logica de la valoracion y de el mensaje de error del else
}


if(isset($_GET['producto_id']) && isset($_GET['valoracion'])) { // si existen los parametros ...
    $producto_id = $_GET['producto_id']; 
    $valoracion = $_GET['valoracion'];
    
    // consulto si ya existe una valoracion para el producto
    $sql1= "SELECT id FROM valoraciones WHERE producto_id = :producto_id";
    $stmtSelect = $conexion->prepare($sql1);
    $stmtSelect->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
    $stmtSelect->execute();
    
    if($stmtSelect->rowCount() > 0) { // verifico si la consulta SELECT encontro algun registro en la bbdd
        // si ya existe, hago un UPDATE
        $sql = "UPDATE valoraciones SET valoracion = :valoracion WHERE producto_id = :producto_id";
        $mensaje = "Valoración actualizada correctamente";
    } else {
        // si no existe, hago un INSERT
        $sql = "INSERT INTO valoraciones (producto_id, valoracion) VALUES (:producto_id, :valoracion)";
        $mensaje = "Valoración guardada correctamente";
    }
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
    $stmt->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);

    if($stmt->execute()) { // si se ejecuta la consulta
        echo $mensaje; //muestro el mensaje que proceda de la condicion
    } else {
        echo "Error al guardar la valoración";
    }

} else { // ... si no existen los parametros
    echo "Error: Datos incompletos";
}
?>