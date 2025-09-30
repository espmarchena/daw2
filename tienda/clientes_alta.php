<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

if(!empty($_POST['nombre'])){
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //objeto PDO que conecta a la base de datos

    if(empty($_POST['apellido1'])){ //si el campo apellido1 está vacío
        $_POST['apellido1'] = ''; //le asigno valor vacío
    }
    else{
        $apellido1 = $_POST['apellido1']; //reasigno el valor del campo apellido1 a la variable apellido1
    }
    
    if(empty($_POST['apellido2'])){ //si el campo apellido2 está vacío
        $_POST['apellido2'] = ''; //le asigno valor vacío
    }
    else{
        $apellido2 = $_POST['apellido2']; //reasigno el valor del campo apellido2 a la variable apellido2
    }
    
    if(empty($_POST['vip'])){ //si el campo vip está vacío
        $_POST['vip'] = 0; //le asigno valor 0
    }
    else{
        $vip = $_POST['vip']; //reasigno el valor del campo vip a la variable vip
    }

    $sql = 'INSERT INTO clientes (nombre, apellido1, apellido2, vip) VALUES (:nombre, :apellido1, :apellido2, :vip);'; //consulta SQL para insertar un nuevo cliente con las variables capadas
    $stmt = $conexion->prepare($sql); //prepara la consulta
    $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
    $stmt->bindParam(':apellido1', $_POST['apellido1'], PDO::PARAM_STR);
    $stmt->bindParam(':apellido2', $_POST['apellido2'], PDO::PARAM_STR);
    $stmt->bindParam(':vip', $_POST['vip'], PDO::PARAM_STR);
    $stmt->execute(); //ejecuta la consulta
    $id = $conexion->lastInsertId(); //almaceno en la variable $id el id del último registro insertado

    header("Location: clientes.php?id=$id"); //redirecciona a la pagina de listado de clientes pasando el id del nuevo cliente
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Clientes</title>
</head>
<body>

    <form name="formu" id="formu" method="POST" action="clientes_alta.php">
        <label for="nombre">Nombre del cliente: </label>
        <input type="text" name="nombre" id="nombre" value="">
        
        <label for="apellido1">Primer apellido: </label>
        <input type="text" name="apellido1" id="apellido1" value="">
        
        <label for="apellido2">Segundo apellido: </label>
        <input type="text" name="apellido2" id="apellido2" value="">
        
        <label for="vip">Cliente VIP: </label>
        <input type="text" name="vip" id="vip" value="">
        
        <input type="submit" value="Registrar cliente">
    </form>

</body>
</html>