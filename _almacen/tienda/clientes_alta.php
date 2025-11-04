<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

//PARA DAR DE ALTA UN CLIENTE
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

        if(empty($_POST['dni'])){ //si el campo dni está vacío
        $_POST['dni'] = ''; //le asigno valor vacío
    }
    else{
        $dni = $_POST['dni']; //reasigno el valor del campo dni a la variable dni
    }

    //PARA ACTUALIZAR UN CLIENTE
    if(isset($_POST['idupdate']) && $_POST['idupdate']>0){ //si el idupdate existe y es mayor que 0
        $id = $_POST['idupdate']; //reasigno el valor del campo idupdate a la variable id
        $sql = 'UPDATE clientes SET nombre = :nombre, apellido1 = :apellido1, apellido2 = :apellido2, vip = :vip, dni = :dni WHERE id = :id;'; //consulta SQL para actualizar el cliente con las variables capadas
        $stmt = $conexion->prepare($sql); //prepara la consulta
        $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido1', $_POST['apellido1'], PDO::PARAM_STR);
        $stmt->bindParam(':apellido2', $_POST['apellido2'], PDO::PARAM_STR);
        $stmt->bindParam(':vip', $_POST['vip'], PDO::PARAM_STR);
        $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute(); //ejecuta la consulta
    }
    else{ //PARA INSERTAR UN NUEVO CLIENTE
    $sql = 'INSERT INTO clientes (nombre, apellido1, apellido2, vip) VALUES (:nombre, :apellido1, :apellido2, :vip, :dni);'; //consulta SQL para insertar un nuevo cliente con las variables capadas
    $stmt = $conexion->prepare($sql); //prepara la consulta
    $stmt->bindParam(':nombre', $_POST['nombre'], PDO::PARAM_STR);
    $stmt->bindParam(':apellido1', $_POST['apellido1'], PDO::PARAM_STR);
    $stmt->bindParam(':apellido2', $_POST['apellido2'], PDO::PARAM_STR);
    $stmt->bindParam(':vip', $_POST['vip'], PDO::PARAM_STR);
    $stmt->bindParam(':dni', $_POST['dni'], PDO::PARAM_STR);
    $stmt->execute(); //ejecuta la consulta
    $id = $conexion->lastInsertId(); //almaceno en la variable $id el id del último registro insertado
    }
    header("Location: clientes.php?id=$id"); //redirecciona a la pagina de listado de clientes pasando el id del nuevo cliente
}

//PARA EDITAR UN CLIENTE
$id = 0;
$datos = array(
    'nombre' => '',
    'apellido1' => '',      
    'apellido2' => '',
    'vip' => '0',
    'dni' => ''
);
if(isset($_GET['id']) && $_GET['id']>0){ //si el id existe y es mayor que 0
    $id = $_GET['id']; //reasigno el valor del campo id a la variable id
    $conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos
    $sql = "SELECT * FROM clientes WHERE id = :id;"; //consulta SQL para seleccionar el cliente cuyo id sea igual al valor de la variable id
    $stmt = $conexion->prepare($sql); //prepara la consulta (instruccion encapsulada) y devuelve una consulta preparada
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); //metodo que asocia el valor de la variable id al marcador :id en la consulta SQL
    $stmt->execute(); //metodo que ejecuta la consulta
    $datos = $stmt->fetch(); //almacena el resultado de la consulta en el array $datos con el metodo fetch
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Clientes</title>
    <script src="js/ajax.js" type="text/javascript"></script>
</head>
<body>

    <form name="formu" id="formu" method="POST" action="clientes_alta.php">
        <input type="hidden" name="idupdate" id="idupdate" value="<?= $id; ?>"> <!-- campo oculto para almacenar el id del cliente a actualizar -->

        <label for="nombre">Nombre del cliente: </label>
        <input type="text" name="nombre" id="nombre" value="<?= $datos['nombre'] ?>">
        
        <label for="apellido1">Primer apellido: </label>
        <input type="text" name="apellido1" id="apellido1" value="<?= $datos['apellido1'] ?>">
        
        <label for="apellido2">Segundo apellido: </label>
        <input type="text" name="apellido2" id="apellido2" value="<?= $datos['apellido2'] ?>">

        <label for="vip">Cliente VIP: </label>
        <input type="text" name="vip" id="vip" value="<?= $datos['vip'] ?>">

        <br>

        <label for="dni">DNI: </label>
        <input type="text" name="dni" id="dni" value="<?= $datos['dni'] ?>">
        <span id="avisodni"> </span> <!-- capadestino del ajax -->

        <input type="submit" value="Registrar cliente">
    </form>

    <script>
        // 
        document.addEventListener('DOMContentLoaded', function(){

            document.getElementById('dni').addEventListener('change', function(){

                let url = 'clientes_dni.php?dni='+document.getElementById('dni').value;
                cargarContenido(url,'avisodni');
            });

        });

    </script>

</body>
</html>