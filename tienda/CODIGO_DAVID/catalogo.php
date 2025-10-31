<?php
include('config.php');
include('inc_libreria.php');

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
$sql = "SELECT * FROM categorias;";
$stmt = $conexion->prepare($sql);
$stmt->execute();

$listado = '';
$idcategorias = array();
while ($reg = $stmt->fetch()) {
    $listado.= '<div class="caja_item"  id="cat_'.$reg['id'].'">'; // Caja para cada categoría
        $listado.= '<div class="marco"><img src="img/'.$reg['foto'].'" alt="'.$reg['categoria'].'"></div>';
        $listado.= '<div class="info">'.$reg['categoria'].'</div>';
    $listado.= '</div>';
    $idcategorias[] = $reg['id'];
}

$listadoProductos = '';
$sql2 = 'SELECT id FROM productos';
$stmt2 = $conexion->prepare($sql2);
$stmt2->execute();
$ids = $stmt2->fetchAll(PDO::FETCH_COLUMN,0);

$numAleatorio = rand(0,count($ids)-1);
$idPromo = $ids[$numAleatorio];
unset($ids);

$sql3 = "SELECT * FROM productos WHERE id = :id ;";
$stmt3 = $conexion->prepare($sql3);
$stmt3->bindParam(':id',$idPromo,PDO::PARAM_INT);
$stmt3->execute();
$regPromo = $stmt3->fetch();

$listadoProductos.= '<div class="caja_item">'; // Caja para cada categoría
    $listadoProductos.= '<div class="marco"><img src="img/'.$regPromo['foto'].'" alt="'.$regPromo['producto'].'"></div>';
    $listadoProductos.= '<div class="info">'.$regPromo['producto'].'</div>';
    $listadoProductos.= '<div class="info">'.$regPromo['precio'].'</div>';
    $listadoProductos.= '<div class="info">'.$regPromo['descripcion'].'</div>';
$listadoProductos.= '</div>';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="js/ajax.js" type="text/javascript"></script>
    <style>
        img{
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

    <script>
        document.addEventListener('DOMContentLoaded',function(){
            let idcategorias = [<?=implode(',',$idcategorias)?>];
            for(let i = 0;i<idcategorias.length;i++){
                document.getElementById('cat_'+idcategorias[i]).addEventListener('click',function(){
                    let url = 'catalogo_detalle.php?idcat='+idcategorias[i];
                    cargarContenido(url,'fila_productos');
                });
            }

        });
    </script>
</body>
</html>