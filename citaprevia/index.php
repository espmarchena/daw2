<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form name="formu" id="formu" method="POST" action="control.php"> <!-- los datos se envían a control.php -->
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" required>
        <label for ="clave">Contraseña: </label>
        <input type="password" name="clave" id="clave" required>
        <input type="submit" value="Acceder">
    </form>

</body>
</html>