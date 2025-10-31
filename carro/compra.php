<?php
include('config.php');
include('inc_libreria.php');


// GENERAR PANEL SUPERIOR
$nombre_usuario = $_SESSION['nombre'] ?? ''; // obtener el nombre del usuario desde la sesión si está logueado, sino sale en blanco
$panel_superior = '';
if(!empty($nombre_usuario)) { // si no está vacío lo muestra
    $panel_superior = "<div class='panel-superior'>";
        $panel_superior .= "<span>Identificado como $nombre_usuario</span>";
    $panel_superior .= "</div>";
}

// GENERAR LISTADO DE CATEGORIAS
$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
$sql = "SELECT * FROM categorias;";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$listadoCat = '';
while ($reg = $stmt->fetch()) {
    $listadoCat.= "<div class='caja_item'>";
        $listadoCat.= "<div class='caja_cat'  id='cat_{$reg['id_categoria']}'>";
            //$listadoCat .= '<div class = "marco"> <img src ="img/'.$reg['foto'].'" alt="'.$reg['nombre'].'"> </div>';
            $listadoCat.= "<div class='info'><a href='compra.php?id_categoria={$reg['id_categoria']}'>{$reg['nombre']}</a></div>";
        $listadoCat.= "</div>";
    $listadoCat.= "</div>";
}

// GENERAR LISTADO DE PRODUCTOS
$listadoProductos = '';
if(!empty($_GET['id_categoria'])){
    $sqlProd = "SELECT * FROM productos WHERE id_categoria = :idcat";
    $stmtProd = $conexion->prepare($sqlProd);
    $stmtProd->bindParam(':idcat',$_GET['id_categoria'],PDO::PARAM_INT);
    $stmtProd->execute();
    while($regProd = $stmtProd->fetch()){
        $listadoProductos.= "<div class='caja_item'>";
            $listadoProductos.= "<div class='caja_prods'>";
                $listadoProductos.= "<div class='marco'><img src='img/{$regProd['foto']}' alt='{$regProd['nombre']}'></div>";
                $listadoProductos.= "<div class='info' data-nombreproducto='{$regProd['nombre']}'>{$regProd['nombre']} </div>";
                $listadoProductos.= "<div class='botonañadir' id='boton_{$regProd['id_producto']}'><input type='button' value='Añadir' data-idproducto='{$regProd['id_producto']}'></div>"; // boton añadir al carrito
            $listadoProductos.= '</div>';
        $listadoProductos.= '</div>';
    }
}

// GENERAR CESTA DE LA COMPRA
$cesta_compra = '';
if(isset($_SESSION['carro']) && !empty($_SESSION['carro'])){ // si la cesta tiene productos ...
    $cesta_compra.= "<div class='caja_item'>";
        $cesta_compra .= '<ul class="caja_cesta">'; // ul porque es una lista

        // recorro todos los productos en el carro
        foreach($_SESSION['carro'] as $id_producto => $cantidad) {
            // consulta para cada producto individualmente
            $sqlCesta = "SELECT * FROM productos WHERE id_producto = :id_producto";
            $stmtCesta = $conexion->prepare($sqlCesta);
            $stmtCesta->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmtCesta->execute();
            
            if($regCesta = $stmtCesta->fetch()){
                $cesta_compra .= "<li'>"; // li porque es un elemento de la lista
                $cesta_compra .= "<div class='info-cesta'>";
                    $cesta_compra .= "<span>{$regCesta['nombre']}</span>";
                    $cesta_compra .= "<span> <br>Cantidad: $cantidad</span>";
                    $cesta_compra .= "</div>";
                $cesta_compra .= "<img src='img/{$regCesta['foto']}' alt='{$regCesta['nombre']}' class='imagen-cesta'>"; // muestro la foto del producto en la cesta
                $cesta_compra .= "</li>";
            }
        }
        $cesta_compra .= '</ul>';
    $cesta_compra.= '</div>';
} else {
    $cesta_compra .= 'La cesta está vacía.'; // mensaje si no hay productos en la cesta
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/ajax.js" type="text/javascript"></script>
    <style>
        .panel-superior{
            background-color: rgba(19, 93, 133, 1);
            color: white;
            padding: 10px;
            text-align: right;
        }
        .marco img{
            max-width: 50%;
            border-radius: 6px;
            margin-left: auto; 
            margin-right: auto; 
            display: block; /* para centrar el boton */
        }
        .info{
            font-size:1.1em;
            text-align: center;
        }
        .caja_cesta{
            list-style-type: none;
            padding: 0;
            margin: 0;
            flex: 1;
        }
        .info-cesta {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .imagen-cesta img{
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0; /* evita que un elemento flexible se encoja cuando no hay suficiente espacio en el contenedor */
        }
        .caja_item {
            flex:1;
            border: thin dashed #e1e1e1;
            border-radius: 6px;
            background-color: #f8f8f8;
            width:50%;
        }
        #fila_categorias {
            flex-basis: 15%; /* ocupa un 15% del ancho */
        }

        #fila_productos {
            flex-basis: 55%; /* ocupa un 55% del ancho */
        }

        #cesta_compra {
            flex-basis: 30%; /* ocupa un 30% del ancho */
        }
        #contenedor_ppal{
            display: flex; /* asegura que ocupen todo el ancho disponible */
            width: 100%; 
        }
        #columnas{
            display: flex;
            width: 100%; 
            justify-content: space-between; /* para distribuir el espacio entre las columnas */
            gap: 20px; /* añade espacio entre las columnas */
        }
        .botonañadir input{
            cursor: pointer;
            border-radius: 15px;
            font-size: 1.1em;
            margin-left: auto; 
            margin-right: auto; 
            display: block; /* para centrar el boton */
            background-color: rgba(19, 93, 133, 1);
            color: white;
        }
        #finalizar_pedido input{
            margin-top: 20px;
            width: 250px; /* stablece un ancho fijo */
            margin-left: auto; 
            margin-right: auto; 
            display: block; /* para centrar el boton */
            text-align: center;
            background-color: rgba(19, 93, 133, 1);
            color: white;
            border-radius: 6px;
            font-size: 1.3em;  
            padding: 10px;
            cursor: pointer;
        }

</style>
</head>
<body>
    
    <?php echo $panel_superior; ?>

    <div id="contenedor_ppal">

        <div id="columnas">

            <div id="fila_categorias">
                <h1>Listado de Categorías</h1>
                <?php echo $listadoCat; ?>
            </div>

            <div id="fila_productos">
                <h1>Catálogo de Productos</h1>
                <?php echo $listadoProductos; ?>
            </div>

            <div id="cesta_compra">
                <h1> Cesta de la Compra</h1>
            </div>

        </div>

    </div>


    <div id="finalizar_pedido">
        <input type="submit" value="Finalizar Pedido">
    </div>


    <script>  /* JAVASCRIPT */ 
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e){
            if (e.target.getAttribute('data-idproducto')){
                let id_producto = e.target.getAttribute('data-idproducto');
                let nombre_producto =e.target.getAttribute('data-nombreproducto');
                añadirAlCarrito(id_producto, nombre_producto);
            }
        });

        function añadirAlCarrito(id_producto, nombre_producto){
            let url ='carro.php?id_producto=' + id_producto;
            let capadestino = 'cesta_compra';

        cargarContenido(url, capadestino);
        }
    });    


    </script>

</body>
</html>