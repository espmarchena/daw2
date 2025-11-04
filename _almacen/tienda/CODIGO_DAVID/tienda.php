<?php
include('config.php');
include('inc_libreria.php');
include('inc_likes.php');

// GENERAR LISTADO DE CATEGORIAS (ENLACES)
$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
$sql = "SELECT * FROM categorias;";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$listado = '';
$idcategorias = array();
while ($reg = $stmt->fetch()) {
    $listado.= "<div class='caja_item'  id='cat_{$reg['id']}'>";
        $listado.= "<div class='info'><a href='tienda.php?idcat={$reg['id']}'>{$reg['categoria']}</a></div>";
    $listado.= "</div>";
    $idcategorias[] = $reg['id'];
}

// GENERAR LISTADO DE PRODUCTOS
$listadoProductos = '';
if(!empty($_GET['idcat'])){
    $sqlProd = "SELECT p.*, l.valoracion FROM productos p LEFT JOIN likes l ON p.id = l.producto_id WHERE p.categoria_id = :idcat"; // usamos left join pq hay productos que no estan valorados, asi salen todos los productos aunque no esten valorados
    $stmtProd = $conexion->prepare($sqlProd);
    $stmtProd->bindParam(':idcat',$_GET['idcat'],PDO::PARAM_INT);
    $stmtProd->execute();
    while($regProd = $stmtProd->fetch()){
        $valoracion = (isset($regProd['valoracion']) && $regProd['valoracion']!== null ? $regProd['valoracion'] : 0); // si existe valoracion y es distinta a nulo, la valoracion inicial se guarda a 0
        $c_likes = creaLikes($regProd['id'],$valoracion); // almacenamos el resultado de la funcion que se encarga de crear los botones de like/deslike, que necesita saber a que producto estan asociados y si existe valoracion previa
        $listadoProductos.= "<div class='caja_item'>"; // Caja para cada producto
            $listadoProductos.= "<div class='marco'><img src='img/{$regProd['foto']}' alt='{$regProd['producto']}'></div>";
            $listadoProductos.= "<div class='info'>{$regProd['producto']}</div>";
            $listadoProductos.= "<div class='info' id='caja_likes_{$regProd['id']}'>$c_likes</div>"; // aqui incrustamos todo el html que genera la funcion creaLikes con la variable c_likes
        $listadoProductos.= '</div>';
    }
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
        .marco img{
            width: 100%;
            border-radius: 6px;
        }

        #fila_categorias, #fila_productos{
            display:flex;
        }
        .caja_item{
            flex:1;
            border: thin dashed #e1e1e1;
            border-radius: 6px;
            background-color: #ffefef;
            overflow: hidden;
            width:25%;
        }

        .megusta, .nomegusta{
            cursor: pointer;
        }

        
        .info{
            font-size:1.1em;
            text-align: center;
        }

    </style>
</head>
<body>
    <div id="fila_categorias">
        <?=$listado?>
    </div>
    <div id="fila_productos">
        <?=$listadoProductos?>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded',function(){ // listener para que esté pendiente de que se cargue todos los elementos del body
            document.addEventListener('click', function(e) { // listener que está pendiente de que se haga click en cualquier parte del body, la 'e' hace referencia al evento (en este caso clicar) y se capturan todos los datos de ello
                if (e.target.getAttribute('data-item-valoracion')) { // concreto más sobre el evento, pasandole el objeto que me interesa controlar, en este caso, en la mano de like/dislike en la que se ha hecho click
                    // e.target representa al objeto sobre el cual se ha hecho click
                    // getAttribute extrae algun atributo que hayamos guardado en su etiqueta, en este caso el id y la valoracion
                    let idproducto = e.target.getAttribute('data-producto-id');
                    let valoracion = e.target.getAttribute('data-item-valoracion');
                    daleLike(idproducto, valoracion); // llamada a una funcion js que le dice a ajax que haga algo, en este caso un update o un insert
                }
            });

            function daleLike(idproducto, valoracion){ // funcion js que le dice a ajax que haga algo, en este caso un update o un insert
                /*let url = `tienda_actualiza.php?idproducto=${idproducto}&valoracion=${valoracion}`;
                let capadestino = `caja_likes_${idproducto}`;*/

                let url = 'tienda_actualiza.php?idproducto='+idproducto+'&valoracion='+valoracion; // a la pagina encargada de actualizar los datos, se le envia el id del producto y la valoracion
                let capadestino = 'caja_likes_'+idproducto; // se le dice que rellene la caja (div) con el codigo actualizado que contiene el codigo html de la pagina
                
                cargarContenido(url,capadestino); // funcion ajax para cargar el contenido
            }
        });
    </script>
</body>
</html>