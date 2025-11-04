<?php


include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //llamamos a la función que conecta con la bbdd
$sql = 'SELECT * FROM especialidades e
        JOIN usuarios_especialidades ue ON e.idespecialidad = ue.idespecialidad
        WHERE ue.idusuario = :idusuario'; //inicializamos la variable sql para que seleccione las especialidades del usuario identificado
$stmt = $conexion->prepare($sql); //preparamos la consulta preparada
$stmt->bindParam(':idusuario', $_SESSION['idusuario'], PDO::PARAM_INT); //asignamos el valor del idusuario de la variable de sesión a la variable :idusuario, indicando que la procese como un entero
$stmt->execute(); //ejecutamos la consulta

//PARA LISTAR LAS ESPECIALIDADES
$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $idespecialidad = $registro['idespecialidad'];
    $especialidad = $registro['especialidad'];

    $listado .= "<li>$especialidad <a href=\"especialistas.php?idespecialidad=$idespecialidad&especialidad=$especialidad\">Pedir cita</a></li>"; //almacena las especialidades en una lista con sus nombres y apellidos (esto lo coge de las tablas de la bbdd)
    //$registro es un array asociativo que cambia de valor con cada iteración del while: $registro[][]
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
    <h1>Lista de especialidades: </h1>
    <ul>
        <?= $listado; //muestra la lista de productos ?>
    </ul>

</body>
</html>