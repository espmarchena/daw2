<?php

session_start(); //sirve para conectarse a la sesion para poder manejar las variables de sesion que recuerdan los datos de acceso del usuario
//se crean 2 ficheros, uno en archivos temporales (cookies) del cliente q contiene un token (con el id de la sesion), y el otro en el servidor que asocia el token con la sesion

//variables con valores predeterminados que a lo largo del script pueden cambiar
$mensaje = '';
$visible = 'block'; //controla la visibilidad del formulario a traves de la propiedad display de css

if(empty($_SESSION['jugando'])){ //si la variable jugando esta vacia, inicializa la partida

    $_SESSION['candado'] = [ // array para generar numeros aleatorios 
        rand(0,9),  // para el primer digito 
        rand(0,9),  // para el segundo digito
        rand(0,9)   // para el tercer digito 
    ];
    $_SESSION['intentos'] = 1; //variable de sesion que contiene el contador del numero de intentos
    $_SESSION['jugando'] = 1; //variable de control
    $_SESSION['posicion_actual'] = 0; //primer dígito (posición 0) que luego irá incrementando si se van adivinando los dígitos
    $_SESSION['adivinados'] = [false, false, false]; // para controlar qué posiciones se han adivinado

    var_dump($_SESSION['candado']); //muestro la combinación secreta en la consola para pruebas
}

if(!empty($_POST['intento'])){ //condicion que solo se ejecuta si existe y no esta vacia la variable

    $digitoIntento = $_POST['intento']; //igualo la variable intento al valor que me ha enviado el usuario
    $digitoCorrecto= $_SESSION['candado'][$_SESSION['posicion_actual']]; //obtengo el dígito correcto de la posición actual
    $posicion = $_SESSION['posicion_actual']; //obtengo la posición actual
        
        if($digitoIntento == $digitoCorrecto){ // verifico el dígito actual
            $mensaje = "Oleee! El dígito secreto es: " . $digitoCorrecto;
            $_SESSION['adivinados'][$posicion] = true; //ha adivinado el digito en la posición actual
            
            $_SESSION['posicion_actual']++; //paso a la siguiente posicion de digitos
            
            
            if($_SESSION['posicion_actual'] >= 3){ // verifico si ya ha adivinado todos los digitos
                $combinacion = $_SESSION['candado'][0] . $_SESSION['candado'][1] . $_SESSION['candado'][2]; //combinacion completa
                $mensaje = "Yihaaaa! Adivinaste el candado completo: " . $combinacion . " en " . $_SESSION['intentos'] . " intentos";
                $visible = 'none'; //oculto el formulario asignandole display none
                $_SESSION['jugando'] = 0; //corto y le doy fin a la partida. Se reinician los intentos y el adivina (el numero random)
            }
        } else if($digitoIntento < $digitoCorrecto){
            $mensaje = "Pono, ta quedao corto. El dígito secreto es mayor a " . $digitoIntento . ". Intenta con un número más alto.";
        } else {
            $mensaje = "Pono, tapasao. El dígito secreto es menor a " . $digitoIntento . ". Intenta con un número más bajo.";
        }
        
        $_SESSION['intentos']++; //incremento el contador de intentos
        
        if($_SESSION['intentos'] > 10){ //límite de intentos
            $combinacion = $_SESSION['candado'][0] . $_SESSION['candado'][1] . $_SESSION['candado'][2];
            $mensaje = "Ohhhhh pringao. Fin de la partida. La combinación era: " . $combinacion;
            $visible = 'none'; //oculto el formulario asignandole display none
            $_SESSION['jugando'] = 0; //corto y le doy fin a la partida. Se reinician los intentos y el adivina (el numero random)
        }
        
    } else {
        $mensaje = "enga, teclea un dígito del 0 al 9";
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Candado</title>
</head>
<body>
    <h1>Adivina el candado de 3 dígitos</h1>

    <p>Intento número: <?php echo $_SESSION['intentos']; ?></p>
    <p><?php echo $mensaje; ?></p>

    <div<?php echo $visible; ?>>
        <form name="formu" id ="formu" method="POST" action="candado.php">
            <input type="text" name="intento" id="intento" title="Teclea un dígito" > <!-- para crear la caja de texto en la que el usuario mete su numero -->
		<!-- el name es lo que vamos a usar para enviarle los datos al servidor -->
            <input type="submit" value="Probar combinación"> <!-- para crear el boton de enviar el numero al servidor -->
        </form>
    </div>
    <div>
        <table border = "1"> <!-- estilo para que se vean las lineas de la tabla -->
            <tr> 
                <td><?php if($_SESSION['adivinados'][0] == true){ //controlo que cambie de '?' al numero correcto usando la posicion del array booleano que declaré antes en cada caso
                    echo $_SESSION['candado'][0];
                } else {
                    echo "?";
                }
                ?></td>
            </tr>
            <tr>
                <td><?php if($_SESSION['adivinados'][1] == true){ ///controlo que cambie de '?' al numero correcto usando la posicion del array booleano que declaré antes en cada caso
                    echo $_SESSION['candado'][1];
                } else {
                    echo "?";
                }
                ?></td>
            </tr>
            <tr>
                <td><?php if($_SESSION['adivinados'][2] == true){ ///controlo que cambie de '?' al numero correcto usando la posicion del array booleano que declaré antes en cada caso
                    echo $_SESSION['candado'][2];
                } else {
                    echo "?";
                }
                ?></td>
            </tr>
        </table>
    </div>
        <a href="cerrar.php?redire=candado.php">Jugar de nuevo</a> <!-- link para cerrar sesion y redireccionarse automaticamente a adivina2 (a sí misma).php para jugar de nuevo desde cero -->
    </div>

</body>
</html>