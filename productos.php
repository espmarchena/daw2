<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos

$sql = 'SELECT * FROM productos'; //consulta SQL para seleccionar todos los productos
$stmt = $conexion->prepare($sql); //prepara la consulta
$stmt->execute(); //ejecuta la consulta

$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $listado .= '<li>'.$registro['producto'].': '.$registro['precio'].'</li>'; //almacena los productos en una lista
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
