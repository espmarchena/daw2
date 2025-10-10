<?php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

//PARA REGISTRAR UN FICHAJE
$mensaje = '';
$fichado = false; //variable para saber si ya se ha fichado

if (isset($_POST['dni']) && isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['tipofichaje'])) { //si los campos existen
    
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //conectarse a la base de datos

    // VERIFICAR SI YA EXISTE UN FICHAJE DEL MISMO TIPO PARA ESE DÍA
    $sqlVerificar = 'SELECT * FROM fichajes 
                     WHERE dni = :dni AND fecha = :fecha AND tipofichaje = :tipofichaje';
    $stmtVerificar = $conexion->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
    $stmtVerificar->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
    $stmtVerificar->bindParam(':tipofichaje', $_POST['tipofichaje'], PDO::PARAM_STR);
    
    if ($stmtVerificar->execute()) { //si se ejecuta bien la consulta
        $existeFichaje = false;
        while ($fila = $stmtVerificar->fetch()) { // Verificamos si ya existe un fichaje
            $existeFichaje = true;
            break; //solo necesitamos saber si existe al menos uno
        }
        
        if ($existeFichaje) {
            $fichado = true; //ya existe un fichaje del mismo tipo para ese día
            $mensaje = "Ya existe un fichaje de " . ($_POST['tipofichaje'] == 'E' ? "entrada" : "salida") . " para este día"; //condicion ternaria para mostrar el tipo de fichaje
        } else {
            // SI ES SALIDA, VERIFICAR QUE EXISTE UNA ENTRADA
            if ($_POST['tipofichaje'] == 'S') {
                $sqlVerificarEntrada = 'SELECT * FROM fichajes 
                                       WHERE dni = :dni AND fecha = :fecha AND tipofichaje = "E"';
                $stmtVerificarEntrada = $conexion->prepare($sqlVerificarEntrada);
                $stmtVerificarEntrada->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
                $stmtVerificarEntrada->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
                
                if ($stmtVerificarEntrada->execute()) { //si se ejecuta bien la consulta
                    $existeEntrada = false;
                    while ($fila = $stmtVerificarEntrada->fetch()) { //verifico si ya existe una entrada
                        $existeEntrada = true;
                        break; //solo necesitamos saber si existe al menos uno
                    }
                    
                    if (!$existeEntrada) {
                        $fichado = false;
                        $mensaje = "No puedes fichar la salida sin haber fichado la entrada primero";
                    } else {
                        // INSERTAR FICHAJE DE SALIDA
                        $sql = 'INSERT INTO fichajes (dni, fecha, hora, tipofichaje) 
                                VALUES (:dni, :fecha, :hora, :tipofichaje)';
                        $stmt = $conexion->prepare($sql);
                        $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
                        $stmt->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
                        $stmt->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
                        $stmt->bindParam(':tipofichaje', $_POST['tipofichaje'], PDO::PARAM_STR);
                        
                        if ($stmt->execute()) { //si se ejecuta bien la consulta
                            $mensaje = "Salida registrada correctamente";
                            $fichado = true;
                        } else {
                            $mensaje = "Error al registrar la salida";
                        }
                    }
                } else {
                    $mensaje = "Error al verificar la entrada existente";
                }
            } else {
                // INSERTAR FICHAJE DE ENTRADA
                $sql = 'INSERT INTO fichajes (dni, fecha, hora, tipofichaje) 
                        VALUES (:dni, :fecha, :hora, :tipofichaje)';
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $_POST['fecha'], PDO::PARAM_STR);
                $stmt->bindParam(':hora', $_POST['hora'], PDO::PARAM_STR);
                $stmt->bindParam(':tipofichaje', $_POST['tipofichaje'], PDO::PARAM_STR);
                
                if ($stmt->execute()) { //si se ejecuta bien la consulta
                    $mensaje = "Entrada registrada correctamente";
                    $fichado = true;
                } else {
                    $mensaje = "Error al registrar la entrada";
                }
            }
        }
    } else {
        $mensaje = "Error al verificar fichajes existentes";
    }
} else {
    $mensaje = "Por favor, completa todos los campos para continuar.";
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
    <form name="formu" id="formu" method="POST" action="fichajes2.php">

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required value="">

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required value="">

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" required value="">

        <label for="tipofichaje">Tipo de Fichaje (Indica E o S):</label>
        <input type="text" name="tipofichaje" id="tipofichaje" required value="">

        <input type="submit" value="Fichar">
    </form>
        <ul>
        <?= $mensaje; ?> 
    </ul>


</body>
</html>
