<?php
include('config.php');
include('inc_libreria.php');

$resultado = '';
$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

if(!empty($_GET['idproducto']) && isset($_GET['accion'])){
    // Miramos si ya existe el producto en el carro del usuario, para saber si hay que añadir, borrar o actualizar.
    $sql = "SELECT * FROM carro WHERE producto_id = :idproducto AND usuario_id= :idusuario;";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idproducto',$_GET['idproducto'],PDO::PARAM_INT);
    $stmt->bindParam(':idusuario',$_SESSION['idusuario'],PDO::PARAM_INT);
    $stmt->execute();
    $reg = $stmt->fetch();

    $sql2 = '';
    if($reg){  // Si ya está ese producto en el carro...
        if($_GET['accion']=='padentro'){ // Si se ha pedido añadirlo... es un UPDATE, aunmentando en 1 su cantidad
            $sql2 = "UPDATE carro SET cantidad=cantidad+1 WHERE producto_id = :idproducto AND usuario_id= :idusuario;;";
        }else if($_GET['accion']=='pafuera' && $reg['cantidad']>1){ // Si se ha pedido retirarlo y hay más de 1... es un UPDATE, reduciendo en 1 su cantidad
            $sql2 = "UPDATE carro SET cantidad=cantidad-1 WHERE producto_id = :idproducto AND usuario_id= :idusuario;;";
        }else if($_GET['accion']=='pafuera' && $reg['cantidad']=1){ // Si se ha pedido retirarlo y solo queda 1... es un DELETE
            $sql2 = "DELETE FROM carro WHERE producto_id = :idproducto AND usuario_id= :idusuario;;";
        }
    }else{ // Si no está ese producto en el carro
        if($_GET['accion']=='padentro'){ // Si se ha pedido añadirlo... es un INSERT
            $sql2 = "INSERT INTO carro (producto_id,usuario_id,cantidad) VALUES(:idproducto,:idusuario,1);";
        }
    }

    if($sql2!=''){ // Si hay algo que actualizar en el carro.... se ejecuta la instrucción almacenada en $sql2
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->bindParam(':idproducto',$_GET['idproducto'],PDO::PARAM_INT);
        $stmt2->bindParam(':idusuario',$_SESSION['idusuario'],PDO::PARAM_INT);
        $stmt2->execute();
    }
}

// Creamos el listado actualizado de contenido del carro
$sqlProd = "SELECT p.*, c.cantidad FROM productos p INNER JOIN carro c ON p.id = c.producto_id WHERE c.usuario_id = :idusuario;";
$stmtProd = $conexion->prepare($sqlProd);
$stmtProd->bindParam(':idusuario',$_SESSION['idusuario'],PDO::PARAM_INT);
$stmtProd->execute();


while($regProd = $stmtProd->fetch()){
    $resultado.= "<div class='caja_item_carro'>"; // Caja para cada producto
        $resultado.= "<div class='item_carro_img'><img src='img/{$regProd['foto']}' alt='{$regProd['producto']}' width='50'></div>";
        $resultado.= "<div class='item_carro_producto'>({$regProd['cantidad']}) {$regProd['producto']}</div>";
        $resultado.= "<div class='bquitacarro'><img src='img/basura.png' alt='Quitar producto' width='30' title='Quitar producto del carro'  data-producto-id='{$regProd['id']}' data-accion='pafuera'></div>";
    $resultado.= '</div>';
}

if($resultado==''){$resultado = '<img src="img/carro_vacio.png" width="90%" alt="Carro vacío">';}

echo $resultado;