<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

// ESTE TROZO DE CODIGO PREPARA EL LISTADO DE CATEGORIAS
$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); // objeto PDO que conecta a la base de datos 

// ***para obtener las categorias
$sql_categorias = "SELECT * FROM categoria";
$stmt_categorias = $conexion->prepare($sql_categorias); // prepara la consulta
$stmt_categorias->execute(); // ejecuta la consulta
$listadocategorias = '';
$idCategorias = array(); // crear array con los ids de categorías
    
while ($reg = $stmt_categorias->fetch()){ // bucle que acaba cuando se terminan los datos. Objeto fetch de la clase stmt que formatea a array asociativo
    $listadocategorias .= '<div class="caja_item" id="cat_'.$reg['id'].'">'; //caja para cada categoria. El id es para usarlo en js
        // meto cada foto en un div
        $listadocategorias .= '<div class = "marco"> <img src ="images/'.$reg['foto'].'" alt=""> </div>'; // marco es para los div que contienen imagen
        $listadocategorias .= '<div class = "info">'.$reg['categoria'].'</div>'; // info es para el texto de abajo de las imagenes
    $listadocategorias .= '</div>'; // concatena en cada iteracion mostrando 
    $idCategorias[] = $reg['id']; // llenar el array con los ids de las categorias
}



//CONSULTA PARA OBTENER ID DE PRODUCTOS, LOS ALMACENA EN ARRAY
// ***para hacer lo de mostrar un producto aleatorio como promocion. Existe la funcion rand() pero para bbdd grandes carga mucho el servidor
$listadoProductos = '';
$sql_productos = "SELECT id
                FROM productos2";
$stmt_productos = $conexion->prepare($sql_productos); //prepara la consulta
$stmt_productos->execute(); // metodo que ejecuta la consulta
$ids = $stmt_productos->fetchAll(PDO::FETCH_COLUMN,0); // devuelve solo los valores de UNA columna específica, concretamente de la primera columna (id) creando un el array simple llamado $ids con solo los valores de esa columna

// SELECCIONA UN ID RANDOM
// para elegir el numero de orden dentro del array (1er producto, o 5o producto, o 9o producto...)
$numAletorio = rand(0,count($ids)-1); // count() cuenta todos los elementos del array, y se pone en el parametro del numero mayor para que si agrando la bbdd no casque nunca y siempre llegue hasta el total del tamaño del array que se le pasa
$idPromo = $ids[$numAletorio]; // guardo el valor en idPromo pasandole el indice del array ids que previamente lo he calculado de forma aleatoria
unset($ids); // borra/destruye la variable $ids para descargar/liberar el servidor


//CONSULTA DEL PRODUCTO BASADO EN EL ID ALEATORIO
$sql_aleatorio = "SELECT *
            FROM productos2
            WHERE id = :id;";
$stmt_aleatorio = $conexion->prepare($sql_aleatorio); //prepara la consulta
$stmt_aleatorio->bindParam(':id', $idPromo, PDO::PARAM_INT);
$stmt_aleatorio->execute(); // metodo que ejecuta la consulta
$regPromo = $stmt_aleatorio->fetch(); //fetch convierte en array asociativo los datos del producto aleatorio que vamos a promocionar que inyectaremos en el html

$listadoProductos .= '<div class= "caja_item">'; //caja para cada categoria
        // meto cada foto en un div
        $listadoProductos .= '<div> <img src ="images/'.$regPromo['foto'].'" alt="'.$regPromo['nombre_producto'].'"> </div>'; // marco es para los div que contienen imagen
        $listadoProductos .= '<div class = "info">'.$regPromo['nombre_producto'].'</div>'; // info es para el texto de abajo de las imagenes
        $listadoProductos .= '<div class = "info">'.$regPromo['precio'].'</div>';
        $listadoProductos .= '<div class = "info">'.$regPromo['descripcion'].'</div>';
$listadoProductos .= '</div>'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <script src="js/ajax.js" type="text/javascript"></script> <!-- importar ajax -->
    <style>
        #catalogo, #listadoproductos {
            display: flex;
            flex-wrap: wrap; /* los productos pasan a la siguiente linea cuando no caben */
        }
        .caja_item{
            flex: 1;
            border: thin dashed #e1e1e1;
            border-radius: 6px;
            background-color: #ffefef;
            overflow: hidden; /* esconde el contenido que sobresale del contenedor */
            cursor: pointer;
        }
        img{
            width: 100%; 
            height: 150px;
            object-fit: contain; /* ajusta la imagen para que se vea completa dentro del contenedor, manteniendo sus proporciones originales */
            border-radius: 5px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .info{
            font-size: 1.1em; /* 10% más grande de lo que debería */
            text-align: center;
        }
        .marco{
            max-width: 50%;
        }

    </style>
</head>
<body>

    <h2>Categorías</h2>
    <div id="catalogo">
        <?= $listadocategorias ?>
    </div>
    <div id= "listadoproductos"> <!-- contenedor que se rellena con ajax --> </div> 

    <h2>Producto en Promoción</h2>
    <div id= "listadoproductos">
        <?= $listadoProductos ?>
    </div> 
    
    <div>
        <a href="catalogo.php">Volver al catálogo completo</a>
    </div>

<script> // JS PARA ASIGNAR LOS EVENTOS 
    document.addEventListener('DOMContentLoaded', function(){ // 
        // obtener todos los elementos de categoría
        let categorias = [<?= implode(',' , $idCategorias) ?>]; //inyectamos los id de las categorias que hemos codificado en el php
        // implode convierte en string los valores de un array
 
        // agregar evento click a cada categoría
        for (let i = 0; i < categorias.length; i++) { 
            // buscamos cada categoria y le asignamos su evento click
            document.getElementById('cat_'+categorias[i]).addEventListener('click', function(){ // concateno cada categoria con el id que toque
            let url = 'catalogo_detalle.php?idcat=' + categorias[i];
            cargarContenido(url, 'listadoproductos');
            });
        }
    });

</script>

</body>
</html>