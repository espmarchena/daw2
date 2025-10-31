<?php

$nocontroles= true; //variable para que no controle la sesión en inc_libreria.php

include ('config.php'); //incluimos el archivo de configuración
include ('inc_libreria.php'); //incluimos las librerías de la logica de acceso a la bbdd

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
</head>
<body>
    
    <form name="formu" id="formu" method="POST" action="control.php"> <!-- los datos se envían a control.php -->
        <label for="nombre">Usuario: </label>
        <input type="text" name="nombre" id="nombre" required>
        <label for ="password">Contraseña: </label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Acceder">
    </form>

</body>
</html>