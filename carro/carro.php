<?php
include('config.php');
include('inc_libreria.php');

// Crear conexión a la base de datos
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
    $cesta_compra.= "<div class='caja_item'>";
        $cesta_compra .= '<ul class="caja_cesta">';
        
        // recorro todos los productos en el carro
        foreach($_SESSION['carro'] as $id_producto => $cantidad) {
            // consulta para cada producto individualmente
            $sqlCesta = "SELECT * FROM productos WHERE id_producto = :id_producto";
            $stmtCesta = $conexion->prepare($sqlCesta);
            $stmtCesta->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $stmtCesta->execute();
            
            if($regCesta = $stmtCesta->fetch()){
                $cesta_compra .= "<li> {$regCesta['nombre']} <br>- Cantidad: $cantidad </li>";
                $cesta_compra .= "<div class='marco'> <img src='img/{$regCesta['foto']}' alt='{$regCesta['nombre']}'> </div>"; // muestro la foto del producto en la cesta
            }
        }
        $cesta_compra .= '</ul>';
    $cesta_compra.= '</div>';
} else {
    $cesta_compra .= 'La cesta está vacía.';
}

echo $cesta_compra;
?>