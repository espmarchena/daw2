<?php

include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

//PARA DAR DE ALTA UN PRODUCTO
if(!empty($_POST['producto'])){
    $conexion = conectarse($servidor, $usuariodb, $clavedb, $opcionesDB); //objeto PDO que conecta a la base de datos

    if(empty($_POST['precio'])){ //si el campo precio está vacío
        $_POST['precio']=0; //si el campo precio está vacío, le asigno el valor 0
    }
    else{
        $precio = $_POST['precio']; //reasigno el valor del campo precio a la variable precio
    }

    $sql = 'INSERT INTO productos (producto, precio) VALUES (:producto, :precio);'; //consulta SQL para insertar un nuevo producto con las variables capadas
    $stmt = $conexion->prepare($sql); //prepara la consulta
    $stmt->bindParam(':producto', $_POST['producto'], PDO::PARAM_STR);
    $stmt->bindParam(':precio', $_POST['precio'], PDO::PARAM_STR);
    $stmt->execute(); //ejecuta la consulta
    $id = $conexion->lastInsertId(); //almaceno en la variable $id el id del último registro insertado

    header("Location: productos.php?id=$id"); //header es para manipular la info de la cabecera que se le manda al cliente, se posiciona arriba del todo y REDIRECCIONA a la pagina de listado de productos antes que nada, pasando el id del nuevo producto insertado por la URL(post)
    
}

//PARA EDITAR UN PRODUCTO
$id = 0;
$datos = array(
    'producto' => '',
    'precio' => ''
);
if(isset($_GET['id']) && $_GET['id']>0){ //si el id existe y es mayor que 0
    $id = $_GET['id']; //reasigno el valor del campo id a la variable id
    $conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos
    $sql = "SELECT * FROM productos WHERE id = :id;"; //consulta SQL para seleccionar el producto cuyo id sea igual al valor de la variable id
    $stmt = $conexion->prepare($sql); //prepara la consulta (instruccion encapsulada) y devuelve una consulta preparada
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); //metodo que asocia el valor de la variable id al marcador :id en la consulta SQL
    $stmt->execute(); //metodo que ejecuta la consulta
    $datos = $stmt->fetch(); //almacena el resultado de la consulta en el array $datos con el fetch
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de productos</title>
</head>
<body>

    <form name="formu" id="formu" method="POST" action="productos_alta.php">
        <label for="producto">Nombre del producto: </label> <!-- accesibilidad y posicionamiento. El for hace referenci/se asocia al id del input -->
        <input type="text" name="producto" id="producto" value="<?= $datos['producto'] ?>"> <!-- en el value insertará el valor del producto -->

        <label for="precio">Precio del producto: </label> <!-- accesibilidad y posicionamiento. El for hace referenci/se asocia al id del input -->
        <input type="text" name="precio" id="precio" value="<?= $datos['precio'] ?>"> <!-- en el value insertará el valor del precio -->

        <input type="submit" value="Registrar datos"> <!-- boton para enviar el formulario al servidor -->
    </form>

</body>
</html>