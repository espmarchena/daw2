<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

var_dump($_POST);

$nombre = '';
$apellido1 = '';
$apellido2 = '';

if (!empty($_POST['nombre']) && !empty($_POST['apellido1']) && !empty($_POST['apellido2'])) { //si los campos no están vacíos
    $nombre = '%'.$_POST['nombre'].'%'; //reasigno el valor del campo nombre a la variable nombre, añadiendo los comodines % para buscar cualquier coincidencia que contenga la palabra
    $apellido1 = '%'.$_POST['apellido1'].'%'; //reasigno el valor del campo apellido1 a la variable apellido1, añadiendo los comodines % para buscar cualquier coincidencia que contenga la palabra
    $apellido2 = '%'.$_POST['apellido2'].'%'; //reasigno el valor del campo apellido2 a la variable apellido2, añadiendo los comodines % para buscar cualquier coincidencia que contenga la palabra
    
    $conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos

    $sql = 'SELECT * FROM clientes WHERE nombre LIKE :nombre AND apellido1 LIKE :apellido1 AND apellido2 LIKE :apellido2'; //consulta SQL para seleccionar todos los clientes cuyo nombre y apellidos contengan las palabras buscadas. Cuando el metodo prepare se encuentra con :nombre, :apellido1 o :apellido2 lo que hace es sustituirlo por el valor de la variable correspondiente, de esta forma se evita la inyección SQL
    
    $stmt = $conexion->prepare($sql); //prepara la consulta
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR); 
    $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR);
    $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR);
    $stmt->execute(); //ejecuta la consulta

    $listado='';
    while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta
        $listado .= '<li>'.$registro['nombre'].' '.$registro['apellido1'].' '.$registro['apellido2'].'</li>'; //almacena los clientes en una lista
    }
    

    if (empty($listado)) { //si no hay resultados
        $listado = '<li>No se encontraron clientes con esos datos</li>';
    }
} else {
    $listado = '<li>Por favor, complete todos los campos para realizar la búsqueda</li>';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Clientes</title>
</head>
<body>
    <h1>Búsqueda de Clientes</h1>
    <hr>
    <form name="formu" id="formu" method="POST" action="clientes.php">
        <div>
            Nombre:
            <input type="text" name="nombre" id="nombre">
        </div>
        <div>
            Primer Apellido:
            <input type="text" name="apellido1" id="apellido1">
        </div>
        <div>
            Segundo Apellido:
            <input type="text" name="apellido2" id="apellido2">
        </div>
        <input type="submit" value="Buscar Cliente">
    </form>
    <hr>
    <h2>Resultados de la búsqueda:</h2>
    <ul>
        <?php echo $listado;?> <!--muestra la lista de clientes -->
    </ul>
</body>
</html>