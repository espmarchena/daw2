<?php
include('config.php'); //incluye el archivo de configuracion
include('inc_libreria.php'); //incluye el archivo de libreria

var_dump($_POST);

$precio = 0;
if (!empty($_POST['minimo']) && $_POST['minimo']>0) { //si el campo minimo no está vacío y es mayor que 0
    $precio = ($_POST['minimo']); //reasignoo el valor del campo minimo a la variable precio
}

$producto = '';
if (!empty($_POST['producto'])) { //si el campo producto no está vacío
    $producto = '%'.$_POST['producto'].'%'; //reasigno el valor del campo producto a la variable producto
} 


$conexion = conectarse($servidor,$usuariodb,$clavedb,$opcionesDB); //objeto PDO que conecta a la base de datos

$sql = 'SELECT * FROM productos WHERE precio > :precio AND producto LIKE :producto'; //consulta SQL para seleccionar todos los productos con precio mayor que el valor de la variable precio y filtrar por palabras que contengan el nombre del producto. Cuando el metodo prepare se encuentra con :precio lo que hace es sustituirlo por el valor de la variable precio, de esta forma se evita la inyección SQL
$stmt = $conexion->prepare($sql); //prepara la consulta (instruccion encapsulada) y devuelve una consulta preparada
$stmt->bindParam(':precio', $precio, PDO::PARAM_INT); //metodo que asocia el valor de la variable precio al marcador :precio en la consulta SQL
$stmt->bindParam(':producto', $producto, PDO::PARAM_STR); //metodo que asocia el valor de la variable producto al marcador :producto en la consulta SQL, añadiendo los comodines % para buscar cualquier coincidencia que contenga la palabra
$stmt->execute(); //metodo que ejecuta la consulta


$listado='';
while ($registro = $stmt->fetch()) { //recorre los resultados de la consulta (un fetch coge los datos brutos y los prepara en forma de matriz)
    $listado .= '<li>'.$registro['producto'].': '.$registro['precio'].'</li>'; //almacena los productos en una lista
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
    <form name= "formu" id="id" method="POST" action="productos.php"> <!-- formulario que envía los datos a la misma página -->
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
