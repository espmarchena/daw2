<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos

$sql = 'SELECT * FROM productos'; //consulta SQL para seleccionar todos los productos
$stmt = $conexion->prepare($sql); //prepara la consulta
$stmt->execute(); //ejecuta la consulta

$listado='';
while ($reg = $stmt->fetch()) { //recorre los resultados de la consulta
    $listado .= '<li>'.$reg['producto'].': '.$reg['precio'].'</li>'; //almacena los productos en una lista
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
