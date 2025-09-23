<?php

session_start(); //sirve para conectarse a la sesion para poder manejar las variables de sesion que recuerdan los datos de acceso del usuario
//se crean 2 ficheros, uno en archivos temporales (cookies) del cliente q contiene un token (con el id de la sesion), y el otro en el servidor que asocia el token con la sesion

//variables con valores predeterminados que a lo largo del script pueden cambiar
$mensaje = ''; //mensaje que se muestra al usuario
$visible = 'block'; //controla la visibilidad del formulario a traves de la propiedad display de css

if(empty($_SESSION['jugando'])){ //si la variable jugando esta vacia, inicializa la partida (hasta este punto aun no esta inicializada), si no lo controlamos, cada vez que recarguemos la pagina se reiniciaria la partida

	$_SESSION['adivina'] = rand(1,100); //variable de sesion que contiene el numero random
	$_SESSION['intentos'] = 1; //variable de sesion que contiene el contador del numero de intentos
	$_SESSION['jugando'] = 1; //variable de control. Al no dejarla vacia (inicializarla a 1) indica que ya hemos iniciado la partida
}

//var_dump($_SESSION);

if(!empty($_POST['minumero'])){ //condicion que solo se ejecuta si existe y no esta vacia la variable (si ha recibido un numero)

	if ($_SESSION['adivina'] == $_POST['minumero']){ //comprobamos si el usuario ha tecleado el numero correcto
		$mensaje = "adivinaste el número";
		$visible = 'none'; //oculto el formulario asignandole display none
		$_SESSION['jugando'] = 0; //corto y le doy fin a la partida. Se reinician los intentos y el adivina (el numero random)
	}
	else if($_SESSION['adivina'] < $_POST['minumero']){
		$mensaje = "tu número es menor a ".$_POST['minumero'] ;
	}
	else{
		$mensaje = "tu número es mayor a ".$_POST['minumero'];
	}
	$_SESSION['intentos']++; //incremento el contador de intentos. Si ponemos fuera aumenta en todos los casos

		if($_SESSION['intentos'] >10){
		$mensaje = "fin de la partida. Mi número era ". $_SESSION['adivina'];
		$visible = 'none'; //oculto el formulario asignandole display none
		$_SESSION['jugando'] = 0; //corto y le doy fin a la partida. Se reinician los intentos y el adivina (el numero random)
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<p>Estamos en el intento número <?php echo $_SESSION['intentos'] ?></p>
<p><?php echo $mensaje; ?></p>

<div style="display:<?php echo $visible ?>;"> <!-- para manipular la visibilidad del form -->
	<form name="formu" id ="formu" method="POST" action="adivina2.php">

		<input type="text" name="minumero" id="minumero"> <!-- para crear la caja de texto en la que el usuario mete su numero -->
		<!-- el name es lo que vamos a usar para enviarle los datos al servidor -->

		<input type="submit" value="Adivinar"> <!-- para crear el boton de enviar el numero al servidor -->

	</form>
</div>

<div>
	<a href="cerrar.php?redire=adivina2.php">Jugar de nuevo </a> <!-- link para cerrar sesion y redireccionarse automaticamente a adivina2 (a sí misma).php para jugar de nuevo desde cero -->
</div>
</body>
</html>