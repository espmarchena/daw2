<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

//PARA FILTRAR LOS PRODUCTOS
$filtros = '';
$nombre = '';
if (!empty($_POST['nombre'])) { //si el campo nombre no está vacío
    $nombre = '%'.$_POST['nombre'].'%'; //reasigno el valor del campo nombre a la variable nombre
    $filtros .= ' AND nombre LIKE :nombre'; //añado a la variable filtros la condicion AND nombre LIKE :nombre
} 
    
$apellido1 = '';
if (!empty($_POST['apellido1'])) { //si el campo apellido1 no está vacío
    $apellido1 = '%'.$_POST['apellido1'].'%'; //reasigno el valor del campo apellido1 a la variable apellido1
    $filtros .= ' AND apellido1 LIKE :apellido1'; //añado a la variable filtros la condicion AND apellido1 LIKE :apellido1
} 

$apellido2 = '';
if (!empty($_POST['apellido2'])) { //si el campo apellido2 no está vacío
    $apellido2 = '%'.$_POST['apellido2'].'%'; //reasigno el valor del campo apellido2 a la variable apellido2
    $filtros .= ' AND apellido2 LIKE :apellido2'; //añado a la variable filtros la condicion AND apellido2 LIKE :apellido2
} 

$id = 0;
if(isset($_GET['id']) && $_GET['id']>0){ //si el id existe y es mayor que 0
    $id = $_GET['id']; //reasigno el valor del campo id a la variable id
    $filtros .= ' AND id = :id'; //añado a la variable filtros la condicion AND id = :id
}

//ESTA PAGINA SIEMPRE VA A NECESITAR CONEXION A LA BASE DE DATOS PORQUE ES LA QUE GENERA EL LISTADO DE PRODUCTOS
$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos


//PARA ELIMINAR UN CLIENTE
$iddelete = 0;
if(isset($_GET['iddelete']) && $_GET['iddelete']>0){ //si el iddelete existe y es mayor que 0
    $iddelete = $_GET['iddelete']; //almaceno en la variable $iddelete el id del cliente a eliminar
    $sql = "DELETE FROM clientes WHERE id = :iddelete;"; //consulta SQL para eliminar el cliente cuyo id sea igual al valor de la variable iddelete
    $stmt = $conexion->prepare($sql); //prepara la consulta
    $stmt->bindParam(':iddelete', $iddelete, PDO::PARAM_INT); //metodo que asocia el valor de la variable iddelete al marcador :iddelete en la consulta SQL
    $stmt->execute(); //ejecuta la consulta
}

//PARA LISTAR LOS PRODUCTOS 
$sql = "SELECT * FROM clientes WHERE 1 $filtros;"; //consulta SQL para seleccionar todos los clientes
$stmt = $conexion->prepare($sql); //prepara la consulta
if($nombre !=''){ //solo se ejecuta el bindParam si el nombre no está vacío
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR); //metodo que asocia el valor de la variable nombre al marcador :nombre en la consulta SQL
}
if($apellido1 !=''){ //solo se ejecuta el bindParam si el apellido1 no está vacío
    $stmt->bindParam(':apellido1', $apellido1, PDO::PARAM_STR); //metodo que asocia el valor de la variable apellido1 al marcador :apellido1 en la consulta SQL
}
if($apellido2 !=''){ //solo se ejecuta el bindParam si el apellido2 no está vacío
    $stmt->bindParam(':apellido2', $apellido2, PDO::PARAM_STR); //metodo que asocia el valor de la variable apellido2 al marcador :apellido2 en la consulta SQL
}
if($id > 0){ //solo se ejecuta el bindParam si el id es mayor que 0
    $stmt->bindParam(':id', $id, PDO::PARAM_STR); //metodo que asocia el valor de la variable id al marcador :id en la consulta SQL
}
$stmt->execute(); //metodo que ejecuta la consulta


//RECORRER LOS RESULTADOS DE LA CONSULTA Y CREAR EL LISTADO DE CLIENTES
$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $link = '<a href="clientes_alta.php?id='.$registro['id'].'" class="botoncito" title="Editar cliente">E </a>'; //crea un enlace para editar el cliente que recibe en la url gracias al get
    $link .= '<a href="javascript:confirmarBorrado('.$registro['id'].');" class="botoncito" title="Borrar cliente">B </a>'; //crea un enlace para eliminar el cliente que recibe en la url gracias al get, llamando a la funcion javascript confirmarBorrado
    $listado .= '<li>'.$link.$registro['nombre'].' '.$registro['apellido1'].' '.$registro['apellido2'].' '.$registro['vip'].'</li>'; //almacena los clientes en una lista
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
    <style>
        .botoncito{
            display: inline-block;  /* que se comporte como un enlace (etiqueta <a>) pero con propiedades de bloque */
            border: thin dashed rgb(255,170,0); /* borde punteado */
            background-color: rgb(255,255,140);
            padding: 5px; /* espacio interior */
    }
    </style>
    <script>
        function confirmarBorrado(idborrar){ //funcion que muestra un mensaje de confirmación antes de eliminar un cliente
            let respuesta = prompt("¿Está seguro de que desea eliminar el cliente con ID " + idborrar+"? Escriba 'SI' para confirmar.", "SI"); //muestra un cuadro de diálogo con un mensaje y una caja de texto para que el usuario escriba su respuesta
            if (respuesta === 'SI') { //si la respuesta es exactamente 'SI'
                window.location.href = 'clientes.php?iddelete=' + idborrar; //redirecciona a la misma página con el id del cliente a eliminar en la URL
            } else {
                alert('El cliente no ha sido eliminado.'); //muestra un mensaje indicando que el cliente no ha sido eliminado
            }
        }
    </script>
</head>
<body>
    <form name="formu" id="formu" method="POST" action="clientes.php"> <!-- formulario que envía los datos a la misma página -->
        Buscar cliente por nombre:
        <input type="text" name="nombre" id="nombre">

        Primer apellido:
        <input type="text" name="apellido1" id="apellido1">

        Segundo apellido:
        <input type="text" name="apellido2" id="apellido2">
        
        o por ID:
        <input type="text" name="id" id="buscarid">

        <input type="submit" value="Buscar"> <!-- botón para filtrar productos -->
    </form>
    <hr> <!-- línea horizontal -->
    <ul>
        <?php echo $listado; ?> <!-- muestra la lista de clientes -->
    </ul>
</body>
</html>