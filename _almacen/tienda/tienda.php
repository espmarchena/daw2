<?php
include('config.php');
include('inc_libreria.php');

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

// para obtener las obtener categorias
$sql_categorias = "SELECT * FROM categoria";
$stmt_categorias = $conexion->prepare($sql_categorias);
$stmt_categorias->execute();

$listadocategorias = '';
$idCategorias = array(); // crear array con los ids de categorías
while ($reg = $stmt_categorias->fetch()) {
    $listadocategorias .= '<div class="categoria" id="cat_'.$reg['id'].'">'; //caja para cada categoria. El id es para usarlo en js
       // $listadocategorias .= '<div class = "marco"> <img src ="images/'.$reg['foto'].'" alt=""> </div>';
        $listadocategorias .= '<div class = "info">'.$reg['categoria'].'</div>'; // info es para el texto de abajo de las imagenes
    $listadocategorias .= '</div>';
    $idCategorias[] = $reg['id']; // llenar el array con los ids de las categorias

}

// para obtener valoraciones existentes
$sql_valoraciones = "SELECT producto_id, valoracion FROM valoraciones";
$stmt_valoraciones = $conexion->prepare($sql_valoraciones);
$stmt_valoraciones->execute();
$valoraciones_existentes = array();
 
while ($valoracion = $stmt_valoraciones->fetch()) { // almacena el resultado de la consulta en el array con el metodo fetch
    $valoraciones_existentes[$valoracion['producto_id']] = $valoracion['valoracion'];
} // para cada producto que ya tenga una valoración en la bbdd, esta linea asegura que el array $valoraciones_existentes almacene el id del producto como la clave y el valor de su valoración (1 o 2)

// para obtener los productos
$sql_productos = "SELECT * FROM productos2";
$stmt_productos = $conexion->prepare($sql_productos);
$stmt_productos->execute();

$listadoproductos = '';
$productos_ids = array(); // crear array con los ids de los productos
while ($reg = $stmt_productos->fetch()) {
    $listadoproductos .= '<div class="producto">';
        $listadoproductos .= '<img src="images/'.$reg['foto'].'" alt="'. $reg['nombre_producto'].'">';
        $listadoproductos .= '<div class="nombre">' . $reg['nombre_producto'] . '</div>';
        $listadoproductos .= '<div class="valoracion-botones">';
        $listadoproductos .= '<div class="like-btn" id="like_'.$reg['id'].'"><img src="images/like.png" alt="Like"></div>';
        $listadoproductos .= '<div class="dislike-btn" id="dislike_'.$reg['id'].'"><img src="images/dislike.png" alt="Dislike"></div>';
        $listadoproductos .= '</div>'; // cierre del div de valoracion-botones
    $listadoproductos .= '</div>';  
    $productos_ids[] = $reg['id']; // llenar el array con los ids de los productos para usarlo mas abajo en el implode
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <script src="js/ajax.js" type="text/javascript"></script>
<style>
        .marco{
            max-width: 50%;
        }
        .info{
            font-size: 1.1em; /* 10% más grande de lo que debería */
            text-align: center;
        }
        .categorias {
            display: flex;
            margin-bottom: 20px;
        }
        .categoria {
            flex: 1;
            border: thin dashed #e1e1e1;
            border-radius: 6px;
            padding: 10px 15px;
            background: #f0f0f0;
            border-radius: 20px;
            cursor: pointer;
        }
        .cajaproductos {
            flex: 1;
            cursor: pointer;
        }
        .producto {
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .producto img {
            width: 100%; 
            height: 150px;
            object-fit: contain; /* ajusta la imagen para que se vea completa dentro del contenedor, manteniendo sus proporciones originales */
            border-radius: 5px;
        }
        .nombre {
            font-weight: bold;
            margin: 10px 0;
        }
        .valoracion-botones { /* para los botones like y dislike */
            display: flex;
            justify-content: center;
            gap: 10px; /* separación */
        }
        
        .like-btn, .dislike-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            background: #cccccc; /* gris por defecto */
            transition: all 0.3s ease;
        }

        .like-btn img, .dislike-btn img {
            width: 30px;   /* Por ejemplo, 24x24 píxeles */
            height: 30px;
            vertical-align: middle; /* Alinea el icono verticalmente si hay texto cerca */
            border: none;
        }
        
        .like-btn:hover {
            background: #4CAF50; /* cuando pasas por encima el razon se pone verde la caja */
        }
        
        .dislike-btn:hover {
            background: #f44336; /* cuando pasas por encima el razon se pone roja la caja */
        }

    </style>
</head>
<body>
    
    <h2 style= "text-align: center">Categorías</h2>
    <div class="categorias"> <!-- div para inyectar el contenido html de las categorias codificado arriba en php -->
        <?= $listadocategorias ?> 
    </div>

    <div class="cajaproductos" id="cajaproductos"> <!-- div para inyectar el contenido html de los productos codificado arriba en php -->
        <?= $listadoproductos ?>
    </div>

    <div class="caja_ajax"> </div> <!-- div para la inyeccion de los mensajes de respuesta del servidor (php) después de una acción asíncrona (ajax) -->

    <script>

        document.addEventListener('DOMContentLoaded', function(){
            let todoslosid = [<?= implode(',' , $productos_ids) ?>]; //inyectamos los id de las categorias que hemos codificado en el php
            let categorias = [<?= implode(',' , $idCategorias) ?>]; //inyectamos los id de las categorias que hemos codificado en el php
            // implode convierte en string los valores de un array

            // evento para like
            for (let i = 0; i < todoslosid.length; i++) {
                let productoId = todoslosid[i];
                document.getElementById('like_' + productoId).addEventListener('click', function() {
                    actualizarValoracion(productoId, 1);
                });
            }       

            // evento para dislike
            for (let i = 0; i < todoslosid.length; i++) {
                let productoId = todoslosid[i];
                document.getElementById('dislike_' + productoId).addEventListener('click', function() {
                    actualizarValoracion(productoId, 2);
                });
            }

            // agregar evento click a cada categoría
            for (let i = 0; i < categorias.length; i++) { 
                // buscamos cada categoria y le asignamos su evento click
                document.getElementById('cat_'+categorias[i]).addEventListener('click', function(){ // concateno cada categoria con el id que toque
                let url = 'tienda_actualiza.php?idcat=' + categorias[i];
                cargarContenido(url, 'cajaproductos');
                });
            }

    });

        function actualizarValoracion(productoId, valoracion) {
            let url = 'tienda_actualiza.php?producto_id=' + productoId + '&valoracion=' + valoracion; // concatenamos con el id del get. estado es 1(like) ó 2 (deslike)
            cargarContenido(url,'caja_ajax'); //espera recibir la url a donde enviar la peticion, y nombre del contenedor del resultado
        }

    </script>
</body>
</html>