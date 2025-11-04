<?php
include('config.php');
include('inc_libreria.php');

$resultado = '';

if(!empty($_GET['idcat'])){ // si la variable de la url no esta vacia
    $conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); // objeto PDO que conecta a la base de datos 

    $sql = "SELECT *
            FROM productos2
            WHERE id_categoria = :idcat;";
    $stmt = $conexion->prepare($sql); // prepara la consulta
    $stmt-> bindParam(':idcat', $_GET['idcat'], PDO::PARAM_INT);
    $stmt->execute(); // ejecuta la consulta

    while ($reg = $stmt->fetch()){
        $resultado.='<div class = "caja_item">';
            $resultado.='<div class = "marco"><img src="images/'.$reg['foto'].'" alt="'.$reg['nombre_producto'].'"> </div>';
            $resultado.='<div class = "info">'.$reg['nombre_producto'].'</div>';
            $resultado.='<div class = "info">'.$reg['precio'].'</div>';
            $resultado.='<div class = "info">'.$reg['descripcion'].'</div>';
        $resultado.='</div>';
    }
} 



echo $resultado;