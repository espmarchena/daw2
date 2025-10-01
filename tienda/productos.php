<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

$filtros = '';
$precio = 0;
if (!empty($_POST['minimo']) && $_POST['minimo']>0) { //si el campo minimo no está vacío y es mayor que 0
    $precio = ($_POST['minimo']); //reasigno el valor del campo minimo a la variable precio
    $filtros .= ' AND precio > :precio'; //añado a la variable filtros la condicion AND precio > :precio
}

$producto = '';
if (!empty($_POST['producto'])) { //si el campo producto no está vacío
    $producto = '%'.$_POST['producto'].'%'; //reasigno el valor del campo producto a la variable producto
    $filtros .= ' AND producto LIKE :producto'; //añado a la variable filtros la condicion AND producto LIKE :producto
} 

$id = 0;
if(isset($_GET['id']) && $_GET['id']>0){ //si el id existe y es mayor que 0
    $filtros .= ' AND id = :id'; //añado a la variable filtros la condicion AND id = :id
}

$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos

$sql = "SELECT * FROM productos WHERE 1 $filtros;"; //consulta SQL para seleccionar todos los productos cuyo precio sea mayor que el valor de la variable precio y cuyo nombre contenga la palabra de la variable producto. Cuando el metodo prepare se encuentra con :precio o :producto lo que hace es sustituirlo por el valor de la variable correspondiente, de esta forma se evita la inyección SQL

$stmt = $conexion->prepare($sql); //prepara la consulta (instruccion encapsulada) y devuelve una consulta preparada

if($precio >0){ //solo se ejecuta el bindParam si el precio es mayor que 0
    $stmt->bindParam(':precio', $precio, PDO::PARAM_STR); //metodo que asocia el valor de la variable precio al marcador :precio en la consulta SQL
}

if($producto !=''){ //solo se ejecuta el bindParam si el producto no está vacío
$stmt->bindParam(':producto', $producto, PDO::PARAM_STR); //metodo que asocia el valor de la variable producto al marcador :producto en la consulta SQL, añadiendo los comodines % para buscar cualquier coincidencia que contenga la palabra
}

if($id > 0){ //solo se ejecuta el bindParam si el id es mayor que 0
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); //metodo que asocia el valor de la variable id al marcador :id en la consulta SQL
}

$stmt->execute(); //metodo que ejecuta la consulta


$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $link = '<a href="productos_alta.php?id='.$registro['id'].'">Editar </a>'; //crea un enlace para editar el producto que recibe en la url gracias al get
    $listado .= '<li>'.$link.$registro['producto'].': '.$registro['precio'].'</li>'; //almacena los productos en una lista
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
    <form name= "formu" id="formu" method="POST" action="productos.php"> <!-- formulario que envía los datos a la misma página -->
        Mostrar productos con precio superior a:
        <input type="text" name="minimo" id="minimo"> <!-- campo para mostrar productos con precio minimo -->

        o cuyo nombre contenga la palabra: 
        <input type="text" name="producto" id="producto"> <!-- campo para mostrar productos con nombre -->
        <input type="submit" value="Filtrar"> <!-- botón para filtrar productos -->
    </form>
    <hr> <!-- línea horizontal -->
    <ul>
        <?php echo $listado; //muestra la lista de productos ?>
    </ul>
</body>
</html>
