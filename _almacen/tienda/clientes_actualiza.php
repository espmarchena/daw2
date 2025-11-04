<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria


if(!empty($_GET['idcliente']) &&  isset($_GET['observaciones'])){ // si no esta vacio el id del cliente y existen observaciones ...

    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);

    $sql = "UPDATE clientes SET observaciones = :observaciones WHERE id = :idcliente";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idcliente', $_GET['idcliente'], PDO::PARAM_INT);
    $stmt->bindParam(':observaciones', $_GET['observaciones'], PDO::PARAM_STR);
    $stmt->execute();
}