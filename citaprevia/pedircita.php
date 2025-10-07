<?php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

if(empty($_GET['idespecialista'])){ //si no recibe el id del especialista, vuelve a especialidades.php
    header('Location: especialidades.php');
    exit; //por si falla la redirección
}
else{ // el idespecialista lo recibe por la url y hay que añadirlo al action del formu para que lo reciba al enviarse el formulario al clicar en 'pedir cita'
    $idespecialista = $_GET['idespecialista']; //si lo recibe, lo almacena en la variable $idespecialista
}

$conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //llamamos a la función que conecta con la bbdd

//PARA INSERTAR LA CITA
if(!empty($_POST['fechacita']) && !empty($_POST['horacita'])){ //si recibe la fecha y la hora de la cita
    $sql = 'INSERT INTO citas (fechacita, horacita, idespecialista, idusuario) VALUES (:fechacita, :horacita, :idespecialista, :idusuario)'; //inicializamos la variable sql para insertar la cita en la bbdd
    $stmt = $conexion->prepare($sql); //preparamos la consulta preparada
    $stmt->bindParam(':fechacita', $_POST['fechacita'], PDO::PARAM_STR); //asignamos el valor del campo fechacita a la variable :fechacita, indicando que la procese como una cadena de texto. Los post llegan de la cabecera del formulario. Los campos date tienen que ir en tipo canonico aaaa-mm-dd
    $stmt->bindParam(':horacita', $_POST['horacita'], PDO::PARAM_STR); //asignamos el valor del campo horacita a la variable :horacita, indicando que la procese como una cadena de texto. Los post llegan de la cabecera del formulario
    $stmt->bindParam(':idespecialista', $idespecialista, PDO::PARAM_INT); //asignamos el valor del idespecialista a la variable :idespecialista, indicando que la procese como un entero
    $stmt->bindParam(':idusuario', $_SESSION['idusuario'], PDO::PARAM_INT); //asignamos el valor del idusuario a la variable :idusuario, indicando que la procese como un entero
    $stmt->execute(); //ejecutamos la consulta
    header('Location: especialidades.php'); //redireccionamos al usuario a la página de especialidades para coger su cita medica
    exit; //por si falla la redirección
} 
else{ //si no recibe la fecha y la hora de la cita, muestra el formulario
    //buscamos datos de la especialidad y del especialista seleccionado
    $sql = 'SELECT e.nombre, e.apellido1, e.apellido2, esp.especialidad, esp.idespecialidad FROM especialistas e
            JOIN especialidades esp ON e.idespecialidad = esp.idespecialidad
            WHERE e.idespecialista = :idespecialista'; //inicializamos la variable sql
    $stmt = $conexion->prepare($sql); //preparamos la consulta preparada
    $stmt->bindParam(':idespecialista', $idespecialista, PDO::PARAM_INT); //asignamos el valor del idespecialista de la variable $idespecialista a la variable :idespecialista, indicando que la procese como un entero
    $stmt->execute(); //ejecutamos la consulta

    $registro = $stmt->fetch(); //cogemos los datos del especialista y la especialidad (solo hay uno pq el id es único)
    $especialista = $registro['nombre'].' '.$registro['apellido1'].' '.$registro['apellido2'];
    $idespecialidad = $registro['idespecialidad'];
    $especialidad = $registro['especialidad'];
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir Cita</title>
</head>
<body>
    <h1>Petición de cita médica Especialidad de <?= $registro['especialidad'] ?> </h1>
    <p>Especialista: <?= $especialista ?> </p>
    <p> <!-- enlaces para cambiar de especialidad o especialista -->
        <a href="especialidades.php">Cambiar Especialidad</a>
        <a href="especialistas.php?idespecialidad=<?= $idespecialidad ?>&especialidad=<?= $especialidad ?>"> Cambiar Especialista</a>
    </p>

    <form name="formu" id="formu" method="POST" action="pedircita.php?idespecialista=<?= $idespecialista ?>"> <!-- cuando le damos a 'pedir cita' los datos se envían a sí mismo, pedircita.php, añadiendole el idespecialista para que sepa cual es el especialista que se ha seleccionado, sino te devuelve atras (especialidades.php) -->

        <label for ="fechacita">Fecha de la cita: </label>
        <input type="date" name="fechacita" id="fechacita" required value="<?= $registro['fechacita'] ?>"> <!-- el name viaja por el post, para el php, el id se queda en el cliente, para js, css.... Los campos 'date' tienen que ir en tipo canonico aaaa-mm-dd-->
        <!-- si ponemos antes de cerrar la etiqueta input: onchange="alert(this.value)"; para depurar, significa que cuando cambie el valor, lo muestre en pantalla -->

        <label for ="horacita">Hora de la cita: </label>
        <input type="time" name="horacita" id="horacita" required value="<?= $registro['horacita'] ?> "> <!-- el name viaja por el post, para el php, el id se queda en el cliente, para js, css.... -->

        <input type="submit" value="Pedir cita"> <!-- el value aqui es para poner lo que quiero que ponga el boton -->
    
    </form>

</body>
</html>