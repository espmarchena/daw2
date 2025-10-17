<?php
session_start();

$nombres = array('cafe', 'cacao', 'mascarpone');
$precios = array(12, 16, 6);
$fotos = array('cafe.jpg', 'cacao.jpg', 'mascarpone.jpg');
$resultado = ''; //la rellenamos con lo que queremos mostrar en el carro

if(isset ($_GET['p']) && $_GET['p']>=0 && isset($_GET['estado'])){ // si existe la variable 'p' y es mayor o igual a 0 y existe estado (0 ó 1)

    $p = $_GET['p'];
    $estado = $_GET['estado'];

    if(!isset($_SESSION['articulos'])){ //si no esta creada, que la cree
    $_SESSION['articulos'] = array ();
    }
    if(in_array($p, $_SESSION['articulos'])){ // comprobamos si el producto (p) estaba ya almacenado en el carro (que lo hemos almacenado en la variable de sesion articulos). Si entramos aquí es porque la condicion ha comprobado que el producto existe. Solo nos interesa ejecutar dentro si tenemos que quitarlo del carro
        if(($estado)==0){ // por lo que, si no existe
            $indice = array_search($p, $_SESSION['articulos']); // busca el valor 'p' en el array articulos y devuelve su indice
            unset($_SESSION['articulos'][$indice]); // unset elimina un elemento de un array, dejando su hueco con el indice vacío
        }
    }
    else { // si el producto (p) no existe en el carrito (articulos), lo añadimos
        if($estado==1){ //solo nos interesa ejecutar aqui si nos piden añadirlo al carro. Hay que eliminar el indice, el primer parentesis
            $_SESSION['articulos'][] = $p; // añadimos el producto al carrito
        }
    }
    // en este punto, el carrito (articulos) ya esta actualizado, solo queda preparar el html para que lo muestre dentro del div 'carro'
    $importe = 0;
    foreach($_SESSION['articulos'] as $orden => $idProducto){ //recorremos
        // nos da el listado concatenando los nombres de los productos que hay en el carro
        // idProducto se refiere al mismo dato que p, pero p se refiere al producto concreto que quita o añade, e idProducto es la variable interna del bucle
        $resultado.= '<div class ="producto">';
            $resultado.= '<div><img src="img/'.$fotos[$idProducto].'" width="100" alt ="'.$nombres[$idProducto].'"></div>';
            $resultado.= '<div>'.$nombres[$idProducto].'</div>';
            $resultado.= '<div>'.$precios[$idProducto].'</div>';
        $resultado.= '</div>';
        $importe+= $precios[$idProducto];
    }
    $resultado.= "<div>Importe de la compra: $importe €</div>";
}


echo $resultado;