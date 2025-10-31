<?php
include('config.php');
include('inc_libreria.php');

// GENERAR LISTADO DE CATEGORIAS
$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
$sql = "SELECT * FROM categorias;";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$listadoCat = '';
$idcategorias = array();
while ($reg = $stmt->fetch()) {
    $listadoCat.= "<div class='caja_item'>";
        $listadoCat.= "<div class='caja_cat'  id='cat_{$reg['id_categoria']}'>";
            //$listadoCat .= '<div class = "marco"> <img src ="img/'.$reg['foto'].'" alt="'.$reg['nombre'].'"> </div>';
            $listadoCat.= "<div class='info'><a href='compra.php?id_categoria={$reg['id_categoria']}'>{$reg['nombre']}</a></div>";
        $listadoCat.= "</div>";
    $listadoCat.= "</div>";
    $idcategorias[] = $reg['id_categoria'];
}

// GENERAR LISTADO DE PRODUCTOS
$listadoProductos = '';
$productos_ids = array();
if(!empty($_GET['id_categoria'])){
    $sqlProd = "SELECT * FROM productos WHERE id_categoria = :idcat";
    $stmtProd = $conexion->prepare($sqlProd);
    $stmtProd->bindParam(':idcat',$_GET['id_categoria'],PDO::PARAM_INT);
    $stmtProd->execute();
    while($regProd = $stmtProd->fetch()){
        $listadoProductos.= "<div class='caja_item'>";
            $listadoProductos.= "<div class='caja_prods'>";
                $listadoProductos.= "<div class='marco'><img src='img/{$regProd['foto']}' alt='{$regProd['nombre']}'></div>";
                $listadoProductos.= "<div class='info'>{$regProd['nombre']}</div>";
                $listadoProductos.= "<div class='botonañadir' id='boton_{$regProd['id_producto']}'><input type='button' value='Añadir' data-idproducto='{$regProd['id_producto']}'></div>"; // boton añadir al carrito
            $listadoProductos.= '</div>';
        $listadoProductos.= '</div>';
        $productos_ids[] = $regProd['id_producto']; // almacenamos los ids de los productos en un array para usarlos mas abajo en el implode
    }
}

// GENERAR CESTA DE LA COMPRA
$cesta_compra = '';
if(isset($_SESSION['carro']) && !empty($_SESSION['carro'])){
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
                $cesta_compra .= "<li class='item-cesta'>"; // li porque es un elemento de la lista
                $cesta_compra .= "<div class='info-cesta'>";
                $cesta_compra .= "<span class='nombre-producto'>{$regCesta['nombre']}</span>";
                $cesta_compra .= "<span class='cantidad-producto'> - Cantidad: $cantidad</span>";
                $cesta_compra .= "</div>";
                $cesta_compra .= "<img src='img/{$regCesta['foto']}' alt='{$regCesta['nombre']}' class='imagen-cesta'>"; // muestro la foto del producto en la cesta
                $cesta_compra .= "</li>";
            }
        }
        $cesta_compra .= '</ul>';
    $cesta_compra.= '</div>';
} else {
    $cesta_compra .= 'La cesta está vacía.';
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
        .caja_cat {
            /* Categorías: Ancho fijo y pequeño */
            flex: 0 0 150px; /* Ajustado de 100px a 150px para mejor usabilidad */
            padding: 15px;
            background-color: #f8f8f8;
        }
        .caja_prods {
            /* Productos: Crece para ocupar el espacio restante */
            flex: 1; 
            display: inline-block; /* mantiene propiedades de caja y permite convivir */
            width: 50%;
            text-align: center;
            border-radius: 5px;

        }
        .caja_cesta {
            /* Cesta: Ancho fijo */
            flex: 0 0 250px; /* Ajustado de 200px a 250px */
            padding: 15px;
            background-color: #ffe; 
            border-left: 1px solid #ddd;
        }
        .marco img{
            max-width: 50%;
            border-radius: 6px;
        }
        .info{
            font-size:1.1em;
            text-align: center;
        }
        .caja_item {
            flex:1;
            border: thin dashed #e1e1e1;
            border-radius: 6px;
            background-color: #f8f8f8;
            overflow: hidden;
            width:50%;
        }
         #fila_categorias, #fila_productos{
            display:flex;
        }
        .botonañadir input{
            cursor: pointer;
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
    
    <h1>Listado de Categorías</h1>
    <div id="fila_categorias" style="display:flex;">
        <?php echo $listadoCat; ?>
    </div>

    <h1>Catálogo de Productos</h1>
    <div id="fila_productos" style="display:flex; flex-wrap: wrap;">
        <?php echo $listadoProductos; ?>
    </div>

    <h1> Cesta de la Compra</h1>
    <div id="cesta_compra">
        <?php echo $cesta_compra; ?>
    </div>

    <div id="finalizar_pedido">
        <input type="submit" value="Finalizar Pedido">
    </div>


    <script>  /* JAVASCRIPT */ 
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e){
            if (e.target.getAttribute('data-idproducto')){
                let id_producto = e.target.getAttribute('data-idproducto');
                añadirAlCarrito(id_producto);
            }
        });

        function añadirAlCarrito(id_producto){
            let url ='carro.php?id_producto=' + id_producto;
            let capadestino = 'cesta_compra';

        cargarContenido(url, capadestino);
        }
    });    


    </script>

</body>
</html>