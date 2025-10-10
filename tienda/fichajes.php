<?php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

//PARA REGISTRAR UN FICHAJE
$mensaje = '';
$fichado = false; //variable para saber si ya se ha fichado
if (isset($_POST['dni']) && isset($_POST['fecha']) && isset($_POST['hora'])) { //si los campos existen
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //conectarse a la base de datos
    
    
    //INSERTAR DATOS DEL FICHATE DE ENTRADA EN LA BBDD
    $sql = 'INSERT INTO fichajes (dni, fecha, hora, tipofichaje) 
            VALUES (:dni, :fecha, :hora, :tipofichaje)';
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
    $stmt->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
    $tipo = 'E'; //tipo de fichaje: Entrada
    $stmt->bindParam(':tipofichaje', $tipo, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        $mensaje = "Fichaje registrado correctamente";
        $fichado = true; //variable para saber si ya se ha fichado
    } else {
        $mensaje = "Error al registrar el fichaje";
    }
}
else {
    $mensaje = "Por favor, completa todos los campos para continuar.";
}

    //INSERTAR DATOS DEL FICHATE DE SALIDA EN LA BBDD
    if($fichado && $tipofichaje == 'S') {
        $sqlVerificarEntrada = 'SELECT * FROM fichajes 
                                       WHERE dni = :dni AND fecha = :fecha AND tipofichaje = "E"';
        $stmtVerificarEntrada = $conexion->prepare($sqlVerificarEntrada);
        $stmtVerificarEntrada->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
        $stmtVerificarEntrada->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);

        $sql = 'INSERT INTO fichajes (dni, fecha, hora, tipofichaje) 
                VALUES (:dni, :fecha, :hora, :tipofichaje)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
        $stmt->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
        $tipo = 'S'; //tipo de fichaje: Salida
        $stmt->bindParam(':tipofichaje', $tipo, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $mensaje = "Fichaje registrado correctamente";
        } else {
            $mensaje = "Error al registrar el fichaje";
        }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Fichajes</title>
</head>
<body>
    <h1>Sistema de Fichajes. Introduce tus datos:</h1>
    <form name="formu" id="formu" method="POST" action="fichajes.php">

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required value="">

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required value="">

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" required value="">

        <input type="submit" value="Fichar">
    </form>
        <ul>
        <?= $mensaje; ?> 
    </ul>


</body>
</html>
