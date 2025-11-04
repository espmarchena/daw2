<?php
include('config.php');
include('inc_libreria.php');

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

if (!empty($_GET['id_producto'])) { // si se ha enviado un id de producto para añadir a la cesta
    $id_producto = $_GET['id_producto']; 
    
    if (!isset($_SESSION['carro'])) { // si la cesta no existe, la creamos
        $_SESSION['carro'] = array();
    }

    if (isset($_SESSION['carro'][$id_producto])) { // si el producto ya está en la cesta, incrementamos su cantidad
        $_SESSION['carro'][$id_producto]++;
    } else { // si no está, lo añadimos con cantidad 1
        $_SESSION['carro'][$id_producto] = 1;
    }
}

// GENERAR CESTA DE LA COMPRA
$cesta_compra = '';
if(isset($_SESSION['carro']) && !empty($_SESSION['carro'])){
    $ids_productos_cesta = implode(',', array_keys($_SESSION['carro'])); // creamos una cadena con los ids de los productos en la cesta separados por comas
    $sqlCesta = "SELECT * FROM productos WHERE id_producto = :id_producto"; // consulta para obtener los datos de los productos que estan en la cesta
    $stmtCesta = $conexion->prepare($sqlCesta);
    $stmtCesta->bindParam(':id_producto', $_GET['id_producto'], PDO::PARAM_INT);
    $stmtCesta->execute();
    $cesta_compra.= "<div class='caja_item'>";
        $cesta_compra .= '<ul class="caja_cesta">';
        while($regCesta = $stmtCesta->fetch()){
            $cantidad = $_SESSION['carro'][$regCesta['id_producto']]; // obtenemos la cantidad del producto actual en la cesta con un array asociativo
            $cesta_compra .= "<li> {$regCesta['nombre']} - Cantidad: $cantidad </li>";
        }
        $cesta_compra .= '</ul>';
    $cesta_compra.= '</div>';
} else {
    $cesta_compra .= 'La cesta está vacía.';
}

echo $cesta_compra;
?>