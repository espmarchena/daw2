<?php
include('config.php');
include('inc_libreria.php');
include('inc_likes.php');

$resultado = '';

if(!empty($_GET['idproducto']) && isset($_GET['valoracion'])){ // comprobamos si existe el id del producto y una valoracion
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

    // buscamos el producto en la tabla de los likes...
    $sql = "SELECT id FROM likes WHERE producto_id = :idproducto ;";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idproducto',$_GET['idproducto'],PDO::PARAM_INT);
    $stmt->execute();

    $reg = $stmt->fetch(); //lo guardo en la variable $reg

    if($reg){
        $sql = "UPDATE likes SET valoracion = :valoracion WHERE producto_id = :idproducto"; // actualizo la valoracion
    } else {
        $sql = "INSERT INTO likes (producto_id, valoracion) VALUES (:idproducto, :valoracion)"; // o inserto la valoracion 
    }
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idproducto',$_GET['idproducto'],PDO::PARAM_INT);
    $stmt->bindParam(':valoracion',$_GET['valoracion'],PDO::PARAM_INT);
    $stmt->execute();

    $resultado = creaLikes($_GET['idproducto'],$_GET['valoracion']); // creo el resultado, que son los botones like/deslike para cada producto dependiendo de su valoracion
}

echo $resultado; // devuelvo el resultado