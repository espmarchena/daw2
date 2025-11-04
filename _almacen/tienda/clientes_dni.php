<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

$resultado = "";

if(!empty($_GET['dni'])){ //si no est vacio el dni
    $conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); 

    $sql = "SELECT nombre, apellido1 FROM clientes WHERE dni = :dni;"; 
    $stmt = $conexion->prepare($sql); 
    $stmt->bindParam(':dni', $_GET['dni'], PDO::PARAM_STR); 
    $stmt->execute(); 
    $registro = $stmt->fetch(); 

    if($registro){ // si hay registros... 
        $resultado = "Ya existe un cliente con ese DNI: {$registro['nombre']} {$registro['apellido1']}";
    }
    else{
        $resultado = "DNI válido";
    }
}

echo $resultado;