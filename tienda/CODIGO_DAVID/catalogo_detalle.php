<?php
include('config.php');
include('inc_libreria.php');

$resultado = '';

if(!empty($_GET['idcat'])){
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB);
    $sql = "SELECT * FROM productos WHERE categoria_id = :idcat;";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idcat',$_GET['idcat'],PDO::PARAM_INT);
    $stmt->execute();
    while($reg = $stmt->fetch()){
        $resultado.= '<div class="caja_item">';
            $resultado.= '<div class="marco"><img src="img/'.$reg['foto'].'" alt="'.$reg['producto'].'"></div>';
            $resultado.= '<div class="info">'.$reg['producto'].'</div>';
            $resultado.= '<div class="info">'.$reg['precio'].'</div>';
            $resultado.= '<div class="info">'.$reg['descripcion'].'</div>';
        $resultado.= '</div>';
    }
}



