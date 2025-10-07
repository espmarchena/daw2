<?php //no cerramos la etiqueta pq este archivo solo va a llevar php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

$patras = true; //inicializamos la variable que indica si debe volver atrás, por defecto es true

if(!empty($_POST['usuario']) && !empty($_POST['clave'])){ //comprobamos si recibe info y si no están vacíos

    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //llamamos a la función que conecta con la bbdd
    $sql = 'SELECT * FROM usuarios WHERE usuario = :usuario'; //inicializamos la variable sql
    $stmt = $conexion->prepare($sql); //preparamos la consulta preparada
    $stmt->bindParam(':usuario', $_POST['usuario'], PDO::PARAM_STR); //asignamos el valor del campo usuario a la variable :usuario, indicando que la procese como una cadena de texto
    $stmt->execute(); //ejecutamos la consulta


    if($reg = $stmt->fetch()){ //si el fetch da false, el usuario no existe y no entra. Si es true, si hay datos y se asignan a $reg

        //verificamos que la clave introducida coincide con la de la base de datos, si es incorrecta no entra en el if
        //el metodo password_verify(clave introducida por el usuario (no encriptada), clave de la bbdd (encriptada)), devuelve true o false
        if(password_verify($_POST['clave'], $reg['clave'])){ //si la clave es correcta (true), se ha identificado al usuario
            $_SESSION['idusuario'] = $reg['idusuario']; //creamos la variable de sesión de usuario que recoge el id del usuario
            $_SESSION['usuario'] = $reg['usuario']; //creamos la variable de sesión de usuario que recoge el nombre del usuario
            $patras = false; //indicamos que no debe volver al index.php pq se ha identificado correctamente
            header('Location: especialidades.php'); //redireccionamos al usuario a la página de especialidades para coger su cita medica
            exit; //por si falla la redirección
        }
    }
}

//noentra($patras, 0); //si $patras es true, vuelve al index.php con el mensaje de error 0 (identificación incorrecta), si es false no hace nada

