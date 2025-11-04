<?php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //llamamos a la función que conecta con la bbdd
$sql = 'SELECT * FROM especialistas e
        JOIN especialidades esp ON e.idespecialidad = esp.idespecialidad
        WHERE esp.idespecialidad = :idespecialidad'; //inicializamos la variable sql para que seleccione las especialidades del usuario identificado
$stmt = $conexion->prepare($sql); //preparamos la consulta preparada
$stmt->bindParam(':idespecialidad', $_GET['idespecialidad'], PDO::PARAM_INT); //asignamos el valor del idusuario de la variable de sesión a la variable :idusuario, indicando que la procese como un entero
$stmt->execute(); //ejecutamos la consulta

//PARA LISTAR LAS ESPECIALIDADES
$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $idespecialista = $registro['idespecialista'];
    $especialista = $registro['nombre'].' '.$registro['apellido1'].' '.$registro['apellido2'];

    $listado .= "<li>$especialista <a href=\"pedircita.php?idespecialista=$idespecialista\">Pedir cita</a></li>"; //almacena los especialistas en una lista con sus nombres y apellidos (esto lo coge de las tablas de la bbdd)
    //$registro es un array asociativo que cambia de valor con cada iteración del while:
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
    <h1>Lista de especialistas de <?= $_GET['especialidad'] ?> </h1>
    <ul>
        <?= $listado; //muestra la lista de productos ?>
    </ul>

</body>
</html>